<?php

namespace App\Repository;

use App\Entity\AlimentLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AlimentLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlimentLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlimentLike[]    findAll()
 * @method AlimentLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlimentLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlimentLike::class);
    }

    // /**
    //  * @return AlimentLike[] Returns an array of AlimentLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AlimentLike
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
