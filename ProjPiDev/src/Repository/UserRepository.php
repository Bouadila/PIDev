<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }





   



    /**
     * Returns number of "Annonces" per day
     * @return void
     */
    public function rating(){

        $query = $this->createQueryBuilder('a')
            ->update('a.color')
            ->where('user.email LIKE :email');
        return $query->getQuery()->getResult();
    }

    /**
     * Returns number of "Annonces" per day
     * @return void
     */
    public function countByDate2(){
        $query = $this->getEntityManager()->createQuery("
            SELECT SUBSTRING(a.created_at, 1, 10) as dateCompte, COUNT(a) as counte FROM App\Entity\User a GROUP BY dateCompte
        ");
        return $query->getResult();
    }

    /**
     * Returns number of "Annonces" per day
     * @return void
     */
    public function countByDate(){
        $query = $this->createQueryBuilder('a')
            ->select('COUNT(a) as count')
            ->groupBy('a.etat ') ;
        return $query->getQuery()->getResult();
    }

    public function findUserParName($name){
        return $this->createQueryBuilder('user')
            ->where('user.name LIKE :name')
            ->setParameter('name', '%'.$name.'%')
            ->getQuery()
            ->getResult();
    }

}
