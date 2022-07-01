<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\ValidatorExtend;
use App\Events\UserCreate;
use App\Events\UserUpdate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        (new ValidatorExtend)->register();

        User::creating(function ($user) {
            event(new UserCreate($user));
        });

        User::updating(function ($user) {
            event(new UserUpdate($user));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
