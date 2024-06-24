<?php

namespace App\Application\UseCase\Query\Fitness;

use App\Domain\Fitness\Repository\ActivityRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class ReadActivityUseCase
{
    /**
     * @var ActivityRepositoryInterface
     */
    private ActivityRepositoryInterface $activityRepository;

    /**
     * @param ActivityRepositoryInterface $activityRepository
     */
    public function __construct(ActivityRepositoryInterface $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    /**
     * @param Uuid $userId
     * @return array
     */
    public function findAll(Uuid $userId): array
    {
        return $this->activityRepository->findAllActivities($userId);

    }

    /**
     * @param Uuid $userId
     * @param string $activityType
     * @return array
     */
    public function findAllFilterByActivityType(Uuid $userId, string $activityType): array
    {
        return $this->activityRepository->findAllActivitiesByType($userId, $activityType);
    }

    /**
     * @param Uuid $userId
     * @return array
     */
    public function totalElapsedTimePerActivityType(Uuid $userId): array
    {
        return $this->activityRepository->totalElapsedTimePerActivityType($userId);
    }

}