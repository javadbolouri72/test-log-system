<?php

namespace App\Services\LoggerService;

use App\Enum\LoggerStrategy;
use App\Services\LoggerService\DataObjects\CommandLogData;
use App\Services\LoggerService\DataObjects\ExceptionLogData;
use App\Services\LoggerService\DataObjects\ExternalServiceLogData;
use App\Services\LoggerService\DataObjects\HttpRequestLogData;
use App\Services\LoggerService\DataObjects\QueryLogData;
use App\Services\LoggerService\Factories\BoosterModeLoggerFactory;
use App\Services\LoggerService\Factories\DefaultModeLoggerFactory;
use App\Services\LoggerService\Strategies\Logger;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

readonly class LoggerManager
{
    private const GLOBAL_POSTFIX = ":Global";
    public function __construct(
        private Logger $strategy
    ) {}

    public static function instance(): self
    {
        return (request()->header('trace-id') === null)
            ? self::globalInstance()
            : self::requestUniqueInstance();
    }

    private static function globalInstance(): self
    {
        if (App::bound(self::class . self::GLOBAL_POSTFIX)) {
            return App::make(self::class . self::GLOBAL_POSTFIX);
        }

        $loggerMode = config('logger_service.mode');

        $factory = $loggerMode === LoggerStrategy::DEFAULT_LOGGER_STRATEGY
            ? new DefaultModeLoggerFactory()
            : new BoosterModeLoggerFactory();

        $loggerStrategy = $factory->makeInstance();

        if (!App::bound(self::class . self::GLOBAL_POSTFIX)) {
            App::singleton(self::class . self::GLOBAL_POSTFIX, fn () => new self($loggerStrategy));
        }

        return App::make(self::class . self::GLOBAL_POSTFIX);
    }

    private static function requestUniqueInstance(): self
    {
        if (App::bound(self::class)) {
            return App::make(self::class);
        }

        $loggerMode = config('logger_service.mode');

        $factory = $loggerMode === LoggerStrategy::DEFAULT_LOGGER_STRATEGY
            ? new DefaultModeLoggerFactory()
            : new BoosterModeLoggerFactory();

        $loggerStrategy = $factory->makeInstance();

        if (!App::bound(self::class)) {
            App::singleton(self::class, fn () => new self($loggerStrategy));
        }

        return App::make(self::class);
    }

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
