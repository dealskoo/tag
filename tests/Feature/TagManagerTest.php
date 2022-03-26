<?php

namespace Dealskoo\Tag\Tests\Feature;

use Dealskoo\Tag\Facades\TagManager;
use Dealskoo\Tag\Tests\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Tag\Tests\TestCase;

class TagManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_object_tags_sync()
    {
        $tag = 'a';
        $tag1 = 'b';
        $product = new Product(['name' => 'test']);
        $product->save();
        $product->country_id = 1;
        TagManager::sync($product, [$tag, $tag1]);
        $this->assertCount(2, $product->tags);
        $this->assertEquals($product->tags()->first()->name, $tag);
    }

}
