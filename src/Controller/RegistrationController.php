<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        
        $user = new User();
        $client = new Clients(); //
        $form = $this->createForm(RegistrationFormType::class, $user, ); //[ 'clients' => $client]
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            // encode the plain password -> Encode le mot de passe
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData() /* ('user')*/
                )
            );
            

            // Associez User et Clients
            $user->setClient($client);
            $client->setUser($user);

            // Enregistrez l'entité Clients et user
            $entityManager->persist($client);
            $entityManager->persist($user);

            // Enregistrez les modifications dans la base de données
            $entityManager->flush();


            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
