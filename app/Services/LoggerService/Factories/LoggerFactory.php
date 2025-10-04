<?php

namespace App\Services\LoggerService\Factories;

use App\Services\LoggerService\Strategies\Logger;
use Illuminate\Support\Facades\App;

abstract class LoggerFactory
{
    /**
     * @return Logger
     */
    final public function makeInstance(): Logger
    {
        $loggerClassName = $this->getLoggerClassName();

        if (!App::bound($loggerClassName)){
            $loggerClass = $this->createLoggerClass();
            App::singleton($loggerClassName, fn() => $loggerClass);
        }

        return App::make($loggerClassName);
    }

    /**
     * @return Logger
     */
    abstract protected function createLoggerClass(): Logger;

    /**
     * @return string
     */
    abstract protected function getLoggerClassName(): string;

}
