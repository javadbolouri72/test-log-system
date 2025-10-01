<?php

namespace App\Services\LoggerService\Factories;

use App\Services\LoggerService\Strategies\Logger;
use App\Services\LoggerService\Strategies\DefaultModeLogger;
use Illuminate\Support\Facades\App;

class DefaultModeLoggerFactory extends LoggerFactory
{
    protected function createLoggerClass(): Logger
    {
        return new DefaultModeLogger($this->traceId);
    }
}
