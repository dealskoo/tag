<?php

namespace Dealskoo\Tag\Traits;

use Dealskoo\Tag\Models\Tag;

trait Taggable
{
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function tag(Tag $tag)
    {
        return $this->tags()->save($tag);
    }

    public function hasTag(Tag $tag)
    {
        return $this->tags()->where('id', $tag->id)->exists();
    }
}
