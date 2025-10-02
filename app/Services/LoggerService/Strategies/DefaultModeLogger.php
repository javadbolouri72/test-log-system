<?php

namespace App\Services\LoggerService\Strategies;

use App\Services\LoggerService\DataObjects\CommandLogData;
use App\Services\LoggerService\DataObjects\ExceptionLogData;
use App\Services\LoggerService\DataObjects\ExternalServiceLogData;
use App\Services\LoggerService\DataObjects\HttpRequestLogData;
use App\Services\LoggerService\DataObjects\QueryLogData;
use Illuminate\Support\Facades\Log;

class DefaultModeLogger extends Logger
{

    public static function userHttpRequestLog(HttpRequestLogData $data): void
    {
        $serialized = json_encode($data->toArray(), JSON_UNESCAPED_UNICODE);
        Log::info("[User Request Log]: $serialized");
    }

    public static function externalServiceLog(ExternalServiceLogData $data): void
    {
        // TODO: Implement externalServiceLog() method.
    }

    public static function queryLog(QueryLogData $data): void
    {
        $serialized = json_encode($data->toArray(), JSON_UNESCAPED_UNICODE);
        Log::info("[Query Log]: $serialized");
    }

    public static function commandLog(CommandLogData $data): void
    {
        // TODO: Implement commandLog() method.
    }

    public static function exceptionLog(ExceptionLogData $data): void
    {
        // TODO: Implement exceptionLog() method.
    }

    public static function finishLogSession(): void
    {
        // TODO: Implement finishLogSession() method.
    }
}
