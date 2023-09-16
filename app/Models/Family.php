<?php

namespace App\Models;

use App\Models\User;
use App\Models\Dasawisma;
use App\Models\FamilyMember;
use App\Models\FamilyNumber;
use App\Models\FamilyActivity;
use App\Models\FamilyBuilding;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'dasawisma_id',
        'kk_number',
        'kk_head',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function dasawisma(): BelongsTo
    {
        return $this->belongsTo(Dasawisma::class, 'dasawisma_id', 'id');
    }

    public function familyBuildings(): HasMany
    {
        return $this->hasMany(FamilyBuilding::class, 'family_id', 'id');
    }

    public function familyNumbers(): HasMany
    {
        return $this->hasMany(FamilyNumber::class, 'family_id', 'id');
    }

    public function familyMembers(): HasMany
    {
        return $this->hasMany(FamilyMember::class, 'family_id', 'id');
    }

    public function familyActivites(): HasMany
    {
        return $this->hasMany(FamilyActivity::class, 'family_id', 'id');
    }
}
