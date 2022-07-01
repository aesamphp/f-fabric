<?php

namespace App\Providers;

use App\Models\ShippingPackageType;
use App\Events\UserCreate;
use App\Events\UserUpdate;
use App\Listeners\SetNewsletterSubscriptionDate;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        SetNewsletterSubscriptionDate::class,
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        ShippingPackageType::deleting(function (ShippingPackageType $type) {
            $type->packageBranding->delete($type->id);
        });
    }
}
