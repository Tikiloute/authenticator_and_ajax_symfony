<?php

namespace App\Repository;

use App\Entity\Aliment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Aliment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aliment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aliment[]    findAll()
 * @method Aliment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlimentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aliment::class);
    }

    public function getAlimentsParNbreCalories($propriete, $signe, $calorie)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.'.$propriete.' '.$signe.' :val')
            ->setParameter('val', $calorie)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAlimentsByCategory($category = null)
    {
        $query = $this->createQueryBuilder('a');

        if ($category != null){
            $query->andWhere('a.category IN (:cats)')
                ->setParameter(':cats', array_values($category));
        }
                   
               return $query->getQuery()->getResult();
    }

    public function findBySearch($search)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.nom LIKE :val')
            ->setParameter('val', '%'.$search.'%')
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return Aliment[] Returns an array of Aliment objects
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
    public function findOneBySomeField($value): ?Aliment
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
