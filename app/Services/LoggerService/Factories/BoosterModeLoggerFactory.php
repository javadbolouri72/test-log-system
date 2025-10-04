<?php

namespace App\Services\LoggerService\Factories;

use App\Services\LoggerService\Strategies\BoosterModeLogger;
use App\Services\LoggerService\Strategies\Logger;

class BoosterModeLoggerFactory extends LoggerFactory
{
    /**
     * @return Logger
     */
    protected function createLoggerClass(): Logger
    {
        return new BoosterModeLogger();
    }

    /**
     * @return string
     */
    protected function getLoggerClassName(): string
    {
        return BoosterModeLogger::class;
    }
}
