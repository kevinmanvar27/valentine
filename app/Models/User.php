<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'full_name',
        'email',
        'whatsapp_number',
        'dob',
        'gender',
        'location',
        'instagram_id',
        'bio',
        'keywords',
        'expectation',
        'expected_keywords',
        'preferred_age_min',
        'preferred_age_max',
        'live_image',
        'gallery_images',
        'password',
        'is_admin',
        'status',
        'registration_paid',
        'registration_payment_screenshot',
        'registration_verified',
        'razorpay_payment_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dob' => 'date',
            'keywords' => 'array',
            'expected_keywords' => 'array',
            'gallery_images' => 'array',
            'is_admin' => 'boolean',
            'registration_paid' => 'boolean',
            'registration_verified' => 'boolean',
            'preferred_age_min' => 'integer',
            'preferred_age_max' => 'integer',
        ];
    }

    public function getAgeAttribute(): int
    {
        return $this->dob->age;
    }

    public function sentSuggestions()
    {
        return $this->hasMany(ProfileSuggestion::class, 'user_id');
    }

    public function receivedSuggestions()
    {
        return $this->hasMany(ProfileSuggestion::class, 'suggested_user_id');
    }

    public function matchesAsUser1()
    {
        return $this->hasMany(UserMatch::class, 'user1_id');
    }

    public function matchesAsUser2()
    {
        return $this->hasMany(UserMatch::class, 'user2_id');
    }

    public function couples()
    {
        return $this->hasMany(Couple::class, 'user1_id')
            ->orWhere('user2_id', $this->id);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function payments()
    {
        return $this->hasMany(MatchPayment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('registration_verified', true);
    }

    public function scopeMale($query)
    {
        return $query->where('gender', 'male');
    }

    public function scopeFemale($query)
    {
        return $query->where('gender', 'female');
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('location', 'LIKE', "%{$location}%");
    }

    public function scopeByKeywords($query, array $keywords)
    {
        return $query->where(function ($q) use ($keywords) {
            foreach ($keywords as $keyword) {
                $q->orWhereJsonContains('keywords', $keyword);
            }
        });
    }

    public function getActiveSuggestionsCount(): int
    {
        return $this->sentSuggestions()
            ->where('status', 'pending')
            ->count();
    }

    public function canReceiveMoreSuggestions(): bool
    {
        return $this->getActiveSuggestionsCount() < 5;
    }
}
