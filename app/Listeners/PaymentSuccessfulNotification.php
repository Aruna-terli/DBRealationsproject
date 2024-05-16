<?php

namespace App\Listeners;

use App\Events\PaymentSuccessfull;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PaymentSuccessfulNotification
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
     * @param  \App\Events\PaymentSuccessfull  $event
     * @return void
     */
    public function handle(PaymentSuccessfull $event)
    {
        \Log::info('payment is successfull for  The '. $event->payment['notes']['product_name'] .'amount paid is '. $event->payment['amount']/100 );
    }
}
