<?php

namespace App\Repository;

use App\Entity\Candidature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Candidature|null find($id, $lockMode = null, $lockVersion = null)
 * @method Candidature|null findOneBy(array $criteria, array $orderBy = null)
 * @method Candidature[]    findAll()
 * @method Candidature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidature::class);
    }

    // /**
    //  * @return Candidature[] Returns an array of Candidature objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Candidature
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function search(string $query, string $order): array
    {
   return $this->createQueryBuilder('c')  
     ->where('c.nom LIKE :query')
     ->orWhere('c.prenom LIKE :query')
     ->orWhere('c.email LIKE :query')
     ->orderBy('c.date_candidature', $order === 'newer' ? 'DESC' : 'ASC' )
     ->setParameter('query', '%'.$query.'%')
     ->getQuery()
     ->getResult();
    }

    public function searchback(string $query, string $order): array{
   return $this->createQueryBuilder('c')
     ->where('c.nom LIKE :query')
     ->orWhere('c.prenom LIKE :query')
     ->orWhere('c.email LIKE :query')
     ->orderBy('c.date_candidature', $order === 'newer' ? 'DESC' : 'ASC' )
     ->setParameter('query', '%'.$query.'%')
     ->getQuery()
     ->getResult();
    }

    public function findCandidatureByName($query){
        return $this->createQueryBuilder('c')
            ->orWhere('c.prenom LIKE :query')
            ->orWhere('c.nom LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->getQuery()
            ->getResult();
    }


}
