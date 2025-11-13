<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PasswordResetToken extends Model
{
    use HasFactory;

    protected $table = 'password_reset_tokens';
    protected $fillable = [
        'email',
        'otp_code',
        'token',
        'expires_at' =>'datatime',
    ];

    protected $casts = [
        'expires_at' => 'datatime',
    ];
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }
}
