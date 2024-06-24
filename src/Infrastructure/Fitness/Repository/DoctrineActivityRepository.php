<?php

namespace App\Infrastructure\Fitness\Repository;

use App\Domain\Fitness\Activity;
use App\Domain\Fitness\Repository\ActivityRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;


class DoctrineActivityRepository extends ServiceEntityRepository implements ActivityRepositoryInterface
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, \App\Infrastructure\Fitness\Doctrine\Entity\Activity::class);
    }

    /**
     * @param Activity $activity
     * @param bool $flush
     * @return void
     */
    public function remove(Activity $activity, bool $flush = false): void
    {
        $doctrineEntity = $this->mapActivityEntity($activity);
        $this->getEntityManager()->remove($doctrineEntity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Activity $activity
     * @return void
     */
    public function save(Activity $activity): void
    {
        $this->add($activity, true);
    }

    /**
     * @param Activity $activity
     * @param bool $flush
     * @return void
     */
    public function add(Activity $activity, bool $flush = false): void
    {
        $doctrineEntity = $this->mapActivityEntity($activity);
        $this->getEntityManager()->persist($doctrineEntity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Activity $activity
     * @return \App\Infrastructure\Fitness\Doctrine\Entity\Activity
     */
    public function mapActivityEntity(Activity $activity): \App\Infrastructure\Fitness\Doctrine\Entity\Activity
    {
        $activityEntity = new \App\Infrastructure\Fitness\Doctrine\Entity\Activity();
        $activityEntity->setActivityType($activity->getActivityType())
            ->setUserId($activity->getUserId())
            ->setActivityDate(new \DateTime('now'))
            ->setDistance($activity->getDistance())
            ->setDistanceUnit($activity->getDistanceUnit())
            ->setElapsedTime($activity->getElapsedTime());
        return $activityEntity;
    }


    /**
     * @return mixed
     */
    public function findAllActivities(Uuid $userId): array
    {
        return $this->getEntityManager()->getRepository(\App\Infrastructure\Fitness\Doctrine\Entity\Activity::class)
            ->findBy(array("user_id" => $userId));
    }

    /**
     * @return mixed
     */
    public function findAllActivitiesByType(Uuid $userId, string $activityType): array
    {
        return $this->getEntityManager()->getRepository(\App\Infrastructure\Fitness\Doctrine\Entity\Activity::class)
            ->findBy(array("activity_type" => $activityType, "user_id" => $userId));

    }

    /**
     * @param Uuid $userId
     * @return array
     */
    public function totalElapsedTimePerActivityType(Uuid $userId): array
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select("sum(f.elapsed_time) as totalTime, f.activity_type AS activityType")
            ->from('App\Infrastructure\Fitness\Doctrine\Entity\Activity', 'f')
            ->where('f.user_id = :userId')
            ->groupBy('f.activity_type')
            ->setParameter('userId', $userId->toBinary())
            ->getQuery()->getArrayResult();

    }

}