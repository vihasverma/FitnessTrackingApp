<?php

namespace App\Infrastructure\Fitness\Doctrine\Entity;

use App\Infrastructure\Fitness\Repository\DoctrineActivityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: DoctrineActivityRepository::class)]
class Activity
{
    /**
     * @var Uuid|null
     */
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid  $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $activity_type = null;

    /**
     * @var \DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $activity_date = null;

    /**
     * @var Uuid|null
     */
    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $user_id = null;

    /**
     * @var float|null
     */
    #[ORM\Column]
    private ?float $distance = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $distance_unit = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $elapsed_time = null;

    /**
     * @return Uuid|null
     */
    public function getId(): ?Uuid
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getActivityType(): ?string
    {
        return $this->activity_type;
    }

    /**
     * @param string $activity_type
     * @return $this
     */
    public function setActivityType(string $activity_type): static
    {
        $this->activity_type = $activity_type;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getActivityDate(): ?\DateTimeInterface
    {
        return $this->activity_date;
    }

    /**
     * @param \DateTimeInterface $activity_date
     * @return $this
     */
    public function setActivityDate(\DateTimeInterface $activity_date): static
    {
        $this->activity_date = $activity_date;

        return $this;
    }

    /**
     * @return Uuid|null
     */
    public function getUserId(): ?Uuid
    {
        return $this->user_id;
    }

    /**
     * @param Uuid $user_id
     * @return $this
     */
    public function setUserId(Uuid $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getDistance(): ?float
    {
        return $this->distance;
    }

    /**
     * @param float $distance
     * @return $this
     */
    public function setDistance(float $distance): static
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDistanceUnit(): ?string
    {
        return $this->distance_unit;
    }

    /**
     * @param string $distance_unit
     * @return $this
     */
    public function setDistanceUnit(string $distance_unit): static
    {
        $this->distance_unit = $distance_unit;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getElapsedTime(): ?int
    {
        return $this->elapsed_time;
    }

    /**
     * @param int $elapsed_time
     * @return $this
     */
    public function setElapsedTime(int $elapsed_time): static
    {
        $this->elapsed_time = $elapsed_time;

        return $this;
    }

}
