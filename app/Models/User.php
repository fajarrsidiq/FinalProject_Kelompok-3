<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    protected $fillable = [
        'cabang_id', 'nama_lengkap', 'email', 'password', 'role', 'is_active'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class);
    }

    public function isOwner(): bool { return $this->role === 'owner'; }
    public function isManager(): bool { return $this->role === 'manager'; }
    public function isSupervisor(): bool { return $this->role === 'supervisor'; }
    public function isKasir(): bool { return $this->role === 'kasir'; }
    public function isGudang(): bool { return $this->role === 'gudang'; }
}