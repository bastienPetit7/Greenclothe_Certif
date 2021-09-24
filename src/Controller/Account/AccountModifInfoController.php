<?php

namespace App\Controller\Account;

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
    public function index(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $notification = null; 

        $user = $this->getUser(); 
        
        $form= $this->createForm(AccountModifInfoType::class, $user); 

        $form->handleRequest($request); 
       
        if($form->isSubmitted() && $form->isValid())
        {
            $old_pwd = $form->get('old_password')->getData();

            
                if($passwordEncoder->isPasswordValid($user, $old_pwd))
                {
                    $new_pwd = $form->get('new_password')->getData(); 

                    if(!empty($new_pwd))
                    {
                       $password = $passwordEncoder->encodePassword($user, $new_pwd); 

                       $user->setPassword($password);
                       $em->persist($user); 
                       $em->flush(); 

                       $notification = 'Votre mot de passe a bien été modifié. Vos informations ont été mise à jour.';

                    //    return $this->redirectToRoute('account_modif_info');

                    }else {

                        $em->flush(); 
                        
                        $notification = 'Vos informations ont bien été modifié';

                        // return $this->redirectToRoute('account_modif_info');

                    }


                } else { 
                    $notification = 'Votre mot de passe actuel est incorrect, veuillez re-saisire votre mot de passe';
                }
           

                

           

           

            
        }

        return $this->render('account/modif_info.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
