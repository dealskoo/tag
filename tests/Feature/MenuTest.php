<?php

namespace Dealskoo\Tag\Tests\Feature;

use Dealskoo\Admin\Facades\AdminMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Tag\Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu()
    {
        $childs = AdminMenu::findBy('title', 'admin::admin.settings')->getChilds();
        $menu = collect($childs)->where('title', 'tag::tag.tags');
        $this->assertNotNull($menu);
    }
}
