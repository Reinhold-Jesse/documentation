<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('dashboard')->name('package.docs.')->group(function () {
    Route::get('/docs', Reinholdjesse\Documentation\Livewire\Docs\Index::class)->name('index');
    Route::get('/docs/create', Reinholdjesse\Documentation\Livewire\Docs\Create::class)->name('create');
    Route::get('/docs/{path}', Reinholdjesse\Documentation\Livewire\Docs\Edit::class)->name('edit')->where('path', '[\w\s\-_\/.md]+');;
});
