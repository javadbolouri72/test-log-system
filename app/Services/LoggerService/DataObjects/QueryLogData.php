<?php

namespace App\Services\LoggerService\DataObjects;

use Carbon\Carbon;

class QueryLogData
{
    private int|null $id = null;
    private string $traceId;
    private int|null $userId = null;
    private string $query;
    private int $duration;
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
        $this->query = $data["query"];
        $this->duration = $data["duration"];
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
            "query" => $this->query,
            "duration" => $this->duration,
            "created_at" => $this->createdAt,
            "updated_at" => $this->updatedAt,
        ];
    }
}
