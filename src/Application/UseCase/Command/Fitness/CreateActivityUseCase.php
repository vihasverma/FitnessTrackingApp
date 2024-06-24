<?php

namespace App\Application\UseCase\Command\Fitness;

use App\Domain\Fitness\Activity;
use App\Domain\Fitness\Exception\InvalidActivityDataException;
use App\Domain\Fitness\Repository\ActivityRepositoryInterface;
use App\Domain\Shared\IdGenerator;
use Symfony\Component\Uid\Uuid;

/**
 *
 */
class CreateActivityUseCase
{
    /**
     * @var ActivityRepositoryInterface
     */
    private ActivityRepositoryInterface $activityRepository;
    /**
     * @var IdGenerator
     */
    private IdGenerator $idGenerator;

    /**
     * @param ActivityRepositoryInterface $activityRepository
     * @param IdGenerator $idGenerator
     */
    public function __construct(ActivityRepositoryInterface $activityRepository, IdGenerator $idGenerator)
    {
        $this->activityRepository = $activityRepository;
        $this->idGenerator = $idGenerator;
    }

    /**
     * @param CreateActivityCommand $activity
     */
    public function create(CreateActivityCommand $activity): Activity
    {
        $id = $this->generateActivityId();
        $this->validate($activity);
        $activity = new Activity($id, $activity->getUserId(), $activity->getActivityType(), $activity->getDistance(), $activity->getDistanceUnit(), $activity->getElapsedTime());
        $this->activityRepository->save($activity);
        return $activity;
    }

    /**
     * @return Uuid
     */
    private function generateActivityId(): Uuid
    {
        return $this->idGenerator->generate();

    }

    /**
     * @param CreateActivityCommand $activity
     * @return void
     * @throws InvalidActivityDataException
     */
    private function validate(CreateActivityCommand $activity): void
    {
        if ($activity->getElapsedTime() == 0) {
            throw new InvalidActivityDataException("Elapsed time cannot be 0");
        }
        if ($activity->getDistance() == 0) {
            throw new InvalidActivityDataException("Distance cannot be 0");
        }
    }

}