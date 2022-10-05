<?php

namespace App\Listeners;

use App\Events\ProductConfigUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

class NotifyAPIOnProductConfigUpdate
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
     * @param  object  $event
     * @return void
     */
    public function handle(ProductConfigUpdated $event)
    {
        // log to a txt file
        Http::post(config('app.api_url','https://vasreseller-api-live.herokuapp.com')."/v1/biller/purge-cache", [
            'message' => 'Product config updated',
        ]);
    }
}
