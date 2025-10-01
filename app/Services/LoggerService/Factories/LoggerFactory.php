<?php

namespace App\Services\LoggerService\Factories;

use App\Services\LoggerService\Strategies\DefaultModeLogger;
use App\Services\LoggerService\Strategies\Logger;
use Illuminate\Support\Facades\App;

abstract class LoggerFactory
{
    protected Logger $logger;

    public function __construct(readonly protected ?string $traceId){}
    final public function makeInstance(): Logger
    {
        $this->logger = $this->createLoggerClass();
        return $this->bindSingletonInstance($this->logger);
    }

    abstract protected function createLoggerClass(): Logger;
    final protected function bindSingletonInstance(Logger $logger): Logger {
        // Todo: Singleton Bind $this->logger::class
        // Todo return bounded logger class
    }
}
