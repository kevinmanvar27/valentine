@extends('layouts.app')

@section('title', 'Privacy Policy - Valentine Partner Finder')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-rose-500 rounded-2xl mb-6 shadow-sm">
                <i class="fas fa-shield-alt text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Privacy Policy</h1>
            <p class="text-gray-600">Last updated: {{ date('F d, Y') }}</p>
        </div>
        
        <!-- Content Card -->
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
            <div class="prose prose-pink max-w-none">
                
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-valentine-500 mr-3"></i>
                        1. Introduction
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        Valentine Partner Finder ("we", "our", or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our matchmaking service.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-database text-valentine-500 mr-3"></i>
                        2. Information We Collect
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        We collect the following types of information:
                    </p>
                    
                    <h3 class="text-lg font-semibold text-gray-800 mt-4 mb-2">Personal Information:</h3>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li>Full name and email address</li>
                        <li>WhatsApp number for communication</li>
                        <li>Date of birth and gender</li>
                        <li>Location information</li>
                        <li>Profile photos (including live verification photo)</li>
                        <li>Bio and personal qualities</li>
                        <li>Partner preferences and expectations</li>
                    </ul>
                    
                    <h3 class="text-lg font-semibold text-gray-800 mt-4 mb-2">Usage Information:</h3>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li>Device information and browser type</li>
                        <li>IP address and location data</li>
                        <li>Pages visited and features used</li>
                        <li>Time spent on the Service</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-cogs text-valentine-500 mr-3"></i>
                        3. How We Use Your Information
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        We use the collected information to:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li>Create and manage your account</li>
                        <li>Match you with compatible partners based on your preferences</li>
                        <li>Display your profile to potential matches</li>
                        <li>Facilitate communication between matched users</li>
                        <li>Process payments and transactions</li>
                        <li>Send notifications about matches and updates</li>
                        <li>Improve our Service and user experience</li>
                        <li>Prevent fraud and ensure platform safety</li>
                        <li>Comply with legal obligations</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-share-alt text-valentine-500 mr-3"></i>
                        4. Information Sharing
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        We may share your information in the following circumstances:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li><strong>With Other Users:</strong> Your profile information, photos, and qualities are visible to other users for matching purposes</li>
                        <li><strong>With Matched Users:</strong> Contact details are shared only after both users agree to connect and complete payment</li>
                        <li><strong>Service Providers:</strong> We may share data with third-party services that help us operate (payment processors, hosting providers)</li>
                        <li><strong>Legal Requirements:</strong> We may disclose information if required by law or to protect our rights</li>
                    </ul>
                    <p class="text-gray-600 leading-relaxed mt-4">
                        <strong>We do NOT sell your personal information to third parties.</strong>
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-lock text-valentine-500 mr-3"></i>
                        5. Data Security
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        We implement appropriate security measures to protect your information:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li>Encryption of sensitive data in transit and at rest</li>
                        <li>Secure password hashing</li>
                        <li>Regular security audits and updates</li>
                        <li>Access controls and authentication measures</li>
                        <li>Secure payment processing through trusted providers</li>
                    </ul>
                    <p class="text-gray-600 leading-relaxed mt-4">
                        However, no method of transmission over the Internet is 100% secure. We cannot guarantee absolute security.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-clock text-valentine-500 mr-3"></i>
                        6. Data Retention
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        We retain your personal information for as long as your account is active or as needed to provide services. If you delete your account, we will delete or anonymize your information within 30 days, except where we need to retain it for legal purposes.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user-cog text-valentine-500 mr-3"></i>
                        7. Your Rights
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        You have the following rights regarding your data:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li><strong>Access:</strong> Request a copy of your personal data</li>
                        <li><strong>Correction:</strong> Update or correct inaccurate information</li>
                        <li><strong>Deletion:</strong> Request deletion of your account and data</li>
                        <li><strong>Portability:</strong> Request your data in a portable format</li>
                        <li><strong>Opt-out:</strong> Unsubscribe from marketing communications</li>
                    </ul>
                    <p class="text-gray-600 leading-relaxed mt-4">
                        To exercise these rights, contact us at support@valentinefinder.com
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-cookie text-valentine-500 mr-3"></i>
                        8. Cookies and Tracking
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        We use cookies and similar technologies to enhance your experience, remember your preferences, and analyze usage patterns. You can control cookie settings through your browser, but disabling cookies may affect some features of the Service.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-child text-valentine-500 mr-3"></i>
                        9. Children's Privacy
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        Our Service is intended for users who are at least 13 years old. We do not knowingly collect information from children under 13. If we discover that we have collected information from a child under 13, we will delete it immediately.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-globe text-valentine-500 mr-3"></i>
                        10. International Users
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        Our Service is primarily operated in India. If you access the Service from outside India, your information may be transferred to and processed in India. By using the Service, you consent to this transfer.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-edit text-valentine-500 mr-3"></i>
                        11. Changes to This Policy
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        We may update this Privacy Policy from time to time. We will notify you of significant changes via email or through the Service. The updated policy will be effective when posted.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-envelope text-valentine-500 mr-3"></i>
                        12. Contact Us
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        If you have any questions or concerns about this Privacy Policy or our data practices, please contact us:
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
