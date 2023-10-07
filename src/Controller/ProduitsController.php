<?php

namespace App\Controller;
use App\Entity\Produits;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitsController extends AbstractController
{
    #[Route('/produits', name: 'app_produits')]
    public function index(): Response
    {
        return $this->render('produits/index.html.twig', [
            'controller_name' => 'ProduitsController',
        ]);
    }

    // #[Route('/produits/listeProduits', name: 'app_listeProduits')]
    // public function generateListe(ProduitsRepository $produitsRepository) : Response
    // {
    //     $liste_produits = $produitsRepository->findAll();


    //     return $this->render('./produits/produits.html.twig', [
    //         'liste_produits' => $liste_produits
    //     ]);
    // }
}
