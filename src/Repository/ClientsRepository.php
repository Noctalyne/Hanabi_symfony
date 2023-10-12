<?php

namespace App\Repository;

use App\Entity\Clients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Clients>
 *
 * @method Clients|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clients|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clients[]    findAll()
 * @method Clients[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Clients::class);
    }

    // Pour récupérer la liste des clients via l entité user
    public function findAllWithUser()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT *
            FROM clients c
            INNER JOIN user u ON u.id = c.user_id
            ';

        $resultSet = $conn->executeQuery($sql);

        // returns un tableau de tableau SANS objet
        return $resultSet->fetchAllAssociative();
    }

    public function findClientWithId()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT *
            FROM clients c
            INNER JOIN user u 
            ON u.id = c.user_id
            WHERE u.id= c.id

            ';

        $resultSet = $conn->executeQuery($sql);

        // returns un tableau de tableau SANS objet
        return $resultSet->fetchAllAssociative();
    }



    //    /**
    //     * @return Clients[] Returns an array of Clients objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Clients
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
