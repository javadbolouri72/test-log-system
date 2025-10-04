<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\Facades\Cache;

class CommandStartListener
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
    public function handle(CommandStarting $event): void
    {
        $traceId = request()->headers->has('trace_id') ? request()->headers->get('trace_id') : 'NA';
        Cache::set("{$traceId}_command_duration_$event->command", Carbon::now());
    }
}
