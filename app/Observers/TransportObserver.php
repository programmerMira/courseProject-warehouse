<?php

namespace App\Observers;

use App\Transport;

class TransportObserver
{
    /**
     * Handle the Transport "created" event.
     *
     * @param  \App\Models\Transport  $transport
     * @return void
     */
    public function created(Transport $transport)
    {
        //
    }

    /**
     * Handle the Transport "updated" event.
     *
     * @param  \App\Models\Transport  $transport
     * @return void
     */
    public function updated(Transport $transport)
    {
        //
    }

    /**
     * Handle the Transport "deleted" event.
     *
     * @param  \App\Models\Transport  $transport
     * @return void
     */
    public function deleted(Transport $transport)
    {
        $transport->update([
            'title' => time() . '::' . $transport->title
        ]);
    }

    /**
     * Handle the Transport "restored" event.
     *
     * @param  \App\Models\Transport  $transport
     * @return void
     */
    public function restored(Transport $transport)
    {
        //
    }

    /**
     * Handle the Transport "force deleted" event.
     *
     * @param  \App\Models\Transport  $transport
     * @return void
     */
    public function forceDeleted(Transport $transport)
    {
        //
    }
}
