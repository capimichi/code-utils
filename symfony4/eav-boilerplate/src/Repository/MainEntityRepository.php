<?php

namespace App\Repository;

use App\Entity\MainEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MainEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainEntity[]    findAll()
 * @method MainEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MainEntity::class);
    }

    // /**
    //  * @return MainEntity[] Returns an array of MainEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MainEntity
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
