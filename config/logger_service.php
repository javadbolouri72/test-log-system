<?php

use App\Enum\LoggerStrategy;

return [
    'mode' => LoggerStrategy::DEFAULT_LOGGER_STRATEGY,
    'redis_database' => 1,
    'booster_cache_ttl' => 10,
    'slow_query_threshold' => 30,
];
