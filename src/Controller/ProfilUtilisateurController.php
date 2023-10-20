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
        // #[MapEntity(id: 'idClient')]
        // #[MapEntity]

        Request $request,
        EntityManagerInterface $entityManager,
        ClientsRepository $clientsRepository,
        Clients $clients,
        User $users,
        UserRepository $userRepository
    ): Response {

        $clientForm = $this->createForm(ClientsType::class, $clients);
        $clientForm->handleRequest($request);

        $userForm = $this->createForm(UserType::class, $users);
        $userForm->handleRequest($request);

        $client = $clientsRepository->findClient($idClient);
        $user = $userRepository->findUser($idClient);

        if ($userForm->isSubmitted() && $userForm->isValid() && $clientForm->isSubmitted() && $clientForm->isValid()) {


            foreach ($user as $cle => $valeur) {
                $verifForm = $userForm->get($cle)->getData();
                if ($valeur!== $verifForm) {
                    $user.$cle = $verifForm;
                }
            }


            foreach ($client as $cle => $valeur) {
                $verif = $valeur;
                $verifFormUser = $userForm->get($cle)->getData();
                if ($verif !== $verifFormUser) {
                    $client.$cle = $verifFormUser;
                }
            }

            // $entityManager->persist($client);
            
            

            // $user->setEmail($userForm->get('email')->getData() );
            // $client->setUser($user);

            // $client->setEmail($userForm->get('email')->getData() );
            // var_dump("<pre>", $user, "</pre>");
            // var_dump("<pre>", $client, "</pre>");

            
            $entityManager->persist($user);

            $entityManager->persist($client);

            $entityManager->flush();

            return $this->redirectToRoute('app_profil_utilisateurs_show', ['idClient' => $idClient], Response::HTTP_SEE_OTHER);
        }


        var_dump("<pre>", $user, "</pre>");
        var_dump("<pre>", $client, "</pre>");
        

        return $this->render('profil_utilisateurs/edit.html.twig', [
            'user' => $user,
            'client' => $client,
            'userForm' => $userForm,
            'clientForm' => $clientForm,

            // var_dump("<pre>"),
            // var_dump($client),
            // var_dump("</pre>"),            
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
