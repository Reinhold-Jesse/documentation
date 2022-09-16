<?php

namespace Reinholdjesse\Documentation;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class DocumentationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Route::group(['middleware' => ['web']], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'documentation');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../resources/css/docs.css' => public_path('vendor/documentation/docs.css')], 'documentation.install');

        Livewire::component('docs.index', \Reinholdjesse\Documentation\Livewire\Docs\Index::class);
        Livewire::component('docs.create', \Reinholdjesse\Documentation\Livewire\Docs\Create::class);
        Livewire::component('docs.edit', \Reinholdjesse\Documentation\Livewire\Docs\Edit::class);
    }
}
