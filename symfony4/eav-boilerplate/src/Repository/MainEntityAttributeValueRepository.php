<?php

namespace App\Repository;

use App\Entity\MainEntityAttributeValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MainEntityAttributeValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainEntityAttributeValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainEntityAttributeValue[]    findAll()
 * @method MainEntityAttributeValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainEntityAttributeValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MainEntityAttributeValue::class);
    }

    // /**
    //  * @return MainEntityAttributeValue[] Returns an array of MainEntityAttributeValue objects
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
    public function findOneBySomeField($value): ?MainEntityAttributeValue
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
