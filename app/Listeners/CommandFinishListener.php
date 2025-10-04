<?php

namespace App\Listeners;

use App\Services\LoggerService\DataObjects\CommandLogData;
use App\Services\LoggerService\LoggerContextManager;
use Carbon\Carbon;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class CommandFinishListener
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
    public function handle(CommandFinished $event): void
    {
        $now = Carbon::now();
        $traceId = request()->headers->has('trace_id') ? request()->headers->get('trace_id') : 'NA';
        $cachedCommandTime = Cache::get("{$traceId}_command_start_time_$event->command");

        $commandStartedAt = Carbon::parse($cachedCommandTime);
        $duration = (int)$commandStartedAt->diffInUTCMilliseconds($now);

        $logger = LoggerContextManager::instance();

        $commandLogDataObject = new CommandLogData();

        $commandLogDataObject->fromArray([
            'trace_id' => request()->header('trace_id'),
            'user_id' => request()->user()?->id,
            'command' => $event->command,
            'duration' => $duration,
            'input' => json_encode($event->input, JSON_UNESCAPED_UNICODE),
            'output' => json_encode($event->output, JSON_UNESCAPED_UNICODE),
            'exit_code' => $event->exitCode,
        ]);

        $logger->commandLog($commandLogDataObject);
    }
}
