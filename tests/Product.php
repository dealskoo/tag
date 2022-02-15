<?php

namespace Dealskoo\Tag\Tests;

use Dealskoo\Tag\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Taggable;

    protected $fillable = ['name'];
}
