<?php

namespace App\Application\UseCase\Command\Fitness;

use Symfony\Component\Uid\Uuid;

class CreateActivityCommand
{
    /**
     * @var Uuid
     */
    private Uuid $userId;
    /**
     * @var string
     */
    private string $activityType;

    /**
     * @var float
     */
    private float $distance;

    /**
     * @var string
     */
    private string $distanceUnit;

    /**
     * @var int
     */
    private int $elapsedTime;

    /**
     * @param string $activityType
     * @param Uuid $userId
     * @param float $distance
     * @param string $distanceUnit
     * @param int $elapsedTime
     */
    public function __construct(Uuid $userId, string $activityType, float $distance, string $distanceUnit, int $elapsedTime)
    {
        $this->activityType = $activityType;
        $this->userId = $userId;
        $this->distance = $distance;
        $this->distanceUnit = $distanceUnit;
        $this->elapsedTime = $elapsedTime;
    }

    /**
     * @return Uuid
     */
    public function getUserId(): Uuid
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getActivityType(): string
    {
        return $this->activityType;
    }

    /**
     * @return float
     */
    public function getDistance(): float
    {
        return $this->distance;
    }

    /**
     * @return string
     */
    public function getDistanceUnit(): string
    {
        return $this->distanceUnit;
    }

    /**
     * @return int
     */
    public function getElapsedTime(): int
    {
        return $this->elapsedTime;
    }

}