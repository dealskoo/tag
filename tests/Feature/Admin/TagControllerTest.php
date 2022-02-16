<?php

namespace Dealskoo\Tag\Tests\Feature\Admin;

use Dealskoo\Admin\Models\Admin;
use Dealskoo\Tag\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Tag\Tests\TestCase;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.tags.index'));
        $response->assertStatus(200);
    }

    public function test_table()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.tags.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertJsonPath('recordsTotal', 0);
        $response->assertStatus(200);
    }

    public function test_show()
    {
        $admin = Admin::factory()->isOwner()->create();
        $tag = Tag::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.tags.show', $tag));
        $response->assertStatus(200);
    }

    public function test_create()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.tags.create'));
        $response->assertStatus(200);
    }

    public function test_store()
    {
        $admin = Admin::factory()->isOwner()->create();
        $tag = Tag::factory()->make();
        $response = $this->actingAs($admin, 'admin')->post(route('admin.tags.store'), $tag->only([
            'name',
            'slug',
            'country_id',
        ]));
        $response->assertStatus(302);
    }

    public function test_edit()
    {
        $admin = Admin::factory()->isOwner()->create();
        $tag = Tag::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.tags.edit', $tag));
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $admin = Admin::factory()->isOwner()->create();
        $tag = Tag::factory()->create();
        $tag1 = Tag::factory()->make();
        $response = $this->actingAs($admin, 'admin')->put(route('admin.tags.update', $tag), $tag1->only([
            'name',
            'country_id',
        ]));
        $response->assertStatus(302);
    }

    public function test_destroy()
    {
        $admin = Admin::factory()->isOwner()->create();
        $tag = Tag::factory()->create();
        $response = $this->actingAs($admin, 'admin')->delete(route('admin.tags.destroy', $tag));
        $response->assertStatus(200);
        $this->assertSoftDeleted($tag);
    }
}
