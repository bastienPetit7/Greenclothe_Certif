<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspaceUtilisateurController extends AbstractController
{
    /**
     * @Route("/espace/utilisateur", name="espace_utilisateur")
     */
    public function index(): Response
    {
        return $this->render('espace_utilisateur/index.html.twig', [
            'controller_name' => 'EspaceUtilisateurController',
        ]);
    }
}
