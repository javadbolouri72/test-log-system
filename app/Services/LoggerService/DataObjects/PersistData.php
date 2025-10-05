<?php

namespace App\Services\LoggerService\DataObjects;

class PersistData
{
    private string|null $traceId = null;
    private int|null $statusCode = null;
    private int|null $duration = null;
    private string|null $responseData = null;

    /**
     * @param array $data
     * @return void
     */
    public function fromArray(array $data): void
    {
        $this->traceId = $data["trace_id"] ?? null;
        $this->statusCode = $data["status_code"] ?? null;
        $this->responseData = $data["response_data"] ?? null;
        $this->duration = $data["duration"] ?? null;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "trace_id" => $this->traceId,
            "status_code" => $this->statusCode,
            "response_data" => $this->responseData,
            "duration" => $this->duration,
        ];
    }
}
