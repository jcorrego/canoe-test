<?php

namespace App\Listeners;

use App\Events\DuplicateFundWarning;
use App\Models\PotentialDuplicate;

class CreatePotentialDuplicate
{
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
    public function handle(DuplicateFundWarning $event): void
    {
        $potentialDuplicate = new PotentialDuplicate();
        $potentialDuplicate->originalFund()->associate($event->originalFund);
        $potentialDuplicate->duplicateFund()->associate($event->duplicateFund);
        $potentialDuplicate->save();
    }
}
