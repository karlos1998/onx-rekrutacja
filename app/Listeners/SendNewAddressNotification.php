<?php

namespace App\Listeners;

use App\Events\NewAddress;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewAddressNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewAddress  $event
     * @return void
     */
    public function handle(NewAddress $event)
    {
        //
    }
}
