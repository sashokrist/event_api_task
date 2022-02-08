<?php

namespace App\Observers;

use App\Models\Meet;

class MeetObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param Meet $meet
     * @return void
     */
    public function creating(Meet $meet)
    {
        $meet->user_id = 1;
    }
    /**
     * Handle the Meet "created" event.
     *
     * @param Meet $meet
     * @return void
     */
    public function created(Meet $meet)
    {

    }

    /**
     * Handle the Meet "updated" event.
     *
     * @param Meet $meet
     * @return void
     */
    public function updated(Meet $meet)
    {
        //
    }

    /**
     * Handle the Meet "deleted" event.
     *
     * @param Meet $meet
     * @return void
     */
    public function deleted(Meet $meet)
    {
        //
    }

    /**
     * Handle the Meet "restored" event.
     *
     * @param Meet $meet
     * @return void
     */
    public function restored(Meet $meet)
    {
        //
    }

    /**
     * Handle the Meet "force deleted" event.
     *
     * @param Meet $meet
     * @return void
     */
    public function forceDeleted(Meet $meet)
    {
        //
    }
}
