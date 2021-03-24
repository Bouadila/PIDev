<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Video::class);
    }

    // /**
    //  * @return Video[] Returns an array of Video objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Video
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function getNB()
    {

        $qb = $this->createQueryBuilder('v')
            ->select('COUNT(v.id) AS vid, SUBSTRING(v.publishDate, 1, 10) AS date')
            ->groupBy('date');
            return $qb->getQuery()
            ->getResult();

    }




    public function findVideoParTitre($title){
        return $this->createQueryBuilder('video')
            ->where('video.title LIKE :title')
            ->setParameter('title', '%'.$title.'%')
            ->getQuery()
            ->getResult();
    }


    public function TriVidParDate(){

        return $this->createQueryBuilder('video')
            ->orderBy('video.publishDate','ASC')
            ->getQuery()
            ->getResult();

    }
    public function filtreVidParDomaine($domaine){

        return $this->createQueryBuilder('video')
            ->where('video.domaine LIKE :domaine')
            ->setParameter('domaine', '%'.$domaine.'%')
            ->getQuery()
            ->getResult();

    }

}
