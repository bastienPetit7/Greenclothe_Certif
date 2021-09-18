<?php

namespace App\Controller;

use App\Form\AccountModifInfoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountModifInfoController extends AbstractController
{
    /**
     * @Route("/account/modif/info", name="account_modif_info")
     */
    public function index(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
    {
        
        $user = $this->getUser(); 
        $form= $this->createForm(AccountModifInfoType::class, $user); 

        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid())
        {
            $old_pwd = $form->get('old_password')->getData(); 

            if($encoder->isPasswordValid($user, $old_pwd))
            {
                $new_pwd = $form->get('new_password')->getData(); 
                $password = $encoder->encodePassword($user, $new_pwd); 

                $user->setPassword($password); 
                $em->persist($user); 
                $em->flush();
            }

            // $em->flush(); 

            return $this->redirectToRoute('account_modif_info');
        }

        return $this->render('account/modif_info.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
