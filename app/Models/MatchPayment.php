<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_id',
        'user_id',
        'amount',
        'payment_type',
        'payment_screenshot',
        'transaction_id',
        'status',
        'admin_notes',
        'verified_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    public function match()
    {
        return $this->belongsTo(UserMatch::class, 'match_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }
}
