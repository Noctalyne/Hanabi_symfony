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
// use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


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

    #[Route('/new', name: 'app_profil_utilisateurs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $client = new Clients();
        $form = $this->createForm(ClientsType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_profil_utilisateurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profil_utilisateurs/new.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{idClient}', name: 'app_profil_utilisateurs_show', methods: ['GET'])]
    public function show(EntityManagerInterface $entityManager, int $idClient, ClientsRepository $clientsRepository): Response
    {
        // Permet de retrouver le client + LES INFOS celon l'id  de l'url 
        $user = $clientsRepository->findClientWithId($idClient);

        // echo "<pre>",
        // var_dump($test);
        // echo"</pre>";
        return $this->render('profil_utilisateurs/show.html.twig', [
            'client' => $user,
            // var_dump($clientsRepository->findClientWithId()),
        ]);
    }

    #[Route('/{idClient}/edit', name: 'app_profil_utilisateurs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Clients $client, EntityManagerInterface $entityManager,
     int $idClient, ClientsRepository $clientsRepository, User $user
     ): Response
    {


        $clientForm = $this->createForm(ClientsType::class, $client);
        $clientForm->handleRequest($request);

        $userForm=$this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        // $client = $clientsRepository->findClientWithId($idClient);
        // $client = $client[0]; // --> permet à la variable de rentrer dans le tableau 

        $user = $clientsRepository->findClientWithId($idClient);
        $user = $user[0];

        echo "<pre>",
        var_dump($user);
        echo"</pre>";
        
        // echo "<pre>",
        // var_dump($client);
        // echo"</pre>";
        if ($clientForm->isSubmitted() && $clientForm->isValid() && $userForm->isSubmitted() && $userForm->isValid() )  {
            // $entityManager->persist($client[0]);
            // $entityManager->persist($client[0]);
            $entityManager->persist($user[0]);
            $entityManager->flush();

            return $this->redirectToRoute('app_profil_utilisateurs_show', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('profil_utilisateurs/edit.html.twig', [
            'client' => $client,
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
