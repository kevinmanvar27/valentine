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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistics
        $totalUsers = User::where('is_admin', false)->count();
        $pendingVerifications = User::where('registration_paid', true)
            ->where('registration_verified', false)
            ->count();
        $activeUsers = User::where('status', 'active')->count();
        $totalMatches = UserMatch::count();
        $totalCouples = Couple::count();
        $pendingPayments = MatchPayment::where('status', 'submitted')->count();

        // Users by location
        $usersByLocation = User::where('is_admin', false)
            ->select('location', DB::raw('count(*) as count'))
            ->groupBy('location')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Users by gender
        $usersByGender = User::where('is_admin', false)
            ->select('gender', DB::raw('count(*) as count'))
            ->groupBy('gender')
            ->get();

        // Recent registrations
        $recentUsers = User::where('is_admin', false)
            ->latest()
            ->take(5)
            ->get();

        // Revenue stats
        $totalRevenue = MatchPayment::where('status', 'verified')->sum('amount');
        $registrationRevenue = User::where('registration_verified', true)->count() * AdminSetting::getRegistrationFee();

        return view('admin.dashboard', compact(
            'totalUsers',
            'pendingVerifications',
            'activeUsers',
            'totalMatches',
            'totalCouples',
            'pendingPayments',
            'usersByLocation',
            'usersByGender',
            'recentUsers',
            'totalRevenue',
            'registrationRevenue'
        ));
    }

    public function users(Request $request)
    {
        $query = User::where('is_admin', false);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('whatsapp_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('keyword')) {
            $query->whereJsonContains('keywords', $request->keyword);
        }

        $users = $query->latest()->paginate(20);
        $locations = User::distinct()->pluck('location');
        $keywords = ['Hot', 'Handsome', 'Beautiful', 'FWB', 'Friendship', 'Long-term Relationship', 'Casual Dating', 'Marriage'];

        return view('admin.users', compact('users', 'locations', 'keywords'));
    }

    public function showUser(User $user)
    {
        $user->load([
            'sentSuggestions.suggestedUser',    // Profiles suggested TO this user
            'receivedSuggestions.user',          // This user's profile shared to others
            'payments.match'
        ]);
        
        return view('admin.user-detail', compact('user'));
    }

    public function pendingVerifications()
    {
        $users = User::where('registration_paid', true)
            ->where('registration_verified', false)
            ->latest()
            ->paginate(20);

        return view('admin.pending-verifications', compact('users'));
    }

    public function verifyRegistration(Request $request, User $user)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'reason' => 'required_if:action,reject|nullable|string',
        ]);

        if ($request->action === 'approve') {
            $user->update([
                'registration_verified' => true,
                'status' => 'active',
            ]);

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Registration Approved',
                'message' => 'Your registration has been verified. You can now receive profile suggestions.',
                'type' => 'success',
            ]);
        } else {
            $user->update([
                'registration_paid' => false,
                'registration_payment_screenshot' => null,
            ]);

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Payment Rejected',
                'message' => "Your payment was rejected. Reason: {$request->reason}. Please submit a valid payment screenshot.",
                'type' => 'error',
            ]);
        }

        return back()->with('success', 'Verification action completed.');
    }

    public function matchmaking(Request $request)
    {
        // Get all active users for the dropdown
        $allUsers = User::where('is_admin', false)
            ->where('status', 'active')
            ->where('registration_verified', true)
            ->orderBy('full_name')
            ->get();

        $selectedUser = null;
        $sharedProfiles = collect();
        $potentialMatches = collect();
        $locations = User::distinct()->pluck('location')->filter();
        $keywords = ['Hot', 'Handsome', 'Beautiful', 'FWB', 'Friendship', 'Long-term Relationship', 'Casual Dating', 'Marriage'];

        // Rejected profiles (to show warning indicator)
        $rejectedProfiles = collect();

        // If a user is selected
        if ($request->filled('user_id')) {
            $selectedUser = User::with(['sentSuggestions.suggestedUser'])->find($request->user_id);
            
            if ($selectedUser) {
                // Get profiles already shared with this user
                $sharedProfiles = $selectedUser->sentSuggestions()
                    ->with('suggestedUser')
                    ->latest()
                    ->get();

                // Get profiles that were REJECTED by this user (to show warning)
                $rejectedProfiles = $selectedUser->sentSuggestions()
                    ->where('status', 'rejected')
                    ->pluck('suggested_user_id');

                // Get opposite gender
                $oppositeGender = $selectedUser->gender === 'male' ? 'female' : ($selectedUser->gender === 'female' ? 'male' : null);

                // Build query for potential matches
                $matchQuery = User::where('is_admin', false)
                    ->where('status', 'active')
                    ->where('registration_verified', true)
                    ->where('id', '!=', $selectedUser->id);

                // Filter by opposite gender
                if ($oppositeGender) {
                    $matchQuery->where('gender', $oppositeGender);
                }

                // AUTO-APPLY USER'S LOCATION FILTER (unless manually overridden)
                if ($request->filled('filter_location')) {
                    // Manual filter selected
                    $matchQuery->where('location', 'like', "%{$request->filter_location}%");
                } else {
                    // Auto-apply user's city location
                    if (!empty($selectedUser->location)) {
                        $matchQuery->where('location', 'like', "%{$selectedUser->location}%");
                    }
                }

                // Apply multiple keywords filter
                $filterKeywords = $request->input('filter_keywords', []);
                if (!empty($filterKeywords) && is_array($filterKeywords)) {
                    $matchQuery->where(function ($q) use ($filterKeywords) {
                        foreach ($filterKeywords as $keyword) {
                            $q->orWhereJsonContains('keywords', $keyword);
                        }
                    });
                }

                $potentialMatches = $matchQuery->latest()->get();
            }
        }

        return view('admin.matchmaking', compact(
            'allUsers', 
            'selectedUser', 
            'sharedProfiles', 
            'potentialMatches', 
            'locations', 
            'keywords',
            'rejectedProfiles'
        ));
    }

    public function suggestProfile(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'suggested_user_id' => 'required|exists:users,id|different:user_id',
        ]);

        $user = User::findOrFail($request->user_id);
        $suggestedUser = User::findOrFail($request->suggested_user_id);
        
        // Check if user can receive more suggestions (max 5 pending)
        $pendingCount = $user->sentSuggestions()->where('status', 'pending')->count();
        if ($pendingCount >= 5) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This user already has 5 pending suggestions.',
                    'pending_count' => $pendingCount
                ]);
            }
            return back()->with('error', 'This user already has 5 pending suggestions.');
        }

        // Check if this exact suggestion already exists (same user + same suggested profile)
        $exists = ProfileSuggestion::where('user_id', $request->user_id)
            ->where('suggested_user_id', $request->suggested_user_id)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This profile is already pending for this user.',
                    'pending_count' => $pendingCount
                ]);
            }
            return back()->with('error', 'This profile is already pending for this user.');
        }

        // Create suggestion for User A to see User B's profile
        $suggestion = ProfileSuggestion::create([
            'user_id' => $request->user_id,
            'suggested_user_id' => $request->suggested_user_id,
            'status' => 'pending',
        ]);

        // Notify User A (receiver) with actionable notification
        Notification::create([
            'user_id' => $request->user_id,
            'title' => 'New Profile Suggestion',
            'message' => "We have a special profile suggestion for you: {$suggestedUser->full_name}. Check it out and respond!",
            'type' => 'profile_suggestion',
            'related_id' => $suggestion->id,
            'related_type' => 'profile_suggestion',
        ]);

        // Create reverse suggestion for User B to see User A's profile (bidirectional)
        $reverseSuggestion = ProfileSuggestion::firstOrCreate(
            [
                'user_id' => $request->suggested_user_id,
                'suggested_user_id' => $request->user_id,
            ],
            [
                'status' => 'pending',
            ]
        );

        // Notify User B (suggested user) that their profile was shared
        if ($reverseSuggestion->wasRecentlyCreated) {
            Notification::create([
                'user_id' => $request->suggested_user_id,
                'title' => 'Profile Shared',
                'message' => "Your profile has been shared with {$user->full_name}. Check out their profile and respond!",
                'type' => 'profile_suggestion',
                'related_id' => $reverseSuggestion->id,
                'related_type' => 'profile_suggestion',
            ]);
        }

        $newPendingCount = $user->sentSuggestions()->where('status', 'pending')->count();

        if ($request->expectsJson()) {
            // Return the newly created suggestion with full user data for real-time append
            $suggestion->load('suggestedUser');
            
            return response()->json([
                'success' => true,
                'message' => 'Profiles shared successfully! Both users have been notified.',
                'pending_count' => $newPendingCount,
                'suggestion' => [
                    'id' => $suggestion->id,
                    'status' => $suggestion->status,
                    'created_at' => $suggestion->created_at->diffForHumans(),
                    'suggested_user' => [
                        'id' => $suggestedUser->id,
                        'full_name' => $suggestedUser->full_name,
                        'age' => $suggestedUser->age,
                        'location' => $suggestedUser->location,
                        'live_image' => $suggestedUser->live_image,
                    ]
                ]
            ]);
        }

        return redirect()->route('admin.matchmaking', ['user_id' => $request->user_id])
            ->with('success', 'Profiles shared successfully! Both users have been notified.');
    }

    public function revokeSuggestion(ProfileSuggestion $suggestion)
    {
        // Only allow revoking pending suggestions
        if ($suggestion->status !== 'pending') {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending suggestions can be revoked.'
                ]);
            }
            return back()->with('error', 'Only pending suggestions can be revoked.');
        }

        $userId = $suggestion->user_id;
        $suggestionId = $suggestion->id;
        
        // Notify user about revocation
        Notification::create([
            'user_id' => $userId,
            'title' => 'Profile Suggestion Revoked',
            'message' => 'A profile suggestion has been revoked by admin.',
            'type' => 'info',
        ]);
        
        $suggestion->delete();

        if (request()->expectsJson()) {
            // Get updated pending count
            $pendingCount = ProfileSuggestion::where('user_id', $userId)
                ->where('status', 'pending')
                ->count();

            return response()->json([
                'success' => true,
                'message' => 'Suggestion revoked successfully.',
                'pending_count' => $pendingCount,
                'suggestion_id' => $suggestionId
            ]);
        }

        return back()->with('success', 'Suggestion revoked successfully.');
    }

    public function setMatch(Request $request)
    {
        $request->validate([
            'user1_id' => 'required|exists:users,id',
            'user2_id' => 'required|exists:users,id|different:user1_id',
        ]);

        $user1 = User::findOrFail($request->user1_id);
        $user2 = User::findOrFail($request->user2_id);

        // Check if match already exists
        $existingMatch = UserMatch::where(function ($q) use ($user1, $user2) {
            $q->where('user1_id', $user1->id)->where('user2_id', $user2->id);
        })->orWhere(function ($q) use ($user1, $user2) {
            $q->where('user1_id', $user2->id)->where('user2_id', $user1->id);
        })->first();

        if ($existingMatch) {
            return back()->with('error', 'A match between these users already exists.');
        }

        // Create the match
        $match = UserMatch::create([
            'user1_id' => $user1->id,
            'user2_id' => $user2->id,
            'status' => 'pending',
        ]);

        // Notify both users
        Notification::create([
            'user_id' => $user1->id,
            'title' => 'New Match!',
            'message' => "You have been matched with {$user2->full_name}! Check your matches to proceed.",
            'type' => 'match',
        ]);

        Notification::create([
            'user_id' => $user2->id,
            'title' => 'New Match!',
            'message' => "You have been matched with {$user1->full_name}! Check your matches to proceed.",
            'type' => 'match',
        ]);

        return back()->with('success', "Match created successfully between {$user1->full_name} and {$user2->full_name}.");
    }

    public function matches()
    {
        $matches = UserMatch::with(['user1', 'user2', 'payments', 'couple'])
            ->latest()
            ->paginate(20);

        return view('admin.matches', compact('matches'));
    }

    public function pendingPayments()
    {
        $payments = MatchPayment::where('status', 'submitted')
            ->with(['match.user1', 'match.user2', 'user'])
            ->latest()
            ->paginate(20);

        return view('admin.pending-payments', compact('payments'));
    }

    public function verifyMatchPayment(Request $request, MatchPayment $payment)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes' => 'nullable|string',
        ]);

        if ($request->action === 'approve') {
            $payment->update([
                'status' => 'verified',
                'verified_at' => now(),
                'admin_notes' => $request->notes,
            ]);

            Notification::create([
                'user_id' => $payment->user_id,
                'title' => 'Payment Verified',
                'message' => 'Your payment has been verified successfully.',
                'type' => 'success',
            ]);

            // Check if both payments are verified
            $match = $payment->match;
            if ($match->allPaymentsVerified()) {
                $this->createCouple($match);
            }
        } else {
            $payment->update([
                'status' => 'rejected',
                'admin_notes' => $request->notes,
            ]);

            Notification::create([
                'user_id' => $payment->user_id,
                'title' => 'Payment Rejected',
                'message' => "Your payment was rejected. Reason: {$request->notes}. Please submit a valid payment.",
                'type' => 'error',
            ]);
        }

        return back()->with('success', 'Payment verification action completed.');
    }

    protected function createCouple(UserMatch $match)
    {
        // Create couple record
        $couple = Couple::create([
            'match_id' => $match->id,
            'user1_id' => $match->user1_id,
            'user2_id' => $match->user2_id,
            'coupled_at' => now(),
        ]);

        // Update match status
        $match->update(['status' => 'completed']);

        // Update user statuses
        User::whereIn('id', [$match->user1_id, $match->user2_id])
            ->update(['status' => 'matched']);

        // Share WhatsApp numbers
        $user1 = $match->user1;
        $user2 = $match->user2;

        Notification::create([
            'user_id' => $user1->id,
            'title' => 'Congratulations! Contact Shared',
            'message' => "Your valentine partner's WhatsApp: {$user2->whatsapp_number}. Happy Valentine's Day!",
            'type' => 'success',
        ]);

        Notification::create([
            'user_id' => $user2->id,
            'title' => 'Congratulations! Contact Shared',
            'message' => "Your valentine partner's WhatsApp: {$user1->whatsapp_number}. Happy Valentine's Day!",
            'type' => 'success',
        ]);

        $couple->update(['whatsapp_shared' => true]);
    }

    public function couples()
    {
        $couples = Couple::with(['user1', 'user2'])
            ->latest('coupled_at')
            ->paginate(20);

        return view('admin.couples', compact('couples'));
    }

    public function settings()
    {
        $settings = [
            'registration_fee' => AdminSetting::getValue('registration_fee', 51),
            'full_payment_amount' => AdminSetting::getValue('full_payment_amount', 299),
            'half_payment_amount' => AdminSetting::getValue('half_payment_amount', 149),
            'app_logo' => AdminSetting::getValue('app_logo'),
            'payment_qr_code' => AdminSetting::getValue('payment_qr_code'),
            'payment_upi' => AdminSetting::getValue('payment_upi', 'example@upi'),
            // Razorpay Settings
            'razorpay_enabled' => AdminSetting::getValue('razorpay_enabled', false),
            'razorpay_key_id' => AdminSetting::getValue('razorpay_key_id', ''),
            'razorpay_key_secret' => AdminSetting::getValue('razorpay_key_secret', ''),
            // Google Pay Settings
            'googlepay_enabled' => AdminSetting::getValue('googlepay_enabled', true),
        ];

        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'registration_fee' => 'required|numeric|min:0',
            'full_payment_amount' => 'required|numeric|min:0',
            'half_payment_amount' => 'required|numeric|min:0',
            'payment_upi' => 'nullable|string',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'payment_qr_code' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'razorpay_enabled' => 'nullable|boolean',
            'razorpay_key_id' => 'nullable|string',
            'razorpay_key_secret' => 'nullable|string',
            'googlepay_enabled' => 'nullable|boolean',
        ]);

        AdminSetting::setValue('registration_fee', $request->registration_fee, 'number', 'Registration fee in INR');
        AdminSetting::setValue('full_payment_amount', $request->full_payment_amount, 'number', 'Full payment amount for mutual matches');
        AdminSetting::setValue('half_payment_amount', $request->half_payment_amount, 'number', 'Half payment amount for one-sided acceptance');
        
        // Google Pay / UPI Settings
        AdminSetting::setValue('googlepay_enabled', $request->has('googlepay_enabled') ? 1 : 0, 'boolean', 'Enable Google Pay/UPI payments');
        if ($request->payment_upi) {
            AdminSetting::setValue('payment_upi', $request->payment_upi, 'string', 'UPI ID for payments');
        }

        // Razorpay Settings
        AdminSetting::setValue('razorpay_enabled', $request->has('razorpay_enabled') ? 1 : 0, 'boolean', 'Enable Razorpay payments');
        if ($request->razorpay_key_id) {
            AdminSetting::setValue('razorpay_key_id', $request->razorpay_key_id, 'string', 'Razorpay Key ID');
        }
        if ($request->razorpay_key_secret) {
            AdminSetting::setValue('razorpay_key_secret', $request->razorpay_key_secret, 'string', 'Razorpay Key Secret');
        }

        if ($request->hasFile('app_logo')) {
            $logoPath = $request->file('app_logo')->store('settings', 'public');
            AdminSetting::setValue('app_logo', $logoPath, 'image', 'Application logo');
        }

        if ($request->hasFile('payment_qr_code')) {
            $qrPath = $request->file('payment_qr_code')->store('settings', 'public');
            AdminSetting::setValue('payment_qr_code', $qrPath, 'image', 'Payment QR code');
        }

        return back()->with('success', 'Settings updated successfully.');
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,success,error',
        ]);

        Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
        ]);

        return back()->with('success', 'Notification sent successfully.');
    }

    public function bulkNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,success,error',
            'target' => 'required|in:all,active,pending',
        ]);

        $query = User::where('is_admin', false);

        if ($request->target === 'active') {
            $query->where('status', 'active');
        } elseif ($request->target === 'pending') {
            $query->where('status', 'pending');
        }

        $users = $query->get();

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'message' => $request->message,
                'type' => $request->type,
            ]);
        }

        return back()->with('success', "Notification sent to {$users->count()} users.");
    }

    /**
     * Approve a user - set status to active
     */
    public function approveUser(User $user)
    {
        $user->update([
            'status' => 'active',
            'registration_verified' => true,
        ]);

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Account Approved',
            'message' => 'Your account has been approved! You can now use all features.',
            'type' => 'success',
        ]);

        return back()->with('success', "User {$user->full_name} has been approved.");
    }

    /**
     * Block a user
     */
    public function blockUser(User $user)
    {
        $user->update([
            'status' => 'blocked',
        ]);

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Account Blocked',
            'message' => 'Your account has been blocked. Please contact support for more information.',
            'type' => 'error',
        ]);

        return back()->with('success', "User {$user->full_name} has been blocked.");
    }

    /**
     * Suspend a user
     */
    public function suspendUser(User $user)
    {
        $user->update([
            'status' => 'suspended',
        ]);

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Account Suspended',
            'message' => 'Your account has been temporarily suspended. Please contact support for more information.',
            'type' => 'warning',
        ]);

        return back()->with('success', "User {$user->full_name} has been suspended.");
    }
}
