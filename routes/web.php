<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/couples', [HomeController::class, 'couples'])->name('couples');

// Legal pages (public)
Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User routes
Route::middleware(['auth', 'verified.user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/payment', [UserController::class, 'showPayment'])->name('payment')->withoutMiddleware('verified.user');
    Route::post('/payment', [UserController::class, 'submitPayment'])->name('payment.submit')->withoutMiddleware('verified.user');
    Route::post('/payment/razorpay/verify', [UserController::class, 'verifyRazorpayPayment'])->name('payment.razorpay.verify')->withoutMiddleware('verified.user');
    
    Route::get('/suggestions', [UserController::class, 'suggestions'])->name('suggestions');
    Route::get('/suggestions/{suggestion}/details', [UserController::class, 'getSuggestionDetails'])->name('suggestions.details');
    Route::post('/suggestions/{suggestion}/respond', [UserController::class, 'respondToSuggestion'])->name('suggestions.respond');
    
    Route::get('/matches', [UserController::class, 'matches'])->name('matches');
    Route::get('/matches/{match}/payment', [UserController::class, 'showMatchPayment'])->name('matches.payment');
    Route::post('/matches/{match}/payment', [UserController::class, 'submitMatchPayment'])->name('matches.payment.submit');
    
    Route::get('/notifications', [UserController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{notification}/read', [UserController::class, 'markNotificationRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [UserController::class, 'markAllNotificationsRead'])->name('notifications.mark-all-read');
    
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    
    // User status actions
    Route::post('/users/{user}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
    Route::post('/users/{user}/block', [AdminController::class, 'blockUser'])->name('users.block');
    Route::post('/users/{user}/suspend', [AdminController::class, 'suspendUser'])->name('users.suspend');
    
    Route::get('/verifications', [AdminController::class, 'pendingVerifications'])->name('verifications');
    Route::post('/verifications/{user}', [AdminController::class, 'verifyRegistration'])->name('verifications.verify');
    
    Route::get('/matchmaking', [AdminController::class, 'matchmaking'])->name('matchmaking');
    Route::post('/matchmaking/suggest', [AdminController::class, 'suggestProfile'])->name('matchmaking.suggest');
    Route::delete('/matchmaking/revoke/{suggestion}', [AdminController::class, 'revokeSuggestion'])->name('matchmaking.revoke');
    Route::post('/matchmaking/set-match', [AdminController::class, 'setMatch'])->name('matchmaking.set-match');
    
    Route::get('/matches', [AdminController::class, 'matches'])->name('matches');
    
    Route::get('/payments', [AdminController::class, 'pendingPayments'])->name('payments');
    Route::post('/payments/{payment}/verify', [AdminController::class, 'verifyMatchPayment'])->name('payments.verify');
    
    Route::get('/couples', [AdminController::class, 'couples'])->name('couples');
    
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    
    Route::post('/notifications/send', [AdminController::class, 'sendNotification'])->name('notifications.send');
    Route::post('/notifications/bulk', [AdminController::class, 'bulkNotification'])->name('notifications.bulk');
});
