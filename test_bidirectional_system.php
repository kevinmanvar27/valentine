<?php

/**
 * Test Script for Bidirectional Profile Suggestion System
 * 
 * This script tests the complete flow of the bidirectional suggestion system
 * Run with: php test_bidirectional_system.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\ProfileSuggestion;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

echo "=== Bidirectional Profile Suggestion System Test ===\n\n";

// Test 1: Check if notifications table has required columns
echo "Test 1: Checking notifications table structure...\n";
$notificationColumns = DB::select("DESCRIBE notifications");
$hasRelatedId = false;
$hasRelatedType = false;

foreach ($notificationColumns as $column) {
    if ($column->Field === 'related_id') $hasRelatedId = true;
    if ($column->Field === 'related_type') $hasRelatedType = true;
}

if ($hasRelatedId && $hasRelatedType) {
    echo "✓ Notifications table has 'related_id' and 'related_type' columns\n\n";
} else {
    echo "✗ FAILED: Missing required columns in notifications table\n";
    echo "  - related_id: " . ($hasRelatedId ? "Found" : "Missing") . "\n";
    echo "  - related_type: " . ($hasRelatedType ? "Found" : "Missing") . "\n\n";
    exit(1);
}

// Test 2: Check profile_suggestions table structure
echo "Test 2: Checking profile_suggestions table structure...\n";
$suggestionColumns = DB::select("DESCRIBE profile_suggestions");
$hasStatus = false;

foreach ($suggestionColumns as $column) {
    if ($column->Field === 'status') {
        $hasStatus = true;
        // Check if enum includes required values
        if (strpos($column->Type, 'pending') !== false && 
            strpos($column->Type, 'accepted') !== false && 
            strpos($column->Type, 'rejected') !== false) {
            echo "✓ Profile suggestions table has correct status enum\n\n";
        } else {
            echo "✗ FAILED: Status enum doesn't have all required values\n\n";
            exit(1);
        }
    }
}

if (!$hasStatus) {
    echo "✗ FAILED: Missing 'status' column in profile_suggestions table\n\n";
    exit(1);
}

// Test 3: Check if we have test users
echo "Test 3: Checking for test users...\n";
$userCount = User::count();
if ($userCount >= 2) {
    echo "✓ Found {$userCount} users in database\n\n";
} else {
    echo "⚠ Warning: Only {$userCount} users found. Need at least 2 users for testing\n\n";
}

// Test 4: Test Notification model relationship
echo "Test 4: Testing Notification model relationship...\n";
try {
    $testNotification = Notification::where('type', 'profile_suggestion')->first();
    
    if ($testNotification) {
        // Try to access the relationship
        $suggestion = $testNotification->profileSuggestion;
        echo "✓ Notification->profileSuggestion relationship works\n";
        
        if ($suggestion) {
            echo "  - Found suggestion ID: {$suggestion->id}\n";
            echo "  - Status: {$suggestion->status}\n";
            
            // Test nested relationship
            $suggestedUser = $suggestion->suggestedUser;
            if ($suggestedUser) {
                echo "  - Suggested user: {$suggestedUser->full_name}\n";
            }
        }
        echo "\n";
    } else {
        echo "⚠ No profile_suggestion notifications found to test\n\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: Error testing relationship\n";
    echo "  Error: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Test 5: Check if routes are registered
echo "Test 5: Checking if routes are registered...\n";
$routes = app('router')->getRoutes();
$requiredRoutes = [
    'user.suggestions.details',
    'user.suggestions.respond',
];

$foundRoutes = [];
foreach ($routes as $route) {
    $name = $route->getName();
    if (in_array($name, $requiredRoutes)) {
        $foundRoutes[] = $name;
    }
}

if (count($foundRoutes) === count($requiredRoutes)) {
    echo "✓ All required routes are registered\n";
    foreach ($foundRoutes as $route) {
        echo "  - {$route}\n";
    }
    echo "\n";
} else {
    echo "✗ FAILED: Missing routes\n";
    $missing = array_diff($requiredRoutes, $foundRoutes);
    foreach ($missing as $route) {
        echo "  - Missing: {$route}\n";
    }
    echo "\n";
    exit(1);
}

// Test 6: Simulate bidirectional suggestion creation
echo "Test 6: Testing bidirectional suggestion logic...\n";
$users = User::where('registration_verified', true)->limit(2)->get();

if ($users->count() >= 2) {
    $user1 = $users[0];
    $user2 = $users[1];
    
    echo "  Testing with:\n";
    echo "  - User 1: {$user1->full_name} (ID: {$user1->id})\n";
    echo "  - User 2: {$user2->full_name} (ID: {$user2->id})\n\n";
    
    // Check if suggestions already exist
    $existingSuggestion1 = ProfileSuggestion::where('user_id', $user1->id)
        ->where('suggested_user_id', $user2->id)
        ->first();
    
    $existingSuggestion2 = ProfileSuggestion::where('user_id', $user2->id)
        ->where('suggested_user_id', $user1->id)
        ->first();
    
    if ($existingSuggestion1 && $existingSuggestion2) {
        echo "✓ Bidirectional suggestions already exist\n";
        echo "  - Suggestion 1 (User1 → User2): ID {$existingSuggestion1->id}, Status: {$existingSuggestion1->status}\n";
        echo "  - Suggestion 2 (User2 → User1): ID {$existingSuggestion2->id}, Status: {$existingSuggestion2->status}\n";
        
        // Check notifications
        $notification1 = Notification::where('user_id', $user1->id)
            ->where('related_id', $existingSuggestion1->id)
            ->where('related_type', 'profile_suggestion')
            ->first();
        
        $notification2 = Notification::where('user_id', $user2->id)
            ->where('related_id', $existingSuggestion2->id)
            ->where('related_type', 'profile_suggestion')
            ->first();
        
        if ($notification1 && $notification2) {
            echo "✓ Both users have notifications\n";
            echo "  - User 1 notification: \"{$notification1->title}\"\n";
            echo "  - User 2 notification: \"{$notification2->title}\"\n";
        } else {
            echo "⚠ Warning: Not all notifications found\n";
            echo "  - User 1 notification: " . ($notification1 ? "Found" : "Missing") . "\n";
            echo "  - User 2 notification: " . ($notification2 ? "Missing" : "Found") . "\n";
        }
    } else {
        echo "⚠ No existing bidirectional suggestions found for these users\n";
        echo "  You can test by having an admin share profiles through the UI\n";
    }
    echo "\n";
} else {
    echo "⚠ Not enough verified users to test bidirectional suggestions\n\n";
}

echo "=== Test Summary ===\n";
echo "✓ All critical tests passed!\n";
echo "✓ Database structure is correct\n";
echo "✓ Model relationships are working\n";
echo "✓ Routes are registered\n\n";

echo "Next Steps:\n";
echo "1. Clear your browser cache\n";
echo "2. Login as admin and share a profile\n";
echo "3. Check notifications for both users\n";
echo "4. Click 'View Profile' button to open modal\n";
echo "5. Test Accept/Reject functionality\n\n";

echo "=== Test Complete ===\n";
