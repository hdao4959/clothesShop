<?php

namespace App\Listeners;

use App\Events\StartShipping;
use App\Mail\StartShippingMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ShippingMailListener implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StartShipping $event): void
    {
        Mail::mailer()->to($event->dataUser['email'])->send(new StartShippingMail($event->dataUser['email']));
    }
}
