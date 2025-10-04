<?php

namespace App\Services\LoggerService\Strategies;

use App\Services\LoggerService\DataObjects\CommandLogData;
use App\Services\LoggerService\DataObjects\ExceptionLogData;
use App\Services\LoggerService\DataObjects\ExternalServiceLogData;
use App\Services\LoggerService\DataObjects\HttpRequestLogData;
use App\Services\LoggerService\DataObjects\PersistLogData;
use App\Services\LoggerService\DataObjects\QueryLogData;

abstract class Logger
{
    /**
     * @param HttpRequestLogData $data
     * @return void
     */
    abstract public static function userHttpRequestLog(HttpRequestLogData $data): void;

    /**
     * @param ExternalServiceLogData $data
     * @return void
     */
    abstract public static function externalServiceLog(ExternalServiceLogData $data): void;

    /**
     * @param QueryLogData $data
     * @return void
     */
    abstract public static function queryLog(QueryLogData $data): void;

    /**
     * @param CommandLogData $data
     * @return void
     */
    abstract public static function commandLog(CommandLogData $data): void;

    /**
     * @param ExceptionLogData $data
     * @return void
     */
    abstract public static function exceptionLog(ExceptionLogData $data): void;

    /**
     * @param PersistLogData $data
     * @return void
     */
    abstract public static function persist(PersistLogData $data): void;

}
