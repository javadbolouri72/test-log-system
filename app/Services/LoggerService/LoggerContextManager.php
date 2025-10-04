<?php

namespace App\Services\LoggerService;

use App\Enum\LoggerStrategy;
use App\Services\LoggerService\DataObjects\CommandLogData;
use App\Services\LoggerService\DataObjects\ExceptionLogData;
use App\Services\LoggerService\DataObjects\ExternalServiceLogData;
use App\Services\LoggerService\DataObjects\HttpRequestLogData;
use App\Services\LoggerService\DataObjects\PersistLogData;
use App\Services\LoggerService\DataObjects\QueryLogData;
use App\Services\LoggerService\Factories\BoosterModeLoggerFactory;
use App\Services\LoggerService\Factories\DefaultModeLoggerFactory;
use App\Services\LoggerService\Strategies\Logger;
use Illuminate\Support\Facades\App;

final class LoggerContextManager
{
    private const GLOBAL_INSTANCE_POSTFIX = ":Global";

    /**
     * @param Logger $strategy
     * @param string|null $traceId
     */
    public function __construct(
        private readonly Logger $strategy,
        private string|null $traceId = null
    ){}

    /**
     * Comment: برای وقتی که میخوایم در فرایند های خودکار سیستم یک توالی ایجاد کنیم
     * @param string $traceId
     * @return void
     */
    public function setTraceId(string $traceId): void
    {
        $this->traceId = $traceId;
    }

    /**
     * Comment: برای وقتی که میخوایم در فرایند های خودکار سیستم یک توالی ایجاد کنیم
     * @return string|null
     */
    public function getTraceId(): string|null
    {
        return $this->traceId;
    }

//    /**
//     * @return Logger
//     */
//    public function getStrategy(): Logger
//    {
//        return $this->strategy;
//    }

    /**
     * @return self
     */
    public static function instance(): self
    {
        return (request()->header('trace-id') === null)
            ? self::globalInstance()
            : self::requestUniqueInstance();
    }

    /**
     * @return self
     */
    private static function globalInstance(): self
    {
        if (App::bound(self::class . self::GLOBAL_INSTANCE_POSTFIX)) {
            return App::make(self::class . self::GLOBAL_INSTANCE_POSTFIX);
        }

        $factory = new DefaultModeLoggerFactory();

        $loggerStrategy = $factory->makeInstance();

        if (!App::bound(self::class . self::GLOBAL_INSTANCE_POSTFIX)) {
            App::singleton(self::class . self::GLOBAL_INSTANCE_POSTFIX, fn () => new self($loggerStrategy));
        }

        return App::make(self::class . self::GLOBAL_INSTANCE_POSTFIX);
    }

    /**
     * @return self
     */
    private static function requestUniqueInstance(): self
    {
        if (App::bound(self::class)) {
            return App::make(self::class);
        }

        $loggerMode = config('logger_service.mode', LoggerStrategy::DEFAULT_LOGGER_STRATEGY);

        $factory = $loggerMode === LoggerStrategy::DEFAULT_LOGGER_STRATEGY
            ? new DefaultModeLoggerFactory()
            : new BoosterModeLoggerFactory();

        $loggerStrategy = $factory->makeInstance();

        if (!App::bound(self::class)) {
            App::singleton(self::class, fn () => new self($loggerStrategy));
        }

        return App::make(self::class);
    }

    /**
     * @param HttpRequestLogData $data
     * @return void
     */
    public function userHttpRequestLog(HttpRequestLogData $data): void
    {
        $this->strategy->userHttpRequestLog($data);
    }

    /**
     * @param ExternalServiceLogData $data
     * @return void
     */
    public function externalServiceLog(ExternalServiceLogData $data): void
    {
        $this->strategy->externalServiceLog($data);
    }

    /**
     * @param QueryLogData $data
     * @return void
     */
    public function queryLog(QueryLogData $data): void
    {
        $this->strategy->queryLog($data);
    }

    /**
     * @param CommandLogData $data
     * @return void
     */
    public function commandLog(CommandLogData $data): void
    {
        $this->strategy->commandLog($data);
    }

    /**
     * @param ExceptionLogData $data
     * @return void
     */
    public function exceptionLog(ExceptionLogData $data): void
    {
        $this->strategy->exceptionLog($data);
    }

    /**
     * @param string $traceId
     * @return void
     */
    public function persist(PersistLogData $data): void
    {
        $this->strategy->persist($data);
    }
}
