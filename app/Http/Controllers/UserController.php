<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AdminSetting;
use App\Models\ProfileSuggestion;
use App\Models\UserMatch;
use App\Models\MatchPayment;
use App\Models\Couple;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get pending suggestions for this user
        $suggestions = ProfileSuggestion::where('user_id', $user->id)
            ->where('status', 'pending')
            ->with('suggestedUser')
            ->get();

        // Get matches
        $matches = UserMatch::where(function ($q) use ($user) {
            $q->where('user1_id', $user->id)
              ->orWhere('user2_id', $user->id);
        })->with(['user1', 'user2', 'payments'])->get();

        // Get unread notifications
        $notifications = $user->notifications()->unread()->latest()->take(5)->get();

        // Check if user is part of a couple
        $couple = Couple::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
            ->with(['user1', 'user2'])
            ->first();

        // Calculate counts for dashboard display
        $matchesCount = $matches->count();
        $suggestionsCount = $suggestions->count();

        return view('user.dashboard', compact('user', 'suggestions', 'matches', 'notifications', 'couple', 'matchesCount', 'suggestionsCount'));
    }

    public function showPayment()
    {
        $user = Auth::user();
        
        // Skip payment if user is already verified or has active status (approved by admin)
        if ($user->registration_verified || $user->status === 'active') {
            return redirect()->route('user.dashboard')->with('success', 'Your account is already verified. No payment required.');
        }

        $registrationFee = AdminSetting::getRegistrationFee();
        $paymentQR = AdminSetting::getPaymentQRCode();
        $paymentUPI = AdminSetting::getPaymentUPI();
        
        // Payment gateway settings
        $razorpayEnabled = AdminSetting::isRazorpayEnabled();
        $razorpayKeyId = AdminSetting::getRazorpayKeyId();
        $googlePayEnabled = AdminSetting::isGooglePayEnabled();

        return view('user.payment', compact(
            'user', 
            'registrationFee', 
            'paymentQR', 
            'paymentUPI',
            'razorpayEnabled',
            'razorpayKeyId',
            'googlePayEnabled'
        ));
    }

    public function submitPayment(Request $request)
    {
        $request->validate([
            'payment_screenshot' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $user = Auth::user();
        
        $screenshotPath = $request->file('payment_screenshot')->store('payment_screenshots', 'public');

        $user->update([
            'registration_payment_screenshot' => $screenshotPath,
            'registration_paid' => true,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Payment screenshot uploaded. Please wait for admin verification.');
    }

    public function verifyRazorpayPayment(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
        ]);

        $user = Auth::user();
        
        try {
            $keyId = AdminSetting::getRazorpayKeyId();
            $keySecret = AdminSetting::getRazorpayKeySecret();
            
            // Verify payment with Razorpay API
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payments/' . $request->razorpay_payment_id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $keyId . ':' . $keySecret);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode !== 200) {
                return response()->json(['success' => false, 'message' => 'Payment verification failed'], 400);
            }
            
            $payment = json_decode($response, true);
            
            // Check if payment is captured/authorized
            if (in_array($payment['status'], ['captured', 'authorized'])) {
                $expectedAmount = AdminSetting::getRegistrationFee() * 100; // Amount in paise
                
                if ($payment['amount'] >= $expectedAmount) {
                    // Update user as verified
                    $user->update([
                        'registration_verified' => true,
                        'registration_paid' => true,
                        'razorpay_payment_id' => $request->razorpay_payment_id,
                        'status' => 'active',
                    ]);
                    
                    return response()->json([
                        'success' => true, 
                        'message' => 'Payment verified successfully!'
                    ]);
                }
            }
            
            return response()->json(['success' => false, 'message' => 'Payment not completed'], 400);
            
        } catch (\Exception $e) {
            \Log::error('Razorpay verification error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Verification error'], 500);
        }
    }

    public function suggestions()
    {
        $user = Auth::user();
        
        // Only show PENDING suggestions (not already accepted/rejected)
        $suggestions = ProfileSuggestion::where('user_id', $user->id)
            ->pending() // Only show suggestions user hasn't responded to yet
            ->with('suggestedUser')
            ->latest()
            ->paginate(10);

        // Get users who have REJECTED the current user
        // (suggestions where current user was suggested to someone else and they rejected)
        $rejectedByUsers = ProfileSuggestion::where('suggested_user_id', $user->id)
            ->where('status', 'rejected')
            ->pluck('user_id')
            ->toArray();

        // Mark all unviewed suggestions as viewed
        ProfileSuggestion::where('user_id', $user->id)
            ->where('viewed', false)
            ->update([
                'viewed' => true,
                'viewed_at' => now(),
            ]);

        return view('user.suggestions', compact('suggestions', 'rejectedByUsers'));
    }

    public function respondToSuggestion(Request $request, ProfileSuggestion $suggestion)
    {
        if ($suggestion->user_id !== Auth::id()) {
            abort(403);
        }

        // Accept both 'action' and 'response' parameters for backward compatibility
        $action = $request->input('action') ?? $request->input('response');
        
        $request->merge(['response' => $action]);
        
        $request->validate([
            'response' => 'required|in:accept,reject,accepted,rejected',
        ]);

        // Normalize action to 'accepted' or 'rejected'
        $status = in_array($action, ['accept', 'accepted']) ? 'accepted' : 'rejected';

        $suggestion->update([
            'status' => $status,
            'responded_at' => now(),
        ]);

        $currentUser = Auth::user();
        $otherUser = User::find($suggestion->suggested_user_id);

        if ($status === 'accepted') {
            // Check if the other user has also accepted (mutual match)
            $match = $this->checkForMutualMatch($suggestion);
            
            if ($match) {
                // MUTUAL MATCH! Both users accepted - Now redirect to payment
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => "It's a match! 🎉 Both of you accepted. Please complete payment to exchange contacts.",
                        'redirect_url' => route('user.matches.payment', $match->id),
                        'has_match' => true
                    ]);
                }
                
                return redirect()->route('user.matches.payment', $match->id)
                    ->with('success', "It's a match! 🎉 Please complete the payment to exchange contact details.");
            } else {
                // One-sided acceptance - Just notify and wait for other user
                // Notify the other user that someone accepted their profile
                Notification::create([
                    'user_id' => $suggestion->suggested_user_id,
                    'title' => 'Someone Liked Your Profile! 💕',
                    'message' => "{$currentUser->full_name} has accepted your profile. Check your suggestions and respond!",
                    'type' => 'like',
                    'related_id' => $suggestion->id,
                    'related_type' => 'suggestion',
                ]);
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Profile accepted! ✅ Waiting for them to accept you back.',
                        'has_match' => false
                    ]);
                }
                
                return redirect()->route('user.suggestions')
                    ->with('success', 'Profile accepted! ✅ You will be notified when they respond. If both accept, you can proceed to payment.');
            }
        } else {
            // Rejected - Notify the other user
            Notification::create([
                'user_id' => $suggestion->suggested_user_id,
                'title' => 'Profile Response',
                'message' => "Unfortunately, {$currentUser->full_name} has passed on your profile. Don't worry, there are more matches waiting for you!",
                'type' => 'system',
                'related_id' => $suggestion->id,
                'related_type' => 'suggestion',
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profile rejected.'
                ]);
            }
            
            return redirect()->route('user.suggestions')
                ->with('success', 'Response recorded.');
        }
    }

    protected function checkForMutualMatch(ProfileSuggestion $suggestion)
    {
        // Check if the other user also accepted
        $reverseAcceptance = ProfileSuggestion::where('user_id', $suggestion->suggested_user_id)
            ->where('suggested_user_id', $suggestion->user_id)
            ->where('status', 'accepted')
            ->exists();

        if ($reverseAcceptance) {
            // MUTUAL MATCH! Both users have accepted each other
            // Now create match and payment records
            
            $match = UserMatch::firstOrCreate([
                'user1_id' => min($suggestion->user_id, $suggestion->suggested_user_id),
                'user2_id' => max($suggestion->user_id, $suggestion->suggested_user_id),
            ], [
                'status' => 'pending_payment',
            ]);

            // Create payment records for BOTH users (mutual match = full amount)
            $paymentAmount = AdminSetting::getFullPaymentAmount(); // Full amount for mutual match
            $paymentType = 'full'; // 'full' for mutual match, 'half' for one-sided

            foreach ([$match->user1_id, $match->user2_id] as $userId) {
                $payment = MatchPayment::firstOrCreate([
                    'match_id' => $match->id,
                    'user_id' => $userId,
                ], [
                    'amount' => $paymentAmount,
                    'payment_type' => $paymentType,
                    'status' => 'pending',
                ]);

                // Notify both users about the match
                if ($payment->wasRecentlyCreated) {
                    $otherUserId = $userId == $match->user1_id ? $match->user2_id : $match->user1_id;
                    $otherUser = User::find($otherUserId);
                    
                    Notification::create([
                        'user_id' => $userId,
                        'title' => "It's a Match! 🎉💕",
                        'message' => "Great news! You and {$otherUser->full_name} both accepted each other! Complete payment of ₹{$paymentAmount} to exchange contact details.",
                        'type' => 'match',
                        'related_id' => $match->id,
                        'related_type' => 'match',
                        'action_url' => route('user.matches.payment', $match->id),
                        'action_text' => 'Pay Now',
                    ]);
                }
            }
            
            return $match;
        }
        
        return null;
    }

    public function getSuggestionDetails(ProfileSuggestion $suggestion)
    {
        // Verify the suggestion belongs to the authenticated user
        if ($suggestion->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        // Load the suggested user with all necessary details
        $suggestion->load('suggestedUser');

        // Get all gallery images with full URLs
        $galleryImages = [];
        if ($suggestion->suggestedUser->gallery_images && is_array($suggestion->suggestedUser->gallery_images)) {
            foreach ($suggestion->suggestedUser->gallery_images as $image) {
                $galleryImages[] = asset('storage/' . $image);
            }
        }

        return response()->json([
            'success' => true,
            'suggestion' => [
                'id' => $suggestion->id,
                'status' => $suggestion->status,
                'suggested_user' => [
                    'id' => $suggestion->suggestedUser->id,
                    'full_name' => $suggestion->suggestedUser->full_name,
                    'age' => $suggestion->suggestedUser->age,
                    'location' => $suggestion->suggestedUser->location,
                    'bio' => $suggestion->suggestedUser->bio,
                    'keywords' => $suggestion->suggestedUser->keywords,
                    'instagram_id' => $suggestion->suggestedUser->instagram_id,
                    'gallery_images' => $galleryImages,
                    'is_verified' => $suggestion->suggestedUser->registration_verified ?? false,
                ]
            ]
        ]);
    }

    public function matches()
    {
        $user = Auth::user();
        
        $matchRecords = UserMatch::where(function ($q) use ($user) {
            $q->where('user1_id', $user->id)
              ->orWhere('user2_id', $user->id);
        })->with(['user1', 'user2', 'payments'])->latest()->get();

        // Transform matches to show partner users with match metadata
        $matches = collect($matchRecords)->map(function ($match) use ($user) {
            // Get the partner (the other user in the match)
            $partner = $match->user1_id === $user->id ? $match->user2 : $match->user1;
            
            // Add match metadata to partner object
            $partner->match_id = $match->id;
            $partner->match_status = $match->status;
            $partner->match_created_at = $match->created_at;
            $partner->user_payment = $match->payments->where('user_id', $user->id)->first();
            $partner->partner_payment = $match->payments->where('user_id', $partner->id)->first();
            
            // Check if contacts are unlocked (both payments verified)
            $partner->contact_unlocked = $match->allPaymentsVerified();
            
            return $partner;
        });

        return view('user.matches', compact('matches'));
    }

    public function showMatchPayment(UserMatch $match)
    {
        $user = Auth::user();
        
        if ($match->user1_id !== $user->id && $match->user2_id !== $user->id) {
            abort(403);
        }

        $payment = MatchPayment::where('match_id', $match->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $paymentQR = AdminSetting::getPaymentQRCode();
        $paymentUPI = AdminSetting::getPaymentUPI();

        $partner = $match->user1_id === $user->id ? $match->user2 : $match->user1;

        return view('user.match-payment', compact('match', 'payment', 'paymentQR', 'paymentUPI', 'partner'));
    }

    public function submitMatchPayment(Request $request, UserMatch $match)
    {
        $user = Auth::user();
        
        if ($match->user1_id !== $user->id && $match->user2_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'payment_screenshot' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'transaction_id' => 'nullable|string|max:255',
        ]);

        $payment = MatchPayment::where('match_id', $match->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $screenshotPath = $request->file('payment_screenshot')->store('match_payments', 'public');

        $payment->update([
            'payment_screenshot' => $screenshotPath,
            'transaction_id' => $request->transaction_id,
            'status' => 'submitted',
        ]);

        // Refresh match to get updated payments
        $match->refresh();
        $match->load('payments');

        // Check if both users have submitted or verified their payments
        $submittedOrVerifiedCount = $match->payments()
            ->whereIn('status', ['submitted', 'verified'])
            ->count();
        
        // Get the other user's ID
        $otherUserId = $user->id === $match->user1_id ? $match->user2_id : $match->user1_id;
        $otherPayment = $match->payments()->where('user_id', $otherUserId)->first();
        
        // Update match status based on payment submissions
        if ($submittedOrVerifiedCount >= 2) {
            // Both users have submitted/verified their payments
            $match->update(['status' => 'payment_submitted']);
            
            // Notify the other user if their payment is still pending
            if ($otherPayment && $otherPayment->status === 'pending') {
                Notification::create([
                    'user_id' => $otherUserId,
                    'title' => 'Payment Reminder',
                    'message' => 'Your match partner has completed their payment. Please complete yours to proceed!',
                    'type' => 'info',
                    'related_id' => $match->id,
                    'related_type' => 'match',
                ]);
            }
            
            $message = 'Payment submitted! Both payments received. Waiting for admin verification.';
        } else {
            // Only one user has submitted, keep as pending_payment
            $match->update(['status' => 'pending_payment']);
            
            // Check if other user has even accepted yet (payment record exists)
            if (!$otherPayment) {
                $message = 'Payment submitted! Waiting for the other person to accept and pay.';
            } else {
                $message = 'Payment submitted! Waiting for your match partner to submit their payment.';
                
                // Notify the other user to submit payment
                Notification::create([
                    'user_id' => $otherUserId,
                    'title' => 'Payment Reminder',
                    'message' => 'Your match partner has completed their payment. Please complete yours to proceed!',
                    'type' => 'info',
                    'related_id' => $match->id,
                    'related_type' => 'match',
                ]);
            }
        }

        return redirect()->route('user.matches')->with('success', $message);
    }

    public function notifications()
    {
        // Mark all notifications as read when user visits this page
        Auth::user()->notifications()->unread()->update([
            'is_read' => true,
        ]);
        
        $notifications = Auth::user()->notifications()
            ->with(['profileSuggestion' => function($query) {
                $query->with('suggestedUser');
            }])
            ->latest()
            ->paginate(20);
        
        return view('user.notifications', compact('notifications'));
    }

    public function markNotificationRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->markAsRead();

        return back();
    }

    public function markAllNotificationsRead()
    {
        Auth::user()->notifications()->unread()->update([
            'is_read' => true,
        ]);

        return back()->with('success', 'All notifications marked as read.');
    }

    public function profile()
    {
        $user = Auth::user();
        $keywords = ['Hot', 'Handsome', 'Beautiful', 'FWB', 'Friendship', 'Long-term Relationship', 'Casual Dating', 'Marriage'];
        
        return view('user.profile', compact('user', 'keywords'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'whatsapp_number' => 'nullable|string|max:15',
            'dob' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
            'keywords' => 'nullable|string|max:500',
            'expectation' => 'nullable|string|max:500',
            'expected_keywords' => 'nullable|string|max:500',
            'preferred_age_min' => 'nullable|integer|min:13|max:60',
            'preferred_age_max' => 'nullable|integer|min:13|max:60',
            'gallery_images' => 'nullable|array|max:6',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg|max:5120',
            'gallery_order' => 'nullable|string',
            'removed_images' => 'nullable|string',
            'live_photo_data' => 'nullable|string',
        ]);

        // Handle gallery images with reordering and removal
        $currentGallery = $user->gallery_images ?? [];
        
        // Process removed images
        $removedImages = [];
        if ($request->filled('removed_images')) {
            $removedImages = json_decode($request->removed_images, true) ?? [];
            // Delete removed images from storage
            foreach ($removedImages as $removedPath) {
                if (!empty($removedPath) && \Storage::disk('public')->exists($removedPath)) {
                    \Storage::disk('public')->delete($removedPath);
                }
            }
        }
        
        // Process gallery order (existing images in new order)
        $galleryPaths = [];
        if ($request->filled('gallery_order')) {
            $orderedImages = json_decode($request->gallery_order, true) ?? [];
            // Filter out removed images and validate they exist in current gallery
            foreach ($orderedImages as $imagePath) {
                if (!empty($imagePath) && 
                    in_array($imagePath, $currentGallery) && 
                    !in_array($imagePath, $removedImages)) {
                    $galleryPaths[] = $imagePath;
                }
            }
        } else {
            // No reorder - keep current gallery minus removed images
            foreach ($currentGallery as $imagePath) {
                if (!in_array($imagePath, $removedImages)) {
                    $galleryPaths[] = $imagePath;
                }
            }
        }
        
        // Handle new gallery image uploads
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                if (count($galleryPaths) < 6) {
                    $galleryPaths[] = $image->store('gallery_images', 'public');
                }
            }
        }

        // Handle live photo from camera
        $liveImagePath = $user->live_image;
        if ($request->filled('live_photo_data')) {
            $imageData = $request->live_photo_data;
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $type = strtolower($type[1]);
                $imageData = base64_decode($imageData);
                
                if ($imageData !== false) {
                    $filename = 'live_photos/' . uniqid() . '.' . $type;
                    \Storage::disk('public')->put($filename, $imageData);
                    $liveImagePath = $filename;
                }
            }
        }

        // Parse keywords from comma-separated string to array
        $keywords = null;
        if ($request->filled('keywords')) {
            $keywords = array_map('trim', explode(',', $request->keywords));
            $keywords = array_filter($keywords);
        }

        $expectedKeywords = null;
        if ($request->filled('expected_keywords')) {
            $expectedKeywords = array_map('trim', explode(',', $request->expected_keywords));
            $expectedKeywords = array_filter($expectedKeywords);
        }

        $user->update([
            'full_name' => $validated['full_name'],
            'whatsapp_number' => $validated['whatsapp_number'] ?? $user->whatsapp_number,
            'dob' => $validated['dob'] ?? $user->dob,
            'gender' => $validated['gender'] ?? $user->gender,
            'location' => $validated['location'] ?? $user->location,
            'bio' => $validated['bio'] ?? $user->bio,
            'keywords' => $keywords ?? $user->keywords,
            'expectation' => $validated['expectation'] ?? $user->expectation,
            'expected_keywords' => $expectedKeywords ?? $user->expected_keywords,
            'preferred_age_min' => $validated['preferred_age_min'] ?? $user->preferred_age_min,
            'preferred_age_max' => $validated['preferred_age_max'] ?? $user->preferred_age_max,
            'gallery_images' => $galleryPaths,
            'live_image' => $liveImagePath,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }
}
