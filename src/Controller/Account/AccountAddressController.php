<?php

namespace App\Controller\Account;

use App\Entity\Address;
use App\Form\AccountModifAddressType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{
    /**
     * @Route("/account/address", name="account_address")
     */
    public function index(): Response
    {
        return $this->render('account/account_address.html.twig', [
            'controller_name' => 'AccountAddressController',
        ]);
    }

    /**
     * @Route("/account/modif/address", name="account_modif_address")
     */
    public function create(Request $request): Response
    {
        $address = new Address; 

        $form = $this->createForm(AccountModifAddressType::class, $address); 
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid())
        {
            

        }


        return $this->render('account/modif_address.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
