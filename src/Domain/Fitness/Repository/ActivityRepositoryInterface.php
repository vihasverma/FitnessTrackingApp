<?php

namespace App\Domain\Fitness\Repository;

use App\Domain\Fitness\Activity;
use Symfony\Component\Uid\Uuid;

interface ActivityRepositoryInterface
{
    /**
     * @param Activity $activity
     * @return void
     */
    public function save(Activity $activity): void;

    /**
     * @param Uuid $userId
     * @return mixed
     */
    public function findAllActivities(Uuid $userId): mixed;

    /**
     * @param Uuid $userId
     * @param string $activityType
     * @return array
     */
    public function findAllActivitiesByType(Uuid $userId, string $activityType): array;

    /**
     * @param Uuid $userId
     * @return array
     */
    public function totalElapsedTimePerActivityType(Uuid $userId): array;
}