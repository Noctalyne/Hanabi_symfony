<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\User;
use App\Form\ClientsType;
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
        var_dump($clientsRepository->findAllWithUser());
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
        // Permet de retrouver le client + LES INFOS celon l'id 
        // $utilisateur = $entityManager->getRepository(User::class)->find($idClient);
        // $utilisateur = $entityManager->getRepository(User::class)->find($idClient);


        $test = $clientsRepository->findClientWithId();

        return $this->render('profil_utilisateurs/show.html.twig', [
            // 'client' => $user,
            // 'client' => $utilisateur,
            // var_dump($utilisateur),
            'client' => $test,
            var_dump($clientsRepository->findClientWithId()),
        ]);
    }

    #[Route('/{idClient}/edit', name: 'app_profil_utilisateurs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Clients $client, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientsType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_profil_utilisateurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profil_utilisateurs/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{idClient}', name: 'app_profil_utilisateurs_delete', methods: ['POST'])]
    public function delete(Request $request, Clients $client, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $client->getId(), $request->request->get('_token'))) {
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_profil_utilisateurs_index', [], Response::HTTP_SEE_OTHER);
    }
}
