<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }
    /**
    //  * @return Formation[] Returns an array of Event objects
    //  */

    public function findEntitiesByString($str)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT p 
        FROM App:Event p
        WHERE p.titre LIKE :str'

            )->setParameter('str', '%'.$str.'%')->getResult();
    }
   /* public function findmaterialbyattributs($name)
    {

        $Query=$this->getEntityManager()
            ->createQuery("select e from App\Entity\Event e where e.titre LIKE :name ")
            ->setParameter('name','%'.$name.'%');
        return $Query->getResult();
    }*/
    public function findmaterialbyattributs($name)
    {

        $Query=$this->getEntityManager()
            ->createQuery("select e from App\Entity\Event e where e.titre LIKE :name or e.titre LIKE :name or e.description LIKE :name")
            ->setParameter('name','%'.$name.'%');
        return $Query->getResult();
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
