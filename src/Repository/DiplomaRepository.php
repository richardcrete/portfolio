<?php

namespace App\Repository;

use App\Entity\Diploma;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DiplomaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Diploma::class);
    }

    public function getDiplomas() {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('r')
            ->from(Diploma::class, 'r')
            ->orderBy('r.startDate', 'desc')
            ->addOrderBy('r.endDate', 'desc')
            ->getQuery()
            ->getResult();
    }
}
