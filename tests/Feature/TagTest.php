<?php

namespace Dealskoo\Tag\Tests\Feature;

use Dealskoo\Tag\Models\Tag;
use Dealskoo\Tag\Tests\Post;
use Dealskoo\Tag\Tests\Product;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Tag\Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_basic_features()
    {
        $tag = Tag::factory()->create();
        $tag1 = Tag::factory()->create();
        $tag2 = Tag::factory()->create();
        $product = new Product(['name' => 'test']);
        $product->save();
        $product->tag($tag);
        $product->tag($tag1);
        $product->tag($tag2);
        $this->assertCount(3, $product->tags);
        $this->assertTrue($product->hasTag($tag2));

        $post = new Post(['title' => 'test']);
        $post->save();
        $post->tag($tag);
        $post->tag($tag1);
        $this->assertCount(2, $post->tags);
        $this->assertFalse($post->hasTag($tag2));

        $products = $tag->withType(Product::class)->get();
        $this->assertCount(1, $products);

        $posts = $tag->withType(Post::class)->get();
        $this->assertCount(1, $posts);
    }

    public function test_object_tags()
    {
        $tag = Tag::factory()->create();
        $tag1 = Tag::factory()->create();
        $product = new Product(['name' => 'test']);
        $product->save();
        $product->tag($tag);
        $product->tag($tag1);
        $this->assertCount(2, $product->tags);
        $this->assertEquals($product->tags()->first()->name, $tag->name);
    }

    public function test_object_tags_sync()
    {
        $tag = Tag::factory()->create();
        $tag1 = Tag::factory()->create();
        $product = new Product(['name' => 'test']);
        $product->save();
        $tags = [$tag, $tag1];
        $product->tags()->sync(Arr::pluck($tags, 'id'));
        $this->assertCount(2, $product->tags);
        $this->assertEquals($product->tags()->first()->name, $tag->name);
    }

    public function test_taggables()
    {
        $tag = Tag::factory()->create();
        $product = new Product(['name' => 'test']);
        $product->save();
        $product->tag($tag);
        $post = new Post(['title' => 'test post']);
        $post->save();
        $post->tag($tag);
        $this->assertCount(2, $tag->taggables()->get());
        $taggable = $tag->taggables()->first()->taggable()->first();
        $this->assertTrue(in_array($taggable->name, [$post->name, $product->name]));
    }

    public function test_with_type()
    {
        $tag = Tag::factory()->create();
        $product = new Product(['name' => 'test']);
        $product->save();
        $product->tag($tag);
        $products = $tag->withType(Product::class)->get();
        $this->assertCount(1, $products);
    }
}
