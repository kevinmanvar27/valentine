<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AdminSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'full_name' => 'Admin User',
            'email' => 'admin@valentine.com',
            'password' => Hash::make('admin123'),
            'whatsapp_number' => '9999999999',
            'dob' => '1990-01-01',
            'gender' => 'male',
            'keywords' => ['admin'],
            'location' => 'Admin',
            'live_image' => 'default.jpg',
            'is_admin' => true,
            'status' => 'active',
            'registration_paid' => true,
            'registration_verified' => true,
        ]);

        // Create Default Admin Settings
        $settings = [
            ['key' => 'registration_fee', 'value' => '51'],
            ['key' => 'full_payment_amount', 'value' => '499'],
            ['key' => 'half_payment_amount', 'value' => '249'],
            ['key' => 'payment_upi', 'value' => 'valentine@upi'],
            ['key' => 'payment_qr_code', 'value' => ''],
            ['key' => 'app_logo', 'value' => ''],
            ['key' => 'max_suggestions', 'value' => '5'],
            ['key' => 'registration_deadline', 'value' => '2026-02-06'],
            ['key' => 'event_start_date', 'value' => '2026-02-07'],
            ['key' => 'event_end_date', 'value' => '2026-02-14'],
        ];

        foreach ($settings as $setting) {
            AdminSetting::create($setting);
        }

        // Create Dummy Users - Males
        $maleUsers = [
            [
                'full_name' => 'Raj Patel',
                'email' => 'raj@test.com',
                'whatsapp_number' => '9876543210',
                'dob' => '1998-05-15',
                'gender' => 'male',
                'location' => 'Ahmedabad',
                'bio' => 'Software engineer who loves traveling and photography.',
                'keywords' => ['Handsome', 'Long-term Relationship', 'Friendship'],
                'expected_keywords' => ['Beautiful', 'Long-term Relationship'],
                'preferred_age_min' => 20,
                'preferred_age_max' => 28,
            ],
            [
                'full_name' => 'Arjun Sharma',
                'email' => 'arjun@test.com',
                'whatsapp_number' => '9876543211',
                'dob' => '1996-08-22',
                'gender' => 'male',
                'location' => 'Surat',
                'bio' => 'Fitness enthusiast and entrepreneur.',
                'keywords' => ['Hot', 'FWB', 'Casual Dating'],
                'expected_keywords' => ['Hot', 'Beautiful'],
                'preferred_age_min' => 21,
                'preferred_age_max' => 30,
            ],
            [
                'full_name' => 'Karan Mehta',
                'email' => 'karan@test.com',
                'whatsapp_number' => '9876543212',
                'dob' => '1999-03-10',
                'gender' => 'male',
                'location' => 'Ahmedabad',
                'bio' => 'Music lover and guitarist. Looking for someone special.',
                'keywords' => ['Handsome', 'Marriage', 'Long-term Relationship'],
                'expected_keywords' => ['Beautiful', 'Marriage'],
                'preferred_age_min' => 22,
                'preferred_age_max' => 28,
            ],
            [
                'full_name' => 'Vivek Shah',
                'email' => 'vivek@test.com',
                'whatsapp_number' => '9876543213',
                'dob' => '1997-11-05',
                'gender' => 'male',
                'location' => 'Vadodara',
                'bio' => 'Doctor by profession, foodie by passion.',
                'keywords' => ['Handsome', 'Long-term Relationship', 'Friendship'],
                'expected_keywords' => ['Beautiful', 'Friendship'],
                'preferred_age_min' => 23,
                'preferred_age_max' => 32,
            ],
            [
                'full_name' => 'Dhruv Desai',
                'email' => 'dhruv@test.com',
                'whatsapp_number' => '9876543214',
                'dob' => '2000-07-18',
                'gender' => 'male',
                'location' => 'Rajkot',
                'bio' => 'College student, love sports and movies.',
                'keywords' => ['Hot', 'Casual Dating', 'Friendship'],
                'expected_keywords' => ['Hot', 'Casual Dating'],
                'preferred_age_min' => 18,
                'preferred_age_max' => 25,
            ],
        ];

        // Create Dummy Users - Females
        $femaleUsers = [
            [
                'full_name' => 'Priya Patel',
                'email' => 'priya@test.com',
                'whatsapp_number' => '9876543220',
                'dob' => '1999-02-14',
                'gender' => 'female',
                'location' => 'Ahmedabad',
                'bio' => 'Fashion designer with a love for art and creativity.',
                'keywords' => ['Beautiful', 'Long-term Relationship', 'Marriage'],
                'expected_keywords' => ['Handsome', 'Long-term Relationship'],
                'preferred_age_min' => 24,
                'preferred_age_max' => 32,
            ],
            [
                'full_name' => 'Anjali Sharma',
                'email' => 'anjali@test.com',
                'whatsapp_number' => '9876543221',
                'dob' => '1998-09-28',
                'gender' => 'female',
                'location' => 'Surat',
                'bio' => 'Teacher who loves reading and cooking.',
                'keywords' => ['Beautiful', 'Friendship', 'Long-term Relationship'],
                'expected_keywords' => ['Handsome', 'Friendship'],
                'preferred_age_min' => 25,
                'preferred_age_max' => 35,
            ],
            [
                'full_name' => 'Sneha Mehta',
                'email' => 'sneha@test.com',
                'whatsapp_number' => '9876543222',
                'dob' => '2000-12-03',
                'gender' => 'female',
                'location' => 'Ahmedabad',
                'bio' => 'MBA student, aspiring entrepreneur.',
                'keywords' => ['Hot', 'Beautiful', 'Casual Dating'],
                'expected_keywords' => ['Hot', 'Casual Dating'],
                'preferred_age_min' => 22,
                'preferred_age_max' => 28,
            ],
            [
                'full_name' => 'Kavya Shah',
                'email' => 'kavya@test.com',
                'whatsapp_number' => '9876543223',
                'dob' => '1997-06-20',
                'gender' => 'female',
                'location' => 'Vadodara',
                'bio' => 'Nurse, love helping people and traveling.',
                'keywords' => ['Beautiful', 'Marriage', 'Long-term Relationship'],
                'expected_keywords' => ['Handsome', 'Marriage'],
                'preferred_age_min' => 26,
                'preferred_age_max' => 34,
            ],
            [
                'full_name' => 'Riya Desai',
                'email' => 'riya@test.com',
                'whatsapp_number' => '9876543224',
                'dob' => '2001-04-12',
                'gender' => 'female',
                'location' => 'Rajkot',
                'bio' => 'College student, dancer and singer.',
                'keywords' => ['Hot', 'FWB', 'Friendship'],
                'expected_keywords' => ['Hot', 'Friendship'],
                'preferred_age_min' => 19,
                'preferred_age_max' => 26,
            ],
            [
                'full_name' => 'Nisha Joshi',
                'email' => 'nisha@test.com',
                'whatsapp_number' => '9876543225',
                'dob' => '1996-01-30',
                'gender' => 'female',
                'location' => 'Ahmedabad',
                'bio' => 'CA professional, love finance and fitness.',
                'keywords' => ['Beautiful', 'Long-term Relationship', 'Marriage'],
                'expected_keywords' => ['Handsome', 'Long-term Relationship'],
                'preferred_age_min' => 27,
                'preferred_age_max' => 35,
            ],
        ];

        // Insert all users
        foreach (array_merge($maleUsers, $femaleUsers) as $userData) {
            User::create(array_merge($userData, [
                'password' => Hash::make('password123'),
                'live_image' => 'default.jpg',
                'is_admin' => false,
                'status' => 'active',
                'registration_paid' => true,
                'registration_verified' => true,
            ]));
        }

        $this->command->info('Admin user created: admin@valentine.com / admin123');
        $this->command->info('Created 5 male and 6 female dummy users (password: password123)');
        $this->command->info('Default settings initialized.');
    }
}
