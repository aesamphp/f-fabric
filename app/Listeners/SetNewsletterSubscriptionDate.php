<?php

namespace App\Listeners;

use App\Events\UserCreate;
use App\Events\UserUpdate;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetNewsletterSubscriptionDate
{
    /**
     * Handle user creation events.
     */
    public function onUserCreate($event)
    {
        if ($event->user->newsletter_email) {
            $event->user->subscribed_at = Carbon::now();
        }
    }

    /**
     * Handle user update events.
     */
    public function onUserUpdate($event)
    {
        $updatedUserFields = $event->user->getDirty();

        if (!empty($updatedUserFields['newsletter_email'])) {
            $event->user->subscribed_at = Carbon::now();
        }
        
        if (isset($updatedUserFields['newsletter_email']) 
            && !$updatedUserFields['newsletter_email']
        ) {
            $event->user->subscribed_at = null;
        }
    }

    public function subscribe($events)
    {
        $events->listen(
            UserCreate::class,
            self::class . '@onUserCreate'
        );

        $events->listen(
            UserUpdate::class,
            self::class . '@onUserUpdate'
        );
    }
}
