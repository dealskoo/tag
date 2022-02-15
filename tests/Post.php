<?php

namespace Dealskoo\Tag\Tests;

use Dealskoo\Tag\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Taggable;

    protected $fillable = ['title'];
}
