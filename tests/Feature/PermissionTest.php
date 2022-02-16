<?php

namespace Dealskoo\Tag\Tests\Feature;

use Dealskoo\Admin\Facades\PermissionManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Tag\Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_permissions()
    {
        $this->assertNotNull(PermissionManager::getPermission('tags.index'));
        $this->assertNotNull(PermissionManager::getPermission('tags.show'));
        $this->assertNotNull(PermissionManager::getPermission('tags.create'));
        $this->assertNotNull(PermissionManager::getPermission('tags.edit'));
        $this->assertNotNull(PermissionManager::getPermission('tags.destroy'));
    }
}
