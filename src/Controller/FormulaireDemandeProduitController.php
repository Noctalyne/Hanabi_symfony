<?php

namespace App\Controller;

use App\Entity\FormulaireDemandeProduit;
use App\Form\FormulaireDemandeProduitType;
use App\Repository\FormulaireDemandeProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/formulaire/demande/produit')]
class FormulaireDemandeProduitController extends AbstractController
{
    #[Route('/', name: 'app_formulaire_demande_produit_index', methods: ['GET'])]
    public function index(FormulaireDemandeProduitRepository $formulaireDemandeProduitRepository): Response
    {
        return $this->render('formulaire_demande_produit/index.html.twig', [
            'formulaire_demande_produits' => $formulaireDemandeProduitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_formulaire_demande_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $formulaireDemandeProduit = new FormulaireDemandeProduit();
        $form = $this->createForm(FormulaireDemandeProduitType::class, $formulaireDemandeProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($formulaireDemandeProduit);
            $entityManager->flush();

            return $this->redirectToRoute('app_formulaire_demande_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formulaire_demande_produit/new.html.twig', [
            'formulaire_demande_produit' => $formulaireDemandeProduit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formulaire_demande_produit_show', methods: ['GET'])]
    public function show(FormulaireDemandeProduit $formulaireDemandeProduit): Response
    {
        return $this->render('formulaire_demande_produit/show.html.twig', [
            'formulaire_demande_produit' => $formulaireDemandeProduit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_formulaire_demande_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FormulaireDemandeProduit $formulaireDemandeProduit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FormulaireDemandeProduitType::class, $formulaireDemandeProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_formulaire_demande_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formulaire_demande_produit/edit.html.twig', [
            'formulaire_demande_produit' => $formulaireDemandeProduit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formulaire_demande_produit_delete', methods: ['POST'])]
    public function delete(Request $request, FormulaireDemandeProduit $formulaireDemandeProduit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formulaireDemandeProduit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($formulaireDemandeProduit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_formulaire_demande_produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
