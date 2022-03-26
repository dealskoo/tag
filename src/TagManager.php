<?php

namespace Dealskoo\Tag;

use Dealskoo\Tag\Models\Tag;
use Illuminate\Support\Arr;

class TagManager
{
    public function sync($model, $tags)
    {
        $lists = collect();
        foreach ($tags as $t) {
            $tag = Tag::query()->where('country_id', $model->country_id)->where('name', $t)->first();
            if (!$tag) {
                $tag = new Tag(['name' => $t, 'country_id' => $model->country_id]);
                $tag->save();
            }
            $lists->push($tag);
        }
        $model->tags()->sync(Arr::pluck($lists, 'id'));
    }
}
