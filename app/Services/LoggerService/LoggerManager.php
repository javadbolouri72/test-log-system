<?php

namespace App\Services\LoggerService;

use App\Services\LoggerService\DataObjects\CommandLogData;
use App\Services\LoggerService\DataObjects\ExceptionLogData;
use App\Services\LoggerService\DataObjects\ExternalServiceLogData;
use App\Services\LoggerService\DataObjects\HttpRequestLogData;
use App\Services\LoggerService\DataObjects\QueryLogData;
use App\Services\LoggerService\Strategies\Logger;

class LoggerManager
{
    public function __construct(
        private Logger $strategy
    ) {}

    // Niazi be taghyire strategy dar farayand nist
//    public function changeStrategy(Logger $strategy): void
//    {
//        $this->strategy = $strategy;
//    }

    public function userHttpRequestLog(HttpRequestLogData $data): void
    {
        $this->strategy->userHttpRequestLog($data);
    }

    public function externalServiceLog(ExternalServiceLogData $data): void
    {
        $this->strategy->externalServiceLog($data);
    }

    public function queryLog(QueryLogData $data): void
    {
        $this->strategy->queryLog($data);
    }

    public function commandLog(CommandLogData $data): void
    {
        $this->strategy->commandLog($data);
    }

    public function exceptionLog(ExceptionLogData $data): void
    {
        $this->strategy->exceptionLog($data);
    }

    public function finishLogSession(): void
    {
        $this->strategy->finishLogSession();
    }
}
