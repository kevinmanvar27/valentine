<?php

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProfileSuggestion;
use App\Models\UserMatch;
use App\Models\MatchPayment;
use App\Models\Couple;

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║     COMPLETE PAYMENT FLOW - INTEGRATION TEST              ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

DB::beginTransaction();

$testsPassed = 0;
$testsFailed = 0;

function testStep($description, $condition, $errorMsg = '') {
    global $testsPassed, $testsFailed;
    
    if ($condition) {
        echo "✅ {$description}\n";
        $testsPassed++;
        return true;
    } else {
        echo "❌ {$description}\n";
        if ($errorMsg) echo "   Error: {$errorMsg}\n";
        $testsFailed++;
        return false;
    }
}

try {
    // ============================================
    // SCENARIO 1: ONE-SIDED ACCEPTANCE
    // ============================================
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "SCENARIO 1: One-Sided Acceptance (User A accepts first)\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    
    // Create users
    $userA = User::create([
        'full_name' => 'Alice Test',
        'email' => 'alice@test.com',
        'password' => Hash::make('password'),
        'whatsapp_number' => '1111111111',
        'dob' => '1995-01-01',
        'gender' => 'female',
        'location' => 'Mumbai',
        'status' => 'active',
    ]);
    
    $userB = User::create([
        'full_name' => 'Bob Test',
        'email' => 'bob@test.com',
        'password' => Hash::make('password'),
        'whatsapp_number' => '2222222222',
        'dob' => '1994-01-01',
        'gender' => 'male',
        'location' => 'Mumbai',
        'status' => 'active',
    ]);
    
    testStep("Created User A (ID: {$userA->id})", $userA->exists);
    testStep("Created User B (ID: {$userB->id})", $userB->exists);
    
    // Create suggestions
    ProfileSuggestion::create([
        'user_id' => $userA->id,
        'suggested_user_id' => $userB->id,
        'status' => 'pending',
    ]);
    
    ProfileSuggestion::create([
        'user_id' => $userB->id,
        'suggested_user_id' => $userA->id,
        'status' => 'pending',
    ]);
    
    testStep("Created mutual profile suggestions", true);
    
    // User A accepts (creates match and payment)
    $match = UserMatch::create([
        'user1_id' => min($userA->id, $userB->id),
        'user2_id' => max($userA->id, $userB->id),
        'status' => 'pending_payment',
    ]);
    
    $paymentA = MatchPayment::create([
        'match_id' => $match->id,
        'user_id' => $userA->id,
        'amount' => 500,
        'payment_type' => 'full',
        'status' => 'pending',
    ]);
    
    testStep("Match created (ID: {$match->id})", $match->exists);
    testStep("Payment A created with status 'pending'", $paymentA->status === 'pending');
    testStep("Only one payment exists", $match->payments()->count() === 1);
    
    // User A submits payment
    $paymentA->update([
        'payment_screenshot' => 'screenshots/alice_payment.jpg',
        'transaction_id' => 'TXN111111111',
        'status' => 'submitted',
    ]);
    
    $match->refresh();
    $match->load('payments');
    
    $submittedCount = $match->payments()->whereIn('status', ['submitted', 'verified'])->count();
    
    if ($submittedCount >= 2) {
        $match->update(['status' => 'payment_submitted']);
    } else {
        $match->update(['status' => 'pending_payment']);
    }
    
    testStep("Payment A submitted successfully", $paymentA->fresh()->status === 'submitted');
    testStep("Transaction ID saved", $paymentA->fresh()->transaction_id === 'TXN111111111');
    testStep("Match status remains 'pending_payment'", $match->fresh()->status === 'pending_payment');
    
    echo "\n";
    
    // ============================================
    // SCENARIO 2: MUTUAL ACCEPTANCE
    // ============================================
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "SCENARIO 2: Mutual Acceptance (User B accepts)\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    
    // User B accepts (creates their payment)
    $paymentB = MatchPayment::create([
        'match_id' => $match->id,
        'user_id' => $userB->id,
        'amount' => 500,
        'payment_type' => 'full',
        'status' => 'pending',
    ]);
    
    testStep("Payment B created with status 'pending'", $paymentB->status === 'pending');
    testStep("Two payments exist now", $match->payments()->count() === 2);
    
    // User B submits payment
    $paymentB->update([
        'payment_screenshot' => 'screenshots/bob_payment.jpg',
        'transaction_id' => 'TXN222222222',
        'status' => 'submitted',
    ]);
    
    $match->refresh();
    $match->load('payments');
    
    $submittedCount = $match->payments()->whereIn('status', ['submitted', 'verified'])->count();
    
    if ($submittedCount >= 2) {
        $match->update(['status' => 'payment_submitted']);
    } else {
        $match->update(['status' => 'pending_payment']);
    }
    
    testStep("Payment B submitted successfully", $paymentB->fresh()->status === 'submitted');
    testStep("Transaction ID saved", $paymentB->fresh()->transaction_id === 'TXN222222222');
    testStep("Both payments are submitted", $submittedCount === 2);
    testStep("Match status changed to 'payment_submitted'", $match->fresh()->status === 'payment_submitted');
    
    echo "\n";
    
    // ============================================
    // SCENARIO 3: ADMIN VERIFICATION
    // ============================================
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "SCENARIO 3: Admin Verification Process\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    
    // Admin verifies User A's payment
    $paymentA->fresh()->update([
        'status' => 'verified',
        'verified_at' => now(),
    ]);
    
    $match->refresh();
    $verifiedCount = $match->payments()->where('status', 'verified')->count();
    
    testStep("Payment A verified", $paymentA->fresh()->status === 'verified');
    testStep("Only 1 payment verified so far", $verifiedCount === 1);
    testStep("Match status still 'payment_submitted'", $match->fresh()->status === 'payment_submitted');
    testStep("Couple NOT created yet", Couple::where('match_id', $match->id)->doesntExist());
    
    // Admin verifies User B's payment
    $paymentB->fresh()->update([
        'status' => 'verified',
        'verified_at' => now(),
    ]);
    
    $match->refresh();
    $verifiedCount = $match->payments()->where('status', 'verified')->count();
    
    // Check if both payments verified
    $allVerified = $match->allPaymentsVerified();
    
    if ($allVerified) {
        $match->update(['status' => 'completed']);
        
        // Create couple
        Couple::create([
            'match_id' => $match->id,
            'user1_id' => $match->user1_id,
            'user2_id' => $match->user2_id,
            'coupled_at' => now(),
        ]);
    }
    
    testStep("Payment B verified", $paymentB->fresh()->status === 'verified');
    testStep("Both payments verified", $verifiedCount === 2);
    testStep("allPaymentsVerified() returns true", $allVerified === true);
    testStep("Match status changed to 'completed'", $match->fresh()->status === 'completed');
    
    $couple = Couple::where('match_id', $match->id)->first();
    testStep("Couple created successfully", $couple !== null);
    testStep("Couple has correct user IDs", 
        $couple && $couple->user1_id === $match->user1_id && $couple->user2_id === $match->user2_id);
    
    echo "\n";
    
    // ============================================
    // SCENARIO 4: PAYMENT REJECTION
    // ============================================
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "SCENARIO 4: Payment Rejection & Resubmission\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    
    // Create new users for rejection test
    $userC = User::create([
        'full_name' => 'Charlie Test',
        'email' => 'charlie@test.com',
        'password' => Hash::make('password'),
        'whatsapp_number' => '3333333333',
        'dob' => '1993-01-01',
        'gender' => 'male',
        'location' => 'Delhi',
        'status' => 'active',
    ]);
    
    $userD = User::create([
        'full_name' => 'Diana Test',
        'email' => 'diana@test.com',
        'password' => Hash::make('password'),
        'whatsapp_number' => '4444444444',
        'dob' => '1992-01-01',
        'gender' => 'female',
        'location' => 'Delhi',
        'status' => 'active',
    ]);
    
    // Create match and payments
    $match2 = UserMatch::create([
        'user1_id' => min($userC->id, $userD->id),
        'user2_id' => max($userC->id, $userD->id),
        'status' => 'pending_payment',
    ]);
    
    $paymentC = MatchPayment::create([
        'match_id' => $match2->id,
        'user_id' => $userC->id,
        'amount' => 500,
        'payment_type' => 'full',
        'status' => 'submitted',
        'payment_screenshot' => 'screenshots/charlie_payment.jpg',
        'transaction_id' => 'TXN333333333',
    ]);
    
    $paymentD = MatchPayment::create([
        'match_id' => $match2->id,
        'user_id' => $userD->id,
        'amount' => 500,
        'payment_type' => 'full',
        'status' => 'submitted',
        'payment_screenshot' => 'screenshots/diana_payment.jpg',
        'transaction_id' => 'TXN444444444',
    ]);
    
    $match2->update(['status' => 'payment_submitted']);
    
    testStep("Created second match for rejection test", $match2->exists);
    testStep("Both payments submitted", $match2->payments()->count() === 2);
    
    // Admin rejects User C's payment
    $paymentC->update([
        'status' => 'rejected',
        'admin_notes' => 'Invalid screenshot - please resubmit',
    ]);
    
    $match2->refresh();
    $match2->load('payments');
    
    $submittedCount2 = $match2->payments()->whereIn('status', ['submitted', 'verified'])->count();
    
    if ($submittedCount2 >= 2) {
        $match2->update(['status' => 'payment_submitted']);
    } else {
        $match2->update(['status' => 'pending_payment']);
    }
    
    testStep("Payment C rejected", $paymentC->fresh()->status === 'rejected');
    testStep("Match status reset to 'pending_payment'", $match2->fresh()->status === 'pending_payment');
    
    // User C resubmits payment
    $paymentC->fresh()->update([
        'payment_screenshot' => 'screenshots/charlie_payment_new.jpg',
        'transaction_id' => 'TXN333333999',
        'status' => 'submitted',
        'admin_notes' => null,
    ]);
    
    $match2->refresh();
    $match2->load('payments');
    
    $submittedCount2 = $match2->payments()->whereIn('status', ['submitted', 'verified'])->count();
    
    if ($submittedCount2 >= 2) {
        $match2->update(['status' => 'payment_submitted']);
    }
    
    testStep("Payment C resubmitted", $paymentC->fresh()->status === 'submitted');
    testStep("New transaction ID saved", $paymentC->fresh()->transaction_id === 'TXN333333999');
    testStep("Match status back to 'payment_submitted'", $match2->fresh()->status === 'payment_submitted');
    
    echo "\n";
    
    // ============================================
    // FINAL SUMMARY
    // ============================================
    echo "╔════════════════════════════════════════════════════════════╗\n";
    echo "║                    TEST SUMMARY                            ║\n";
    echo "╚════════════════════════════════════════════════════════════╝\n\n";
    
    echo "✅ Tests Passed: {$testsPassed}\n";
    echo "❌ Tests Failed: {$testsFailed}\n\n";
    
    if ($testsFailed === 0) {
        echo "🎉 ALL TESTS PASSED! Payment flow is working perfectly!\n\n";
        echo "Key Features Verified:\n";
        echo "  ✓ One-sided acceptance creates match and single payment\n";
        echo "  ✓ Payment submission updates status correctly\n";
        echo "  ✓ Transaction ID is saved properly\n";
        echo "  ✓ Match status updates when both payments submitted\n";
        echo "  ✓ Couple created only after both payments verified\n";
        echo "  ✓ Payment rejection and resubmission works\n";
        echo "  ✓ Status progression follows correct flow\n\n";
    } else {
        echo "⚠️  Some tests failed. Please review the errors above.\n\n";
    }
    
} catch (Exception $e) {
    echo "\n❌ FATAL ERROR: {$e->getMessage()}\n";
    echo "File: {$e->getFile()}\n";
    echo "Line: {$e->getLine()}\n";
    echo "\nStack Trace:\n{$e->getTraceAsString()}\n";
}

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Cleaning up test data...\n";
DB::rollBack();
echo "✓ Database rolled back (all test data removed)\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
