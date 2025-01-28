<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function getProjects(): mixed
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('r', 'p', 't')
            ->from(Project::class, 'r')
            ->leftJoin('r.translations', 'p')
            ->leftJoin('r.tools', 't')
            ->orderBy('r.onGoing', 'desc')
            ->addOrderBy('r.endDate', 'desc')
            ->addOrderBy('r.startDate', 'desc')
            ->getQuery()
            ->getResult();
    }
}
