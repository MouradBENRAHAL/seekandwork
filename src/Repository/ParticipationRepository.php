<?php

namespace App\Repository;

use App\Entity\Partitipation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Partitipation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partitipation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partitipation[]    findAll()
 * @method Partitipation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partitipation::class);
    }

    // /**
    //  * @return Partitipation[] Returns an array of Partitipation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Partitipation
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
