<?php

namespace App\Repository;

use App\Entity\Material;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Material>
 */
class MaterialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Material::class);
    }

    /**
     * findMaterials.
     *
     * @return array<mixed>
     */
    public function findMaterials(int $start, int $length, string $search, string $column, string $orderBy): array
    {
        $qb = $this->createQueryBuilder('m')
            ->setFirstResult(firstResult: $start)
            ->setMaxResults($length)
            ->where('m.name LIKE :search')
            ->orderBy('m.'.$column, $orderBy)
            ->setParameter('search', '%'.$search.'%');

        $query = $qb->getQuery();

        return $query->execute();
    }
}
