<?php

namespace App\Services\LoggerService\Factories;

use App\Services\LoggerService\Strategies\BoosterModeLogger;
use App\Services\LoggerService\Strategies\Logger;

class BoosterModeLoggerFactory extends LoggerFactory
{
    protected function createLoggerClass(): Logger
    {
        return new BoosterModeLogger($this->traceId);
    }
}
