<?php

namespace Src\Domain\Entity;

use Carbon\Carbon;

class TaskTime implements \JsonSerializable
{
    private int $id;
    private int $taskId;
    private \DateTime $startAt;
    private ?\DateTime $endAt;

    public function __construct(int $taskId, int $id = 0, \DateTime $startAt = null, ?\DateTime $endAt = null)
    {
        $this->id = $id;
        $this->taskId = $taskId;
        $this->startAt = $startAt ?? new \DateTime();
        $this->endAt = $endAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTaskId(): string
    {
        return $this->taskId;
    }

    public function getStartAt(): \DateTime
    {
        return $this->startAt;
    }

    public function getEndAt(): ?\DateTime
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTime $endAt): void
    {
        $this->endAt = $endAt;
    }

    public function getDuration() : int
    {
        if ($this->endAt) {
            return $this->startAt->diff($this->endAt)->s;
        }
        return $this->startAt->diff(Carbon::now())->s;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'task_id' => $this->taskId,
            'start_at' => $this->startAt->format('Y-m-d H:i:s'),
            'end_at' => $this->endAt?->format('Y-m-d H:i:s'),
            'duration' => $this->getDuration()
        ];
    }

}
