<?php

use Illuminate\Support\Facades\Route;
use Dealskoo\Tag\Http\Controllers\Admin\TagController;

Route::middleware(['web', 'admin_locale'])->prefix(config('admin.route.prefix'))->name('admin.')->group(function () {

    Route::middleware(['guest:admin'])->group(function () {

    });

    Route::middleware(['auth:admin', 'admin_active'])->group(function () {
        Route::resource('tags', TagController::class);
    });
});
