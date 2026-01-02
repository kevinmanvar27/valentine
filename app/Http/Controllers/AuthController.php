<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AdminSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        $registrationFee = AdminSetting::getRegistrationFee();
        $keywords = ['Hot', 'Handsome', 'Beautiful', 'FWB', 'Friendship', 'Long-term Relationship', 'Casual Dating', 'Marriage'];
        
        return view('auth.register', compact('registrationFee', 'keywords'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            // Step 1: Account Information
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'whatsapp_number' => 'required|string|size:10',
            'password' => ['required', 'confirmed', Password::min(6)],
            
            // Step 2: Profile Information
            'gender' => 'required|in:male,female',
            'dob' => 'required|date|before:' . now()->subYears(13)->format('Y-m-d'),
            'location' => 'required|string|max:255',
            'live_photo' => 'required|string', // Base64 image data from camera
            'gallery_photos' => 'nullable|array|max:5',
            'gallery_photos.*' => 'image|mimes:jpeg,png,jpg|max:5120',
            'bio' => 'required|string|max:1000',
            'keywords' => 'required|array|min:1',
            'keywords.*' => 'string|max:50',
            
            // Step 3: Partner Expectations
            'expectation' => 'required|string|max:1000',
            'expected_keywords' => 'required|array|min:1',
            'expected_keywords.*' => 'string|max:50',
            'preferred_age_min' => 'nullable|integer|min:13|max:100',
            'preferred_age_max' => 'nullable|integer|min:13|max:100',
            'terms' => 'required|accepted',
        ], [
            'dob.before' => 'You must be at least 13 years old to register.',
            'live_photo.required' => 'Please capture your live photo using the camera.',
            'keywords.required' => 'Please select at least one quality that describes you.',
            'keywords.min' => 'Please select at least one quality that describes you.',
            'expected_keywords.required' => 'Please select at least one quality you are looking for.',
            'expected_keywords.min' => 'Please select at least one quality you are looking for.',
            'expectation.required' => 'Please describe what you are looking for in a partner.',
            'bio.required' => 'Please tell us about yourself.',
            'terms.required' => 'You must agree to the Terms of Service and Privacy Policy.',
            'terms.accepted' => 'You must agree to the Terms of Service and Privacy Policy.',
        ]);

        // Handle live image from base64 camera capture
        $liveImagePath = $this->saveBase64Image($validated['live_photo'], 'live_images');

        // Handle gallery images
        $galleryPaths = [];
        if ($request->hasFile('gallery_photos')) {
            foreach ($request->file('gallery_photos') as $image) {
                $galleryPaths[] = $image->store('gallery_images', 'public');
            }
        }

        $user = User::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'whatsapp_number' => $validated['whatsapp_number'],
            'dob' => $validated['dob'],
            'gender' => $validated['gender'],
            'location' => $validated['location'],
            'bio' => $validated['bio'],
            'keywords' => $validated['keywords'],
            'expectation' => $validated['expectation'],
            'expected_keywords' => $validated['expected_keywords'],
            'preferred_age_min' => $validated['preferred_age_min'] ?? 13,
            'preferred_age_max' => $validated['preferred_age_max'] ?? 35,
            'live_image' => $liveImagePath,
            'gallery_images' => $galleryPaths,
            'password' => Hash::make($validated['password']),
            'status' => 'pending',
        ]);

        Auth::login($user);

        return redirect()->route('user.payment')->with('success', 'Registration successful! Please complete the payment.');
    }

    /**
     * Save base64 image data to storage
     */
    private function saveBase64Image(string $base64Data, string $folder): string
    {
        // Remove the data URL prefix if present
        if (strpos($base64Data, 'data:image') === 0) {
            $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $base64Data);
        }
        
        // Decode base64 data
        $imageData = base64_decode($base64Data);
        
        // Generate unique filename
        $filename = Str::uuid() . '.jpg';
        $path = $folder . '/' . $filename;
        
        // Save to storage
        Storage::disk('public')->put($path, $imageData);
        
        return $path;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->is_admin) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('user.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
