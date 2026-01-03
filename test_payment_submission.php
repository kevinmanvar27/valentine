<?php

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProfileSuggestion;
use App\Models\UserMatch;
use App\Models\MatchPayment;

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "========================================\n";
echo "PAYMENT SUBMISSION TEST\n";
echo "========================================\n\n";

DB::beginTransaction();

try {
    // Step 1: Create test users
    echo "Step 1: Creating test users...\n";
    
    $userA = User::create([
        'full_name' => 'Test User A',
        'email' => 'test_payment_a@test.com',
        'password' => Hash::make('password'),
        'whatsapp_number' => '1234567890',
        'dob' => '1995-01-01',
        'gender' => 'male',
        'location' => 'Test City',
        'status' => 'active',
    ]);
    
    $userB = User::create([
        'full_name' => 'Test User B',
        'email' => 'test_payment_b@test.com',
        'password' => Hash::make('password'),
        'whatsapp_number' => '0987654321',
        'dob' => '1996-01-01',
        'gender' => 'female',
        'location' => 'Test City',
        'status' => 'active',
    ]);
    
    echo "✓ User A created (ID: {$userA->id})\n";
    echo "✓ User B created (ID: {$userB->id})\n\n";
    
    // Step 2: Create profile suggestions
    echo "Step 2: Creating profile suggestions...\n";
    
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
    
    echo "✓ Suggestions created\n\n";
    
    // Step 3: User A accepts (creates match and payment)
    echo "Step 3: User A accepts...\n";
    
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
    
    echo "✓ Match created (ID: {$match->id})\n";
    echo "✓ Payment A created (ID: {$paymentA->id}, Status: {$paymentA->status})\n\n";
    
    // Step 4: User A submits payment
    echo "Step 4: User A submits payment...\n";
    
    $paymentA->update([
        'payment_screenshot' => 'test_screenshot_a.jpg',
        'transaction_id' => 'TXN123456789',
        'status' => 'submitted',
    ]);
    
    // Refresh match
    $match->refresh();
    $match->load('payments');
    
    // Check payment count
    $submittedCount = $match->payments()->whereIn('status', ['submitted', 'verified'])->count();
    
    echo "✓ Payment A submitted\n";
    echo "✓ Transaction ID: {$paymentA->transaction_id}\n";
    echo "✓ Submitted/Verified count: {$submittedCount}\n";
    
    // Update match status
    if ($submittedCount >= 2) {
        $match->update(['status' => 'payment_submitted']);
        echo "✓ Match status: payment_submitted\n";
    } else {
        $match->update(['status' => 'pending_payment']);
        echo "✓ Match status: pending_payment (waiting for User B)\n";
    }
    echo "\n";
    
    // Step 5: User B accepts
    echo "Step 5: User B accepts...\n";
    
    $paymentB = MatchPayment::create([
        'match_id' => $match->id,
        'user_id' => $userB->id,
        'amount' => 500,
        'payment_type' => 'full',
        'status' => 'pending',
    ]);
    
    echo "✓ Payment B created (ID: {$paymentB->id}, Status: {$paymentB->status})\n\n";
    
    // Step 6: User B submits payment
    echo "Step 6: User B submits payment...\n";
    
    $paymentB->update([
        'payment_screenshot' => 'test_screenshot_b.jpg',
        'transaction_id' => 'TXN987654321',
        'status' => 'submitted',
    ]);
    
    // Refresh match
    $match->refresh();
    $match->load('payments');
    
    // Check payment count
    $submittedCount = $match->payments()->whereIn('status', ['submitted', 'verified'])->count();
    
    echo "✓ Payment B submitted\n";
    echo "✓ Transaction ID: {$paymentB->transaction_id}\n";
    echo "✓ Submitted/Verified count: {$submittedCount}\n";
    
    // Update match status
    if ($submittedCount >= 2) {
        $match->update(['status' => 'payment_submitted']);
        echo "✓ Match status: payment_submitted (both payments received)\n";
    } else {
        echo "✗ ERROR: Match status should be payment_submitted but count is {$submittedCount}\n";
    }
    echo "\n";
    
    // Step 7: Verify final state
    echo "Step 7: Verifying final state...\n";
    
    $match->refresh();
    $payments = $match->payments()->get();
    
    echo "Match ID: {$match->id}\n";
    echo "Match Status: {$match->status}\n";
    echo "Total Payments: {$payments->count()}\n";
    
    foreach ($payments as $payment) {
        $userName = $payment->user_id === $userA->id ? 'User A' : 'User B';
        echo "  - {$userName}: Status={$payment->status}, TxnID={$payment->transaction_id}\n";
    }
    
    // Verify status is correct
    if ($match->status === 'payment_submitted' && $payments->count() === 2) {
        echo "\n✅ TEST PASSED: Payment submission working correctly!\n";
    } else {
        echo "\n❌ TEST FAILED: Status or payment count incorrect\n";
    }
    
} catch (Exception $e) {
    echo "\n❌ ERROR: {$e->getMessage()}\n";
    echo "File: {$e->getFile()}\n";
    echo "Line: {$e->getLine()}\n";
}

echo "\n========================================\n";
echo "Cleaning up (rolling back)...\n";
DB::rollBack();
echo "✓ Database rolled back\n";
echo "========================================\n";
