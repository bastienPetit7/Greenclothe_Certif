<?php

namespace App\Controller\Account;

use App\Entity\Address;
use App\Form\AccountModifAddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{
    private $entityManager; 

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager; 
    }

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
     * @Route("/account/create/address", name="account_create_address")
     */
    public function create(Request $request): Response
    {
        $address = new Address; 

        $form = $this->createForm(AccountModifAddressType::class, $address); 
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid())
        {
            $address->setUser($this->getUser());
            $this->entityManager->persist($address); 
            $this->entityManager->flush(); 

            return $this->redirectToRoute('account_address'); 
           

        }


        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/account/edit/address/{id}", name="account_edit_address")
     */
    public function edit(Request $request, int $id): Response
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);  

        if(!$address || $address->getUser() != $this->getUser())
        {
            $this->redirectToRoute('account_address');
        }

        $form = $this->createForm(AccountModifAddressType::class, $address); 
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid())
        {
           
            $this->entityManager->flush(); 

            return $this->redirectToRoute('account_address'); 
           

        }


        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/account/delete/address/{id}", name="account_delete_address")
     */
    public function delete(int $id): Response
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);  

        if($address && $address->getUser() == $this->getUser())
        {
            $this->entityManager->remove($address);
            $this->entityManager->flush();
            
        }

        return $this->redirectToRoute('account_address'); 
       
    }
}
