<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_id',
        'nik_number',
        'name',
        'slug',
        'birth_date',
        'status',
        'marital_status',
        'gender',
        'last_education',
        'profession',
    ];

    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = Str::slug($value))->exists()) {
            if (static::whereSlug($slug)->get('id')->first()->id !== $this->id) {
                $slug = $this->incrementSlug($slug);

                if (static::whereSlug($slug)->exists()) {
                    return $this->setSlugAttribute($slug);
                }
            }
        }

        $this->attributes['slug'] = $slug;
    }

    public function incrementSlug($slug)
    {
        $max = static::whereSlug($slug)->latest('id')->value('slug');

        if (is_numeric($max[-1])) {
            return preg_replace_callback('/(\d+)$/', function ($matches) {
                return $matches[1] + 1;
            }, $max);
        }

        return "{$slug}-2";
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class, 'family_id', 'id');
    }
}
