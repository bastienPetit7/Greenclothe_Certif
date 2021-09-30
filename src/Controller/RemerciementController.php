<?php 

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RemerciementController extends AbstractController
{
    /**
     * @Route("/remerciement", name="remerciement")
     */
    public function thanks()
    {
        return $this->render("remerciement/remerciement.html.twig");
    }
}