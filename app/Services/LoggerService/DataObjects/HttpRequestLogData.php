<?php

namespace App\Services\LoggerService\DataObjects;

use Carbon\Carbon;

class HttpRequestLogData
{
    private int|null $id = null;
    private string $traceId;
    private int|null $userId = null;
    private string $url;
    private string $method;
    private string $action;
    private string $ip;
    private string|null $requestHeaders;
    private string|null $requestPayload;
    private string|null $statusCode;
    private string|null $responseHeaders;
    private string|null $responseData;
    private int|null $duration;
    private Carbon $createdAt;
    private Carbon $updatedAt;

    public function __clone()
    {
        $this->createdAt = clone $this->createdAt;
        $this->updatedAt = clone $this->updatedAt;
    }

    /**
     * @param array $data
     * @return void
     */
    public function fromArray(array $data): void
    {
        $this->id = $data["id"] ?? null;
        $this->traceId = $data["trace_id"];
        $this->userId = $data["user_id"] ?? null;
        $this->url = $data["url"];
        $this->method = $data["method"];
        $this->action = $data["action"];
        $this->ip = $data["ip"];
        $this->requestHeaders = $data["request_headers"] ?? null;
        $this->requestPayload = $data["request_payload"] ?? null;
        $this->statusCode = $data["status_code"] ?? null;
        $this->responseHeaders = $data["response_headers"] ?? null;
        $this->responseData = $data["response_data"] ?? null;
        $this->duration = $data["duration"] ?? null;
        $this->createdAt = $data["created_at"] ?? Carbon::now();
        $this->updatedAt = $data["updated_at"] ?? Carbon::now();
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
            "action" => $this->action,
            "ip" => $this->ip,
            "request_headers" => $this->requestHeaders,
            "request_payload" => $this->requestPayload,
            "status_code" => $this->statusCode,
            "response_headers" => $this->responseHeaders,
            "response_data" => $this->responseData,
            "duration" => $this->duration,
            "created_at" => $this->createdAt,
            "updated_at" => $this->updatedAt,
        ];
    }
}
