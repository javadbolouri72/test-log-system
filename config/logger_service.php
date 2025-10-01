<?php

use App\Enum\LoggerStrategy;

return [
    'mode' => LoggerStrategy::DEFAULT_LOGGER_STRATEGY,
    'booster_cache_ttl' => 10,
//    'class_tracer' => true,
    'slow_query_threshold' => 30,
];
