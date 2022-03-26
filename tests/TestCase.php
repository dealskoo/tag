<?php

namespace Dealskoo\Tag\Tests;

use Dealskoo\Tag\Facades\TagManager;
use Dealskoo\Tag\Providers\TagServiceProvider;

abstract class TestCase extends \Dealskoo\Admin\Tests\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            TagServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'TagManager' => TagManager::class
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
    }
}
