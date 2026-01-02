<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Couple extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_id',
        'user1_id',
        'user2_id',
        'whatsapp_shared',
        'coupled_at',
    ];

    protected $casts = [
        'whatsapp_shared' => 'boolean',
        'coupled_at' => 'datetime',
    ];

    public function match()
    {
        return $this->belongsTo(UserMatch::class, 'match_id');
    }

    public function user1()
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }
}
