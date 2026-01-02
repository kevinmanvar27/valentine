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

        return view('user.dashboard', compact('user', 'suggestions', 'matches', 'notifications', 'couple'));
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
        
        $suggestions = ProfileSuggestion::where('user_id', $user->id)
            ->with('suggestedUser')
            ->latest()
            ->paginate(10);

        // Mark all unviewed suggestions as viewed
        ProfileSuggestion::where('user_id', $user->id)
            ->where('viewed', false)
            ->update([
                'viewed' => true,
                'viewed_at' => now(),
            ]);

        return view('user.suggestions', compact('suggestions'));
    }

    public function respondToSuggestion(Request $request, ProfileSuggestion $suggestion)
    {
        if ($suggestion->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'response' => 'required|in:accepted,rejected',
        ]);

        $suggestion->update([
            'status' => $request->response,
            'responded_at' => now(),
        ]);

        // Check if both users have accepted each other
        if ($request->response === 'accepted') {
            $this->checkForMutualMatch($suggestion);
        }

        return back()->with('success', 'Response recorded successfully!');
    }

    protected function checkForMutualMatch(ProfileSuggestion $suggestion)
    {
        // Check if the other user also accepted
        $reverseAcceptance = ProfileSuggestion::where('user_id', $suggestion->suggested_user_id)
            ->where('suggested_user_id', $suggestion->user_id)
            ->where('status', 'accepted')
            ->exists();

        if ($reverseAcceptance) {
            // Create a match
            $match = UserMatch::firstOrCreate([
                'user1_id' => min($suggestion->user_id, $suggestion->suggested_user_id),
                'user2_id' => max($suggestion->user_id, $suggestion->suggested_user_id),
            ], [
                'status' => 'pending_payment',
            ]);

            // Create payment records for both users
            $paymentAmount = $match->getPaymentAmount();
            $paymentType = $match->getPaymentType();

            foreach ([$match->user1_id, $match->user2_id] as $userId) {
                MatchPayment::firstOrCreate([
                    'match_id' => $match->id,
                    'user_id' => $userId,
                ], [
                    'amount' => $paymentAmount,
                    'payment_type' => $paymentType,
                    'status' => 'pending',
                ]);

                // Notify users
                Notification::create([
                    'user_id' => $userId,
                    'title' => 'Match Found!',
                    'message' => "Congratulations! You have a mutual match. Please complete the payment of ₹{$paymentAmount} to exchange contact details.",
                    'type' => 'success',
                ]);
            }
        }
    }

    public function matches()
    {
        $user = Auth::user();
        
        $matches = UserMatch::where(function ($q) use ($user) {
            $q->where('user1_id', $user->id)
              ->orWhere('user2_id', $user->id);
        })->with(['user1', 'user2', 'payments'])->latest()->paginate(10);

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
        ]);

        $payment = MatchPayment::where('match_id', $match->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $screenshotPath = $request->file('payment_screenshot')->store('match_payments', 'public');

        $payment->update([
            'payment_screenshot' => $screenshotPath,
            'status' => 'submitted',
        ]);

        $match->update(['status' => 'payment_submitted']);

        return redirect()->route('user.matches')->with('success', 'Payment screenshot uploaded. Waiting for verification.');
    }

    public function notifications()
    {
        $notifications = Auth::user()->notifications()->latest()->paginate(20);
        
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
            'live_photo_data' => 'nullable|string',
        ]);

        // Handle gallery images
        $galleryPaths = $user->gallery_images ?? [];
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
