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
        // créa query pour recup donnée
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

        // Recup les donnée et les renvoie sous forme de tableau assoc
        $test = $resultSet->fetchAllAssociative();


        // $test['user_role'] = ['ROLE_USER'];
        

        //Crée un nouveau "user" et lui attribut les donné récupéré dans le tableau
        $user = new User() ;
        $user ->setId($idClient);
        // $user->setRoles([$test[0]['user_role']]) ;
        $user->setUsername($test[0]['username']) ;
        $user->setEmail($test[0]['email']) ;
        $user->setPassword($test[0]['user_password']) ;

        $tel = $test[0]['telephone'];
        //Crée un nouveau "clients" et lui attribut les donné récupéré dans le tableau -> permet de renvoyer un objet 
        $client = new Clients();
        $client->setUser($user);
        $client->setId($idClient);
        $client->setUsername($test[0]['username']) ;
        $client->setEmail($test[0]['email']) ;
        $client->setPassword($test[0]['user_password']) ;
        $client->setNomClient($test[0]['nom_client']);
        $client->setPrenomClient($test[0]['nom_client']);
        $client->setTelephone($tel); 
        
        return $client;
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
