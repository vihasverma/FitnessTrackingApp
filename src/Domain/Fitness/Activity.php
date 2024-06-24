<?php

namespace App\Domain\Fitness;


use Symfony\Component\Uid\Uuid;

class Activity
{
    /**
     * @var Uuid
     */
    private Uuid $id;

    /**
     * @var string
     */
    private string $activityType;

    /**
     * @var Uuid|string
     */
    private Uuid $userId;

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
     * @param Uuid $id
     * @param string $userId
     * @param string $activityType
     * @param string $distanceUnit
     * @param float $distance
     * @param int $elapsedTime
     */
    public function __construct(Uuid $id, Uuid $userId, string $activityType,float $distance,  string $distanceUnit, int $elapsedTime)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->activityType = $activityType;
        $this->distanceUnit = $distanceUnit;
        $this->distance = $distance;
        $this->elapsedTime = $elapsedTime;
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getActivityType(): string
    {
        return $this->activityType;
    }

    /**
     * @return Uuid
     */
    public function getUserId(): Uuid
    {
        return $this->userId;
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