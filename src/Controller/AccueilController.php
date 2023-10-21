<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(ProduitsRepository $produitsRepository): Response
    {
        $produit=$produitsRepository->findAll(); // permet de récupérer les info produits

        // if (extension_loaded('fileinfo')) {
        //     echo "fileinfo extension is enabled.";
        // } else {
        //     echo "fileinfo extension is not enabled.";
        // }
        
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'produits' => $produit,
        ]);
    }

    #[Route('/accueil', name: 'app_accueil_2')]
    public function indexConnect(ProduitsRepository $produitsRepository): Response
    {
        $produit=$produitsRepository->findAll(); // permet de récupérer les info produits

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'produits' => $produit,
        ]);
    }


}
