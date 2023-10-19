<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 * @implements PasswordUpgraderInterface<User>
 *
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
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }


    public function upgradeUsername(string $username, string $user): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setUsername($username);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }


    public function findClientWithId($idClient)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT *
            FROM clients c
            INNER JOIN user u 
            ON u.id =  c.user_id 
            WHERE u.id= :idClient
            ';
        $params = ['idClient' => $idClient]; // recupère la valeur de l'url

        $resultSet = $conn->executeQuery($sql, $params);

        // returns un tableau de tableau SANS objet
        return $resultSet->fetchAllAssociative();
        // return $resultSet ->fetch::class

    }

    public function findClient($idClient)
    {
        $entityManager = $this->getEntityManager();

        $sql = '
            SELECT *
            FROM clients c
            INNER JOIN user u 
            ON u.id =  c.user_id 
            WHERE u.id= :idClient
            ';

        $params = ['id' => $idClient];

        $rsm = new ResultSetMappingBuilder($entityManager);
        // $rsm->addRootEntityFromClassMetadata('App\Entity\Client', 'c');

        $query = $entityManager->createNativeQuery($sql, $rsm);
        $query->setParameters($params);
        $client = $query;
        return $client;
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
