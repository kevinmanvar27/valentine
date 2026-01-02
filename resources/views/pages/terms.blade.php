@extends('layouts.app')

@section('title', 'Terms of Service - Valentine Partner Finder')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-valentine-100 via-pink-50 to-purple-100">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-valentine-500 to-pink-500 rounded-2xl mb-6 shadow-xl">
                <i class="fas fa-file-contract text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Terms of Service</h1>
            <p class="text-gray-600">Last updated: {{ date('F d, Y') }}</p>
        </div>
        
        <!-- Content Card -->
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
            <div class="prose prose-pink max-w-none">
                
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-handshake text-valentine-500 mr-3"></i>
                        1. Acceptance of Terms
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        By accessing and using Valentine Partner Finder ("the Service"), you accept and agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use our Service.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user-check text-valentine-500 mr-3"></i>
                        2. Eligibility
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        To use Valentine Partner Finder, you must:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li>Be at least 13 years of age</li>
                        <li>Provide accurate and truthful information during registration</li>
                        <li>Not be prohibited from using the Service under applicable laws</li>
                        <li>Not have been previously banned from the Service</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user-shield text-valentine-500 mr-3"></i>
                        3. User Accounts
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        When creating an account, you agree to:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li>Provide accurate, current, and complete information</li>
                        <li>Maintain the security of your password and account</li>
                        <li>Accept responsibility for all activities under your account</li>
                        <li>Notify us immediately of any unauthorized use</li>
                        <li>Use only your own photos and not impersonate others</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-ban text-valentine-500 mr-3"></i>
                        4. Prohibited Conduct
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        You agree NOT to:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li>Use the Service for any illegal or unauthorized purpose</li>
                        <li>Harass, abuse, or harm other users</li>
                        <li>Post false, misleading, or fraudulent content</li>
                        <li>Upload inappropriate, offensive, or explicit content</li>
                        <li>Attempt to gain unauthorized access to other accounts</li>
                        <li>Use automated systems or bots to access the Service</li>
                        <li>Spam or send unsolicited messages to other users</li>
                        <li>Engage in any activity that disrupts the Service</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-credit-card text-valentine-500 mr-3"></i>
                        5. Payments and Refunds
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Regarding payments:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li>Registration fees are required to activate your profile</li>
                        <li>Match connection fees are required to exchange contact details</li>
                        <li>All payments are processed securely</li>
                        <li>Refunds may be provided at our discretion for unused services</li>
                        <li>We reserve the right to modify pricing with prior notice</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-image text-valentine-500 mr-3"></i>
                        6. Content and Photos
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        By uploading content to Valentine Partner Finder:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li>You grant us a license to use, display, and distribute your content within the Service</li>
                        <li>You confirm that you own or have rights to all content you upload</li>
                        <li>You agree that your photos may be shown to other users for matching purposes</li>
                        <li>We may remove content that violates these terms</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-exclamation-triangle text-valentine-500 mr-3"></i>
                        7. Disclaimer
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        Valentine Partner Finder is provided "as is" without warranties of any kind. We do not guarantee that you will find a match or that matches will be compatible. We are not responsible for the conduct of any user on or off the Service. Users are solely responsible for their interactions with other users.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-gavel text-valentine-500 mr-3"></i>
                        8. Termination
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        We reserve the right to suspend or terminate your account at any time for violations of these Terms, fraudulent activity, or any conduct we deem harmful to other users or the Service. You may also delete your account at any time through your profile settings.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-edit text-valentine-500 mr-3"></i>
                        9. Changes to Terms
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        We may modify these Terms at any time. We will notify users of significant changes via email or through the Service. Continued use of the Service after changes constitutes acceptance of the modified Terms.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-envelope text-valentine-500 mr-3"></i>
                        10. Contact Us
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        If you have any questions about these Terms of Service, please contact us at:
                    </p>
                    <div class="mt-4 p-4 bg-valentine-50 rounded-xl">
                        <p class="text-gray-700">
                            <strong>Email:</strong> support@valentinefinder.com<br>
                            <strong>Website:</strong> {{ url('/') }}
                        </p>
                    </div>
                </section>

            </div>
        </div>
        
        <!-- Back Button -->
        <div class="text-center mt-8">
            <a href="{{ url()->previous() }}" class="inline-flex items-center px-6 py-3 bg-white text-valentine-600 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                Go Back
            </a>
        </div>
    </div>
</div>
@endsection
