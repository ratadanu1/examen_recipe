<?php

namespace App\Repository;

use App\Entity\recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<recipe>
 *
 * @method recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method recipe[]    findAll()
 * @method recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class recipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, recipe::class);
    }

//    /**
//     * @return recipe[] Returns an array of recipe objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?recipe
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
