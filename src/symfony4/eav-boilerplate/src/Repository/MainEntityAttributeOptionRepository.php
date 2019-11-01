<?php

namespace App\Repository;

use App\Entity\MainEntityAttributeOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MainEntityAttributeOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainEntityAttributeOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainEntityAttributeOption[]    findAll()
 * @method MainEntityAttributeOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainEntityAttributeOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MainEntityAttributeOption::class);
    }

    // /**
    //  * @return MainEntityAttributeOption[] Returns an array of MainEntityAttributeOption objects
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
    public function findOneBySomeField($value): ?MainEntityAttributeOption
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
