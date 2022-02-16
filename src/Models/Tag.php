<?php

namespace Dealskoo\Tag\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dealskoo\Country\Traits\HasCountry;
use Dealskoo\Admin\Traits\HasSlug;

class Tag extends Model
{
    use HasFactory, SoftDeletes, HasCountry, HasSlug;

    protected $fillable = [
        'slug',
        'name',
        'country_id'
    ];

    public function taggables()
    {
        return $this->hasMany(Taggable::class);
    }

    public function withType($type)
    {
        return $this->morphedByMany($type, 'taggable');
    }
}
