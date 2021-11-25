<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CGVController extends AbstractController
{
    /**
     * @Route("/conditions-generals-de-vente", name="cgv_conditions")
     */
    public function index(): Response
    {
        return $this->render('cgv/index.html.twig', [
            'controller_name' => 'CGUController',
        ]);
    }
}
