<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dasawisma extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'rt',
        'rw',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function setNameAttribute($value)
    {
        if (static::whereName($name = Str::title($value))->exists()) {
            if (static::whereName($name)->get('id')->first()->id !== $this->id) {
                $name = $this->incrementField('name', $name);

                if (static::whereName($name)->exists()) {
                    return $this->setNameAttribute($name);
                }
            }
        }

        $this->attributes['name'] = $name;
    }

    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = Str::slug($value))->exists()) {
            if (static::whereSlug($slug)->get('id')->first()->id !== $this->id) {
                $slug = $this->incrementField('slug', $slug);

                if (static::whereSlug($slug)->exists()) {
                    return $this->setSlugAttribute($slug);
                }
            }
        }

        $this->attributes['slug'] = $slug;
    }

    public function incrementField($field, $value)
    {
        $max = static::where($field, $value)->latest('id')->value($field);

        if (is_numeric($max[-1])) {
            return preg_replace_callback('/(\d+)$/', function ($matches) {
                return $matches[1] + 1;
            }, $max);
        }

        return $field == 'name' ? "{$value} 2" : "{$value}-2";
    }

    /**
     * Get all of the families for the Dasawism`a
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function families(): HasMany
    {
        return $this->hasMany(Family::class, 'dasawisma_id', 'id');
    }
}
