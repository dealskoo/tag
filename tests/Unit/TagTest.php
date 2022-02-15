<?php

namespace Dealskoo\Tag\Tests\Unit;

use Dealskoo\Tag\Models\Tag;
use Dealskoo\Tag\Tests\Post;
use Dealskoo\Tag\Tests\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Tag\Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_tags()
    {
        $tag = Tag::factory()->create();
        $tag1 = Tag::factory()->create();
        $product = new Product(['name' => 'test']);
        $product->save();
        $product->tags()->save($tag);
        $product->tags()->save($tag1);
        $this->assertCount(2, $product->tags);
    }

    public function test_with_type()
    {
        $tag = Tag::factory()->create();
        $tag1 = Tag::factory()->create();
        $product = new Product(['name' => 'test']);
        $product->save();
        $product->tag($tag);
        $product->tag($tag1);
        $this->assertCount(2, $product->tags);

        $post = new Post(['title' => 'test']);
        $post->save();
        $post->tag($tag);
        $post->tag($tag1);
        $this->assertCount(2, $post->tags);

        $products = $tag->withType(Product::class)->get();
        $this->assertCount(1, $products);

        $posts = $tag->withType(Post::class)->get();
        $this->assertCount(1, $posts);
    }
}
