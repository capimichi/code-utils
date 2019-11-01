<?php

namespace App\Repository;

use App\Entity\MainEntityAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MainEntityAttribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainEntityAttribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainEntityAttribute[]    findAll()
 * @method MainEntityAttribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainEntityAttributeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MainEntityAttribute::class);
    }

    // /**
    //  * @return MainEntityAttribute[] Returns an array of MainEntityAttribute objects
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
    public function findOneBySomeField($value): ?MainEntityAttribute
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
