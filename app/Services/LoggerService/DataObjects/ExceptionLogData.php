<?php

namespace App\Services\LoggerService\DataObjects;

use Carbon\Carbon;

class ExceptionLogData
{
    private int|null $id = null;
    private string $traceId;
    private int|null $userId = null;
    private string $exception;
    private string $trace;
    private string $file;
    private int $line;
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
        $this->exception = $data["exception"];
        $this->trace = $data["trace"];
        $this->file = $data["file"];
        $this->line = $data["line"];
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
            "exception" => $this->exception,
            "trace" => $this->trace,
            "file" => $this->file,
            "line" => $this->line,
            "created_at" => $this->createdAt,
            "updated_at" => $this->updatedAt,
        ];
    }
}
