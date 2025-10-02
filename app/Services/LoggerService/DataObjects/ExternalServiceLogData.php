<?php

namespace App\Services\LoggerService\DataObjects;

use Carbon\Carbon;

class ExternalServiceLogData
{
    public function __construct(
        private int|null $id = null,
        private string $traceId,
        private int|null $userId = null,
        private string $url,
        private string $method,
        private string|null $requestHeaders,
        private string|null $requestPayload,
        private string $statusCode,
        private string|null $responseHeaders,
        private string|null $responseData,
        private Carbon $startedAt,
        private Carbon $finishedAt,
        private int $duration,
        private Carbon $createdAt,
        private Carbon $updatedAt
    ){}

    public function __clone()
    {
        $this->startedAt = clone $this->startedAt;
        $this->finishedAt = clone $this->finishedAt;
        $this->createdAt = clone $this->createdAt;
        $this->updatedAt = clone $this->updatedAt;
    }

    /**
     * @param array $data
     * @return void
     */
    public function fromArray(array $data): void
    {
        $this->id = $data["id"];
        $this->traceId = $data["trace_id"];
        $this->userId = $data["user_id"];
        $this->url = $data["url"];
        $this->method = $data["method"];
        $this->requestHeaders = $data["request_headers"];
        $this->requestPayload = $data["request_payload"];
        $this->statusCode = $data["status_code"];
        $this->responseHeaders = $data["response_headers"];
        $this->responseData = $data["response_data"];
        $this->startedAt = $data["started_at"];
        $this->finishedAt = $data["finished_at"];
        $this->duration = $data["duration"];
        $this->createdAt = $data["created_at"];
        $this->updatedAt = $data["updated_at"];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "trace_id" => $this->traceId,
            "user_id" => $this->userId,
            "url" => $this->url,
            "method" => $this->method,
            "request_headers" => $this->requestHeaders,
            "request_payload" => $this->requestPayload,
            "status_code" => $this->statusCode,
            "response_headers" => $this->responseHeaders,
            "response_data" => $this->responseData,
            "started_at" => $this->startedAt,
            "finished_at" => $this->finishedAt,
            "duration" => $this->duration,
            "created_at" => $this->createdAt,
            "updated_at" => $this->updatedAt,
        ];
    }
}
