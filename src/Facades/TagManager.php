<?php

namespace Dealskoo\Tag\Facades;

use Illuminate\Support\Facades\Facade;

class TagManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tag_manager';
    }
}
