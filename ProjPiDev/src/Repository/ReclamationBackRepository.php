<?php

namespace App\Repository;

use App\Entity\ReclamationBack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReclamationBack|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReclamationBack|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReclamationBack[]    findAll()
 * @method ReclamationBack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamationBackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReclamationBack::class);
    }

    // /**
    //  * @return ReclamationBack[] Returns an array of ReclamationBack objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReclamationBack
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
