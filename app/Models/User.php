<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'profile_picture',
        'phone_number',
        'role_id',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'is_blocked',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role_id === 1
            && is_null($this->province_id)
            && is_null($this->regency_id)
            && is_null($this->district_id)
            && is_null($this->village_id);
    }

    public function isAdminProvince(): bool
    {
        return $this->role_id == 2
            && strlen($this->province_id ?? '') === 2
            && is_null($this->regency_id)
            && is_null($this->district_id)
            && is_null($this->village_id);
    }

    public function isAdminRegency(): bool
    {
        return $this->role_id == 2
            && strlen($this->regency_id ?? '') === 4
            && is_null($this->district_id)
            && is_null($this->village_id);
    }

    public function isAdminDistrict(): bool
    {
        return $this->role_id == 2
            && strlen($this->district_id ?? '') === 7
            && is_null($this->village_id);
    }

    public function isAdminVillage(): bool
    {
        return $this->role_id == 2
            && strlen($this->village_id ?? '') === 10;
    }

    public function isGuest(): bool
    {
        return $this->role_id == 3
            && is_null($this->province_id)
            && is_null($this->regency_id)
            && is_null($this->district_id)
            && is_null($this->village_id);
    }

    public function isNotSet(): bool
    {
        return $this->role_id === 1 || $this->role_id === 2 || $this->role_id === 1 || $this->role_id === 3
            || is_null($this->province_id)
            || is_null($this->regency_id)
            || is_null($this->district_id)
            || is_null($this->village_id);
    }
}
