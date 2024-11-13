<?php

namespace Src\Domain\Repository;


use Src\Domain\Entity\Task;

interface TaskRepositoryInterface
{
    public function getOrCreateByName(string $name) : Task;
    public function getByName(string $name) : ?Task;
    public function getAllWorkedToday() : array;
}
