<?php

namespace App\Repository;

use App\Entity\Candidature;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\Date;


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

    /**
     * @return mixed
     */
    public function getMonth()
    {

        $qb = $this->createQueryBuilder('v')
            ->select('COUNT(v.id) AS post, SUBSTRING(v.date_candidature, 1, 7) AS month')
            ->groupBy('month');
        return $qb->getQuery()
            ->getResult();
    }
    public function getYear()
    {

        $qb = $this->createQueryBuilder('v')
            ->select('COUNT(v.id) AS post, SUBSTRING(v.date_candidature, 1, 4) AS year')
            ->groupBy('year');
        return $qb->getQuery()
            ->getResult();
    }
    public function getDay()
    {

        $qb = $this->createQueryBuilder('v')
            ->select('COUNT(v.id) AS post, SUBSTRING(v.date_candidature, 1, 10) AS day')
            ->groupBy('day');
        return $qb->getQuery()
            ->getResult();
    }

    /**
     * @param DateTime $date1
     * @param DateTime $date2
     * @return array
     */
    public function searchDate(DateTime $date1, DateTime $date2): array
    {
        return $this->createQueryBuilder('a')
            ->Where('SUBSTRING(a.date_candidature, 1, 10) >= :date1')
            ->andWhere('SUBSTRING(a.date_candidature, 1, 10) <= :date2')
            ->setParameter('date1', $date1->format('Y-m-d'))
            ->setParameter('date2',   $date2->format('Y-m-d'))
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

    /**
     * @param string $query
     * @param string $order
     * @param Integer $id
     * @return array
     */
    public function searchTEST(string $query, string $order, Integer $id): array
    {
        return $this->createQueryBuilder('c')
           // ->select('COUNT(c.id) AS cand WHERE c.id = :id')
               ->where('c.id LIKE :id')
            ->andWhere('c.nom LIKE :query')
            ->orWhere('c.prenom LIKE :query')
            ->orWhere('c.email LIKE :query')
            ->orderBy('c.date_candidature', $order === 'newer' ? 'DESC' : 'ASC' )
            ->setParameter('query', '%'.$query.'%')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $query
     * @param string $order
     * @return array
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

    public function findCandidatureParNom($nom){
        return $this->createQueryBuilder('c')
            ->where('c.nom LIKE :nom')
            ->orWhere('c.prenom LIKE :nom')
            ->orWhere('c.email LIKE :nom')
            ->setParameter('nom', '%'.$nom.'%')
            ->getQuery()
            ->getResult();
    }
}
