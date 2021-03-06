<?php

namespace App\Repository;

use App\Entity\Demande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Demande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Demande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Demande[]    findAll()
 * @method Demande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Demande::class);
    }

    // /**
    //  * @return Demande[] Returns an array of Demande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Demande
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

   /* public function search(string $query, string $order): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.TitreDemande LIKE :query')
            ->orWhere('c.statutCand LIKE :query')
            ->orWhere('c.domaineTravail LIKE :query')
            ->orderBy('c.statutCand', $order === 'Bac' ? 'ASC' : 'DESC')
            ->setParameter('query', '%'.$query.'%')
            ->getQuery()
            ->getResult();
    }
*/

    public function OrderByStatut()
    {
        return $this->createQueryBuilder('demande')
            ->orderBy('demande.statutCand','ASC')
            ->getQuery()
            ->getResult();
    }


    public function countNbDemande(){
        return $this->createQueryBuilder('d')


            ->Select('COUNT(d.id)')


            // ->andWhere('e.NomProjet= :val')
            //->setParameter('val', $id)

            ->getQuery()

            ->getSingleScalarResult();
    }


    public function findDemandePardomaineTravail($domaineTravail){
        return $this->createQueryBuilder('demande')
            ->where('demande.domaineTravail LIKE :domaineTravail')
            ->setParameter('domaineTravail', '%'.$domaineTravail.'%')
            ->getQuery()
            ->getResult();
    }

    public function findStatutCand($statutCand){
        return $this->createQueryBuilder('demande')
            ->where('demande.statutCand = :statutCand')
            ->setParameter('statutCand',$statutCand)
            ->getQuery()
            ->getResult();


    }

}
