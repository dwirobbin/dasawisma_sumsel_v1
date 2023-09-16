<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamilyBuilding extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_id',
        'staple_food',
        'have_toilet',
        'water_src',
        'have_landfill',
        'have_sewerage',
        'pasting_p4k_sticker',
        'house_criteria',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class, 'family_id', 'id');
    }
}
