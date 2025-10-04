<?php

namespace App\Services\LoggerService\DataObjects;


use Carbon\Carbon;

class CommandLogData
{
    private int|null $id = null;
    private string|null $traceId = null;
    private int|null $userId = null;
    private string $command;
    private int $duration;
    private string|null $input = null;
    private string|null $output = null;
    private int $exitCode = 0;

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
        $this->traceId = $data["trace_id"] ?? null;
        $this->userId = $data["user_id"] ?? null;
        $this->command = $data["command"];
        $this->input = $data["input"] ?? null;
        $this->output = $data["output"] ?? null;
        $this->exitCode = $data["exit_code"] ?? null;
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
            "command" => $this->command,
            "duration" => $this->duration,
            "input" => $this->input,
            "output" => $this->output,
            "exit_code" => $this->exitCode,
            "created_at" => $this->createdAt,
            "updated_at" => $this->updatedAt,
        ];
    }
}
