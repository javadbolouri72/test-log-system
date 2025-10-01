<?php

namespace App\Services\LoggerService\Strategies;

abstract class Logger
{
    private static ?string $traceId;

    public function __construct(?string $traceId)
    {
        self::$traceId = $traceId;
    }
    abstract public static function startLogSession(): void;

    abstract public static function externalServiceLog(): void;

    abstract public static function queryLog(): void;

    abstract public static function commandLog(): void;

    abstract public static function exceptionLog(): void;

//    abstract public static function classTracerLog(): void;
    abstract public static function finishLogSession(): void;
}
