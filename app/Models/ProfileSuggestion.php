<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileSuggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'suggested_user_id',
        'status',
        'responded_at',
        'viewed',
        'viewed_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'viewed_at' => 'datetime',
        'viewed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function suggestedUser()
    {
        return $this->belongsTo(User::class, 'suggested_user_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }
}
