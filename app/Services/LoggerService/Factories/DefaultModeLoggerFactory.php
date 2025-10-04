<?php

namespace App\Services\LoggerService\Factories;

use App\Services\LoggerService\Strategies\Logger;
use App\Services\LoggerService\Strategies\DefaultModeLogger;

class DefaultModeLoggerFactory extends LoggerFactory
{
    /**
     * @return Logger
     */
    protected function createLoggerClass(): Logger
    {
        return new DefaultModeLogger();
    }

    /**
     * @return string
     */
    protected function getLoggerClassName(): string
    {
        return DefaultModeLogger::class;
    }
}
