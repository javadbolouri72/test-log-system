<?php

namespace App\Services\LoggerService\Strategies;

use App\Services\LoggerService\DataObjects\CommandLogData;
use App\Services\LoggerService\DataObjects\ExceptionLogData;
use App\Services\LoggerService\DataObjects\ExternalServiceLogData;
use App\Services\LoggerService\DataObjects\HttpRequestLogData;
use App\Services\LoggerService\DataObjects\PersistData;
use App\Services\LoggerService\DataObjects\QueryLogData;

interface Logger
{
    /**
     * @param HttpRequestLogData $data
     * @return void
     */
    public static function userHttpRequestLog(HttpRequestLogData $data): void;

    /**
     * @param ExternalServiceLogData $data
     * @return void
     */
    public static function externalServiceLog(ExternalServiceLogData $data): void;

    /**
     * @param QueryLogData $data
     * @return void
     */
    public static function queryLog(QueryLogData $data): void;

    /**
     * @param CommandLogData $data
     * @return void
     */
    public static function commandLog(CommandLogData $data): void;

    /**
     * @param ExceptionLogData $data
     * @return void
     */
    public static function exceptionLog(ExceptionLogData $data): void;

    /**
     * @param PersistData $data
     * @return void
     */
    public static function persist(PersistData $data): void;
}
