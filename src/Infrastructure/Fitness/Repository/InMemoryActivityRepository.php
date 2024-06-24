<?php

namespace App\Infrastructure\Fitness\Repository;

use App\Domain\Fitness\Activity;
use App\Domain\Fitness\Repository\ActivityRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class InMemoryActivityRepository implements ActivityRepositoryInterface
{
    /** @var array<array-key, Activity> */
    protected array $activity = [];

    /**
     * @param Activity $activity
     * @return void
     */
    public function save(Activity $activity): void
    {
        $this->activity[$activity->getId()->toBinary()] = $activity;
    }

    /**
     * @param Uuid $userId
     * @return array
     */
    public function findAllActivities(Uuid $userId): array
    {
        return array();
    }

    /**
     * @param Uuid $userId
     * @param string $activityType
     * @return array
     */
    public function findAllActivitiesByType(Uuid $userId, string $activityType): array
    {
        return array();
    }

    /**
     * @param Uuid $userId
     * @return array
     */
    public function totalElapsedTimePerActivityType(Uuid $userId): array
    {
        return array();
    }

    /**
     * @param Uuid $id
     * @return Activity|null
     */
    public function findOneById(Uuid $id): ?Activity
    {
        return $this->activity[$id->toBinary()] ?? null;
    }
}