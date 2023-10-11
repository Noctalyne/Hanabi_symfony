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
        $client = new Clients();
        $form = $this->createForm(RegistrationFormType::class, $user); //[ 'clients' => $client]
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Modifie email de user ET client
            $user->setEmail(
                $form->get('email')->getData()
            );
            $client->setEmail(
                $form->get('email')->getData()
            );


            //Modifie username de user ET client
            $user->setUsername(
                $form->get('username')->getData()
            );
            $client->setUsername(
                $form->get('username')->getData()
            );



            //Modifie username de user ET client + encode the plain password -> Encode le mot de passe
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData() /* ('user')*/
                )
            );
            $client->setPassword(
                $userPasswordHasher->hashPassword(
                    $client,
                    $form->get('plainPassword')->getData() /* ('user')*/
                )
            );

            // Enregistre l'entité user
            $entityManager->persist($user);            
            $entityManager->flush();// Enregistre les modifications dans la base de données

            $idClient = $user->getId();
            $client->setIdClient($idClient);

            //Enregistre l'entité Clients et pemet de s 'assure que l id de user = client
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
