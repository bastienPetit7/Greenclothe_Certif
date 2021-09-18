<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountModifAddressController extends AbstractController
{
    /**
     * @Route("/account/modif/address", name="account_modif_address")
     */
    public function index(): Response
    {
        return $this->render('account/modif_address.html.twig');
    }
}
