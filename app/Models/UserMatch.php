<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMatch extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = [
        'user1_id',
        'user2_id',
        'status',
    ];

    public function user1()
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }

    public function payments()
    {
        return $this->hasMany(MatchPayment::class, 'match_id');
    }

    public function couple()
    {
        return $this->hasOne(Couple::class, 'match_id');
    }

    public function isMutual(): bool
    {
        // Check if both users accepted each other
        $user1Accepted = ProfileSuggestion::where('user_id', $this->user1_id)
            ->where('suggested_user_id', $this->user2_id)
            ->where('status', 'accepted')
            ->exists();

        $user2Accepted = ProfileSuggestion::where('user_id', $this->user2_id)
            ->where('suggested_user_id', $this->user1_id)
            ->where('status', 'accepted')
            ->exists();

        return $user1Accepted && $user2Accepted;
    }

    public function getPaymentAmount(): float
    {
        $fullPayment = (float) AdminSetting::getValue('full_payment_amount', 299);
        $halfPayment = (float) AdminSetting::getValue('half_payment_amount', 149);

        return $this->isMutual() ? $fullPayment : $halfPayment;
    }

    public function getPaymentType(): string
    {
        return $this->isMutual() ? 'full' : 'half';
    }

    public function allPaymentsVerified(): bool
    {
        return $this->payments()->where('status', 'verified')->count() >= 2;
    }

    public function allPaymentsSubmitted(): bool
    {
        return $this->payments()->whereIn('status', ['submitted', 'verified'])->count() >= 2;
    }

    public function getPaymentStatusForUser($userId): ?MatchPayment
    {
        return $this->payments()->where('user_id', $userId)->first();
    }

    public function getPendingPaymentsCount(): int
    {
        return $this->payments()->where('status', 'pending')->count();
    }

    public function getVerifiedPaymentsCount(): int
    {
        return $this->payments()->where('status', 'verified')->count();
    }
}
