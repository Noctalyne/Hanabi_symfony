<?php

namespace App\Repository;

use App\Entity\Clients;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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


    // Requete qui permet de trouver le client celon User et récupérer ses infos
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
    }

    public function findClient($idClient)
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * 
            FROM `clients` as c
            INNER JOIN `user` as u
            ON u.id =  c.user_id 
            WHERE u.id = :idClient
            ';
        $params = ['idClient' => $idClient]; // recupère la valeur de l'url

        $resultSet = $conn->executeQuery($sql, $params);


        $test = $resultSet->fetchAssociative();

        // $user = new User() ;
        // $user ->setId($idClient);
        // $user->setRoles([$test[0]['user_role']]) ;
        // $user->setUsername($test['username']) ;
        // $user->setEmail($test['email']) ;
        // $user->setPassword($test['password']) ;


        //Crée un nouveau "clients" et lui attribut les donné récupéré dans le tableau -> permet de renvoyer un objet 
        $client = new Clients();
        // $client->setUser($user);
        $client->setId($idClient);
        $client->setUsername($test['username']) ;
        $client->setEmail($test['email']) ;
        $client->setPassword($test['password']) ;
        $client->setNomClient($test['nomClient']);
        $client->setPrenomClient($test['prenomClient']);
        $client->setTelephone($test['telephone']); // Accéder à l'attribut ID
        
        return $client;
        // returns un tableau de tableau SANS objet


        // créa query pour recup donnée

        // return $this->createQueryBuilder('c')
        //     ->select('*')
        //     ->from( 'clients', 'c')
        //     ->innerJoin('user', 'u')
        //     ->where('u.id = :idClient')
        //     ->setParameter('idClient', $idClient)
        //     ->getQuery()
        //     ->getOneOrNullResult();

        // Recup les donnée et les renvoie sous forme de tableau assoc
    }


    //n7, c1_.user_id AS user_id_8 FROM clients c1_ INNER JOIN user u2_ ON c1_.user_id = u2_.id WHERE u2_.id 



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

    //    public function findOneBySomeField($idCLient): ?Clients
    //    {
    //        return $this->createQueryBuilder('id')
    //        ->select('id')
    //        ->from(Clients::class, 'clients')
    //        ->innerJoin(User::class ,'u' ,'u.id =  clients.user_id')
    //            ->andWhere('u.id = :idclient')
    //            ->setParameter('idclient', $idCLient)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
