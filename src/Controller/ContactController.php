<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {

        $form = $this->createForm(ContactType::class); 
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid())
        {
            $email = $form->get('email')->getData();
            $objet = $form->get('objet')->getData();
            $message = $form->get('message')->getData();

            $contactEmail = (new TemplatedEmail())
                            ->from($email)
                            ->to('contact@bastienpetit.fr')
                            ->subject($objet)
                            ->htmlTemplate('email/contact.html.twig')
                            ->context([
                                'email_contact' => $email,
                                'objet' => $objet, 
                                'message' => $message
                            ]); 

            $mailer->send($contactEmail); 

            $this->addFlash('success', 'Votre message a bien été envoyé à la famille Greenclothe'); 

            return $this->redirectToRoute("contact"); 
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
