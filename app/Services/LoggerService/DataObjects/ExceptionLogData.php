<?php

namespace App\Services\LoggerService\DataObjects;

use Carbon\Carbon;

class ExceptionLogData
{
    private int|null $id = null;
    private string $traceId;
    private int|null $userId = null;
    private string $exception;
    private string $message;
    private string $trace;
    private string $file;
    private int $line;
    private Carbon $startedAt;
    private Carbon $finishedAt;
    private int $duration;
    private Carbon $createdAt;
    private Carbon $updatedAt;

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
        $this->id = $data["id"] ?? null;
        $this->traceId = $data["trace_id"];
        $this->userId = $data["user_id"] ?? null;
        $this->exception = $data["exception"];
        $this->message = $data["message"];
        $this->trace = $data["trace"];
        $this->file = $data["file"];
        $this->line = $data["line"];
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
            "exception" => $this->exception,
            "message" => $this->message,
            "trace" => $this->trace,
            "file" => $this->file,
            "line" => $this->line,
            "started_at" => $this->startedAt,
            "finished_at" => $this->finishedAt,
            "duration" => $this->duration,
            "created_at" => $this->createdAt,
            "updated_at" => $this->updatedAt,
        ];
    }
}
