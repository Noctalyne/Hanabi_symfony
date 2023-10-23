<?php

namespace App\Controller;

use App\Entity\Adresses;
use App\Form\AdressesType;
use App\Repository\AdressesRepository;
use App\Repository\ClientsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/adresses')]
class AdressesController extends AbstractController
{

    // Route pour le client 
    #[Route('/{idClient}/mesAdresses/', name: 'app_mes_adresses_index', methods: ['GET'])]
    public function afficherAdressesClient(int $idClient, AdressesRepository $adressesRepository, ClientsRepository $clientsRepository): Response
    {
        // $client = $clientsRepository->findClientWithId($idClient);

        $clientId = $adressesRepository->findAdresseByClient($idClient);
        $addr = $adressesRepository->findAdresseByClient($idClient);

        $cli = $clientsRepository->findClient($idClient);

        // $cli ->getAdresses();
        // $userr = $cli->getUser();
        // $adresse = $cli->getAdresses();

        // echo "<pre>",
        // var_dump($adresse);
        // echo"</pre>";
        return $this->render('adresses/index.html.twig', [
            // 'adresses' => $adressesRepository->findAdresseByClient($idClient) // permet de retrouver le client par l
            // 'client' =>$client,
            // 'adresses' => $adresse,
            'client' => $cli,

        ]);
    }



//{idClient}/adresses/{id}

#[Route('{idClient}/adresses/new', name: 'app_mes_adresses_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, int $idClient, UserRepository $userRepository , ClientsRepository $clientsRepository): Response
{
    $adress = new Adresses();
    $form = $this->createForm(AdressesType::class, $adress);
    $form->handleRequest($request);

    $cli = $clientsRepository->findClient($idClient);
    // $email = $cli ->getEmail();

    // $client = $entityManager->getRepository('App\Entity\Clients') ->findOneBy(['user_id'=> $idClient]);
    
    // $client = $entityManager->getRepository('App\Entity\Clients')->find($idClient);
    // $adresseClientId = $cli->getId();

    // var_dump("<pre>", $adresseClientId, "</pre>");
    // var_dump("<pre>", $client, "</pre>");

    // $user = $userRepository->findClient($idClient);
    // $user = $cli->getUser();
    
    // var_dump("<pre>", $user, "</pre>");

    if ($form->isSubmitted() && $form->isValid()) {
        
        // $user->setEmail($email);
    

        // $adress->getIdClient();
        // $cli->addAdress($adress);
        
        // $entityManager->persist($cli);
        $entityManager->persist($adress);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_adresses_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('adresses/new.html.twig', [
        'adress' => $adress,
        'form' => $form,
        'idClient' =>$idClient,
    ]);
}





    // Route pour l'admin
    #[Route('/listeAdresses', name: 'app_adresses_index', methods: ['GET'])]
    public function index(AdressesRepository $adressesRepository): Response
    {
        return $this->render('adresses/index.html.twig', [
            'adresses' => $adressesRepository->findAll(),
        ]);
    }

    // #[Route('/adresses/new', name: 'app_adresses_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $adress = new Adresses();
    //     $form = $this->createForm(AdressesType::class, $adress);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($adress);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_adresses_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('adresses/new.html.twig', [
    //         'adress' => $adress,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/adresses/{id}', name: 'app_adresses_show', methods: ['GET'])]
    public function show(Adresses $adress): Response
    {
        return $this->render('adresses/show.html.twig', [
            'adress' => $adress,
        ]);
    }

    #[Route('/adresses/{id}/edit', name: 'app_adresses_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Adresses $adress, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdressesType::class, $adress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_adresses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('adresses/edit.html.twig', [
            'adress' => $adress,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_adresses_delete', methods: ['POST'])]
    public function delete(Request $request, Adresses $adress, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adress->getId(), $request->request->get('_token'))) {
            $entityManager->remove($adress);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_adresses_index', [], Response::HTTP_SEE_OTHER);
    }
}
