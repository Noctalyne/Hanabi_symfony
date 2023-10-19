<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\User;

use App\Form\ClientsType;
use App\Form\UserType;
use App\Repository\ClientsRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Expr\Value;
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
        int $idClient,
        // int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        ClientsRepository $clientsRepository,
        Clients $client,
        User $user,
        UserRepository $userRepository
    ): Response {


        $clientForm = $this->createForm(ClientsType::class, $client);
        $clientForm->handleRequest($request);


        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);


        $clientData = $clientsRepository->findClientWithId($idClient);
        $client = [
            "id" => $clientData[0]["id"],
            "roles" => $clientData[0]["user_role"],
            "email" => $clientData[0]["email"],
            "username" => $clientData[0]["username"],
            "password" => $clientData[0]["user_password"],
            "nomClient" => $clientData[0]["nom_client"],
            "prenomClient" => $clientData[0]["prenom_client"],
            "telephone" => $clientData[0]["telephone"],
        ];

        // echo "<pre>",
        // var_dump("Objet clientData"),
        // var_dump($clientData);
        // echo "</pre>";


        $userData = $userRepository->findClientWithId($idClient); // retourne un array
        $user = [
            "id" => $userData[0]["id"],
            "roles" => $userData[0]["user_role"],
            "email" => $userData[0]["email"],
            "username" => $userData[0]["username"],
            "password" => $userData[0]["user_password"],
            // "nomClient" => $userData[0]["nom_client"],
            // "prenomClient" => $userData[0]["prenom_client"],
            // "telephone" => $userData[0]["telephone"],
        ];


        echo "<pre>",
        var_dump("Objet user"),
        var_dump($user);
        echo "</pre>";



        if ($userForm->isSubmitted() && $userForm->isValid() && $clientForm->isSubmitted() && $clientForm->isValid()) {

            // if ($clientData && $userData){

            // $verifInfos= $userForm->get("email")->getData() ;
            

            $userModif = [
                // "email" => $userData[0]["email"],
                "username" => $userData[0]["username"],
                "plainPassword" => $userData[0]["user_password"],
            ];

            foreach ($userModif as $cle => $valeur ) {
                $verif = $valeur ;
                $verifFormUser= $userForm->get($cle)->getData();
                if ( $verif !== $verifFormUser){
                    // if()
                    $userData[$cle] = $verifFormUser;
                }
            }
            // var_dump("<pre>");
            // var_dump($user);
            // var_dump("</pre>");



            $clientModif = [
                "nomClient" => $clientData[0]["nom_client"],
                "prenomClient" => $clientData[0]["prenom_client"],
                "telephone" => $clientData[0]["telephone"],
            ];

            foreach ($clientModif as $cle => $valeur ) {
                $verif = $valeur ;
                $verifFormClient = $clientForm->get($cle)->getData();
                if ( $verif === $verifFormClient ){
                    $client[$cle] = $verifFormClient;
                }
            }

            
            $modifUser = $userRepository->findClient($idClient);
            // var_dump($modifUser);
            // $modifUser-> setUsername($clientModif["username"]);
            // $modifUser-> setEmail($clientModif["email"]);
            // $modifUser-> setPassword($clientModif["plainPassword"]); 

            $modifClient =$entityManager->getRepository(Clients::class)->find($idClient);;
            // $modifClient-> setNomClient($clientModif["nomClient"]);
            // $modifClient-> setPrenomClient($clientModif["prenomClient"]);
            // $modifClient-> setTelephone($clientModif["telephone"]);
            // $modifClient-> setUser($modifUser);


            // $entityManager->persist($client);
            // $entityManager->persist($client);

            $entityManager->flush();

            return $this->redirectToRoute('app_profil_utilisateurs_show', ['idClient' => $idClient], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profil_utilisateurs/edit.html.twig', [
            'user' => $user,
            'client' => $client,
            'userForm' => $userForm,
            'clientForm' => $clientForm,
            var_dump("<pre>"),
            
            var_dump("</pre>"),

            var_dump($client),
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
