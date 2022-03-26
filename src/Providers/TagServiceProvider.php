<?php

namespace Dealskoo\Tag\Providers;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\Admin\Facades\PermissionManager;
use Dealskoo\Admin\Permission;
use Dealskoo\Tag\TagManager;
use Illuminate\Support\ServiceProvider;

class TagServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('tag_manager', TagManager::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->publishes([
                __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/tag')
            ], 'lang');
        }

        $this->loadRoutesFrom(__DIR__ . '/../../routes/admin.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'tag');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'tag');

        AdminMenu::whereTitle('admin::admin.settings', function ($menu) {
            $menu->route('admin.tags.index', 'tag::tag.tags', [], ['permission' => 'tags.index']);
        });

        PermissionManager::add(new Permission('tags.index', 'Tag Lists'));
        PermissionManager::add(new Permission('tags.show', 'View Tag'), 'tags.index');
        PermissionManager::add(new Permission('tags.create', 'Create Tag'), 'tags.index');
        PermissionManager::add(new Permission('tags.edit', 'Edit Tag'), 'tags.index');
        PermissionManager::add(new Permission('tags.destroy', 'Destroy Tag'), 'tags.index');
    }
}
