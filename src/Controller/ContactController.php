<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact/Formulaire', name: 'app_contact_log')]
    public function contactAcces(): Response
    {

        return $this->render('contact/contact_log.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function ContactRedirection(): Response
    {

        return $this->render('contact/contact.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}
