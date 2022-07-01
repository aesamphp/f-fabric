<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\HeaderMenuComposer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * The view composers for the application.
     *
     * @var array
     */
    protected $composers = [
        [
            'view' => 'includes.header-menu.menu',
            'class' => HeaderMenuComposer::class,
        ]
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->composers as $composer) {
            View::composer($composer['view'], $composer['class']);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {}
}
