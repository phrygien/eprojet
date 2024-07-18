<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Abonnement extends Model
{
    use HasFactory;

    protected $fillable = [
        'debut',
        'fin',
        'user_id',
        'role_id',
        'statut',
        'is_active'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function role():BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}