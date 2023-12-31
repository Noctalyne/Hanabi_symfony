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

#[Route('/admin/formulaire/demande/produit')]
class FormulaireDemandeProduitController extends AbstractController
{
    // Liste de tous les formulaires
    #[Route('/listeFormulaire', name: 'app_formulaire_demande_produit_index', methods: ['GET'])]
    public function index(FormulaireDemandeProduitRepository $formulaireDemandeProduitRepository): Response
    {
        // $attenteReponse = 'attente';
        // $formulaireDemandeProduit->setReponseDemande($attenteReponse);
        return $this->render('formulaire_demande_produit/index.html.twig', [
            'formulaire_demande_produits' => $formulaireDemandeProduitRepository->findAll(),
        ]);
    }


    // Crud pour crée un nouveau formulaire
    #[Route('/new', name: 'app_formulaire_demande_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $formulaireDemandeProduit = new FormulaireDemandeProduit();
        $form = $this->createForm(FormulaireDemandeProduitType::class, $formulaireDemandeProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Permet d enregistrer la date et l heure de l envoie (format gmt a changer)
            $dateEnvoiForm = new \DateTime();
            $formulaireDemandeProduit->setDateEnvoieForm($dateEnvoiForm);

            // Définie la reponse du form en 'attente'
            $attenteReponse = 'attente';
            $formulaireDemandeProduit->setReponseDemande($attenteReponse);

            $entityManager->persist($formulaireDemandeProduit);
            $entityManager->flush();

            return $this->redirectToRoute('app_formulaire_demande_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formulaire_demande_produit/new.html.twig', [
            'formulaire_demande_produit' => $formulaireDemandeProduit,
            'form' => $form,
        ]);
    }

    //Crud pour afficher le formulaire celon l id de celui ci
    #[Route('/{id}', name: 'app_formulaire_demande_produit_show', methods: ['GET'])]
    public function show(FormulaireDemandeProduit $formulaireDemandeProduit): Response
    {
        return $this->render('formulaire_demande_produit/show.html.twig', [
            'formulaire_demande_produit' => $formulaireDemandeProduit,
        ]);
    }

    // Permet de donner une réponse à la demande
    #[Route('/traiter/Formulaire{id}', name: 'app_formulaire_demande_produit_traiter', methods: ['GET', 'POST'])]
    public function traiter(Request $request, FormulaireDemandeProduit $formulaireDemandeProduit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FormulaireDemandeProduitType::class, $formulaireDemandeProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrez la réponse du vendeur dans l'entité
            $dateReponseForm = new \DateTime();
            $formulaireDemandeProduit->setDateReponseForm($dateReponseForm);

            $entityManager->persist($formulaireDemandeProduit);
            $entityManager->flush();

            // Redirigez l'utilisateur vers une page de confirmation ou autre
            return $this->redirectToRoute('app_formulaire_demande_produit_index');
        }

        return $this->render('formulaire_demande_produit/traiter.html.twig', [
            'formulaire_demande_produit' => $formulaireDemandeProduit,
            'form' => $form,
        ]);
    }


    //Crud pour modifier le formulaire
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


    // Crud pour supprimer le formulaire --> VOIR SI PAS POSSIBLE DE LE "CACHER"
    #[Route('/{id}', name: 'app_formulaire_demande_produit_delete', methods: ['POST'])]
    public function delete(Request $request, FormulaireDemandeProduit $formulaireDemandeProduit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $formulaireDemandeProduit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($formulaireDemandeProduit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_formulaire_demande_produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
