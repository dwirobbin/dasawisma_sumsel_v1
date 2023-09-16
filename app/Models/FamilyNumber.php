<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamilyNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_id',
        'toddlers_number',
        'pus_number',
        'wus_number',
        'blind_people_number',
        'pregnant_women_number',
        'breastfeeding_mother_number',
        'elderly_number',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class, 'family_id', 'id');
    }
}
