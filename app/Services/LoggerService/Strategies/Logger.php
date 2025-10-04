<?php

namespace App\Services\LoggerService\Strategies;

use App\Services\LoggerService\DataObjects\CommandLogData;
use App\Services\LoggerService\DataObjects\ExceptionLogData;
use App\Services\LoggerService\DataObjects\ExternalServiceLogData;
use App\Services\LoggerService\DataObjects\HttpRequestLogData;
use App\Services\LoggerService\DataObjects\QueryLogData;

abstract class Logger
{
    abstract public static function userHttpRequestLog(HttpRequestLogData $data): void;

    abstract public static function externalServiceLog(ExternalServiceLogData $data): void;

    abstract public static function queryLog(QueryLogData $data): void;

    abstract public static function commandLog(CommandLogData $data): void;

    abstract public static function exceptionLog(ExceptionLogData $data): void;
}
