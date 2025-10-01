<?php

namespace App\Services\LoggerService;

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

    public function startLogSession(): void
    {
        $this->strategy->startLogSession();
    }

    public function externalServiceLog(): void
    {
        $this->strategy->externalServiceLog();
    }

    public function queryLog(): void
    {
        $this->strategy->queryLog();
    }

    public function commandLog(): void
    {
        $this->strategy->commandLog();
    }

    public function exceptionLog(): void
    {
        $this->strategy->exceptionLog();
    }

    public function finishLogSession(): void
    {
        $this->strategy->finishLogSession();
    }
}
