<?php

namespace App\Services\LoggerService\Strategies;

use App\Services\LoggerService\DataObjects\CommandLogData;
use App\Services\LoggerService\DataObjects\ExceptionLogData;
use App\Services\LoggerService\DataObjects\ExternalServiceLogData;
use App\Services\LoggerService\DataObjects\HttpRequestLogData;
use App\Services\LoggerService\DataObjects\QueryLogData;

class DefaultModeLogger extends Logger
{

    public static function userHttpRequestLog(HttpRequestLogData $data): void
    {
        // TODO: Implement userHttpRequestLog() method.
    }

    public static function externalServiceLog(ExternalServiceLogData $data): void
    {
        // TODO: Implement externalServiceLog() method.
    }

    public static function queryLog(QueryLogData $data): void
    {
        // TODO: Implement queryLog() method.
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
