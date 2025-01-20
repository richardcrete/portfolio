<?php

namespace App\Repository;

use App\Entity\Experience;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ExperienceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Experience::class);
    }

    public function getExperiences(): mixed
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('r', 'p', 't')
            ->from(Experience::class, 'r')
            ->leftJoin('r.translations', 'p')
            ->leftJoin('r.tools', 't')
            ->orderBy('r.startDate', 'desc')
            ->addOrderBy('r.endDate', 'desc')
            ->getQuery()
            ->getResult();
    }
}
