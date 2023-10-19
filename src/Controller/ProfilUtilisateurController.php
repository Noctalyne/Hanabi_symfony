<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\User;

use App\Form\ClientsType;
use App\Form\UserType;
use App\Repository\ClientsRepository;
use App\Repository\UserRepository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\objectEquals;

#[Route('/profil/utilisateurs')]
class ProfilUtilisateurController extends AbstractController
{

    #[Route('/', name: 'app_profil_utilisateurs_index', methods: ['GET'])]
    public function index(ClientsRepository $clientsRepository): Response
    {
        // echo "<pre>",
        // var_dump($clientsRepository->findAllWithUser());
        // echo"</pre>";
        return $this->render('profil_utilisateurs/index.html.twig', [
            'clients' => $clientsRepository->findAllWithUser(),
        ]);
    }


    // Route pour ajouter un nouvelle utilisateur --> Version Administrateur (Quasi copie de "registration")
    #[Route('/new', name: 'app_profil_utilisateurs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        $client = new Clients();
        $clientForm = $this->createForm(ClientsType::class, $client);
        $clientForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid() && $clientForm->isSubmitted() && $clientForm->isValid()) {
            
            $client->setEmail($userForm->get('email')->getData()); //Ajoute email à client
            $client->setUsername($userForm->get('username')->getData()); //Ajoute username à  client

            //Ajoute + encode le mot de passe de User et Client
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $userForm->get('plainPassword')->getData()
                )
            );
            $client->setPassword(
                $userPasswordHasher->hashPassword(
                    $client,
                    $userForm->get('plainPassword')->getData()
                )
            );

            // Ajoute les informations du deuxième formulaire
            $client->setPrenomClient($clientForm->get('nom_client')->getData());
            $client->setNomClient($clientForm->get('prenom_client')->getData());
            $client->setTelephone($clientForm->get('telephone')->getData());


            $entityManager->persist($user);
            $entityManager->flush();

            $client->setUser($user); // ajoute les données du user sur client

            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_profil_utilisateurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profil_utilisateurs/new.html.twig', [
            // 'form' => $clientForm->createView(),
            'user' => $user,
            'client' => $client,
            'userForm' => $userForm, 
            'clientForm' => $clientForm, 

        ]);
    }

    // Route pour voir le profil client --> voir pour utiliser sur profil utilisateur
    #[Route('/{idClient}', name: 'app_profil_utilisateurs_show', methods: ['GET'])]
    public function show(int $idClient, ClientsRepository $clientsRepository): Response //EntityManagerInterface $entityManager,
    {
        // Permet de retrouver le client + LES INFOS celon l'id  de l'url 
        $user = $clientsRepository->findClientWithId($idClient);

        return $this->render('profil_utilisateurs/show.html.twig', [
            'client' => $user,
        ]);
    }






    #[Route('/{idClient}/edit', name: 'app_profil_utilisateurs_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        int $idClient,
        User $user,
        Clients $client,
        ClientsRepository $clientsRepository,
        UserRepository $userRepository,
        UserPasswordHasherInterface $userPasswordHasher
    ): Response {
        $clientForm = $this->createForm(ClientsType::class, $client);
        $clientForm->handleRequest($request);


        $user = $userRepository->findClientWithId($idClient);
        $user = $user[0];

        // $user = json_decode(json_encode($user), true);

        echo "<pre>",
        var_dump($user);
        echo "</pre>";
        if ($clientForm->isSubmitted() && $clientForm->isValid()) {

            // 1. Transformez l'objet User en un tableau
            $user = json_decode(json_encode($user), true);

            // 2. Mettez à jour les données dans le tableau
            // $user['email'] = $clientForm->get('email')->getData();
            // Mettez à jour d'autres propriétés au besoin

            // 3. Transformez le tableau en un nouvel objet User
            $newUser = new User();
            // $newUser->setEmail($user['email']);
            // Remarque : Vous devrez également définir les autres propriétés de l'objet User en fonction du tableau

            // Enregistrez les modifications dans la base de données
            $entityManager->persist($newUser);
            $entityManager->flush();

            echo "<pre>",
            var_dump($user);
            echo "</pre>";
        }

        // $user = $userRepository->findClientWithId($idClient);
        // $user = $user[0];
        // // $client =

        // $userForm = $this->createForm(CreateNewClientType::class, $user);
        // $userForm->handleRequest($request);      




        // // $client = $entityManager->getRepository(Clients::class)->findBy($user);
        // $client= $clientsRepository->findClientWithId($idClient);
        // echo "<pre>",
        // var_dump($user);
        // echo "</pre>";

        // echo "<pre>",
        // var_dump($client);
        // echo"</pre>";

        // if ($clientForm->isSubmitted() && $clientForm->isValid() ) {

        //     $newEmail = $userForm->get('email')->getData();

        //     $user -> setEmail($newEmail);

        // //Modifie email de user ET client
        // $user->setEmail($userForm->get('email')->getData());
        // $client->setEmail($userForm->get('email')->getData());

        // // // //Modifie username de user ET client
        // $user->setUsername($clientForm->get('username')->getData());
        // $client->setUsername($clientForm->get('username')->getData());


        // // //Modifie username de user ET client + encode the plain password -> Encode le mot de passe
        // $user->setPassword(
        //     $userPasswordHasher->hashPassword(
        //         $user,
        //         $clientForm->get('plainPassword')->getData()
        //     )
        // );


        // $client->setPassword(
        //     $userPasswordHasher->hashPassword(
        //         $client,
        //         $clientForm->get('plainPassword')->getData()
        //     )
        // );

        // Envoie les info de user dans client 
        // $user->setUser($client);
        // $client->setUser($user);

        // // Enregistre l'entité user
        // $entityManager->persist($user);
        // $entityManager->flush(); // Enregistre les modifications dans la base de données


        // // recupère les informations et les insère dans client
        // $client->setPrenomClient($clientForm->get('nom')->getData());
        // $client->setNomClient($clientForm->get('prenom')->getData());
        // $client->setTelephone($clientForm->get('telephone')->getData());




        //Enregistre l'entité Clients et pemet de s 'assure que l id de user = client

        // $entityManager->persist($client);
        // $entityManager->flush();

        // return $this->redirectToRoute('app_profil_utilisateurs_show', ['idClient' => $idClient], Response::HTTP_SEE_OTHER);



        return $this->render('profil_utilisateurs/edit.html.twig', [
            'client' => $user,
            // var_dump($user[0]),
            'form' => $clientForm,
        ]);
    }
























    #[Route('/{idClient}', name: 'app_profil_utilisateurs_delete', methods: ['POST'])]
    public function delete(Request $request, Clients $client, EntityManagerInterface $entityManager): Response
    {
        var_dump($client->getId());
        if ($this->isCsrfTokenValid('delete' . $client->getId(), $request->request->get('_token'))) {
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_profil_utilisateurs_index', [], Response::HTTP_SEE_OTHER);
    }
}
