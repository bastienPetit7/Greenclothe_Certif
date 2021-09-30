<?php 

namespace App\Controller\Stripe\RouteDeRedirection;


use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use App\MesServices\Panier\PanierService;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\MesServices\Facture\CreerFactureService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/success/{stripeSessionId}", name="payment_success")
     */
    public function success(PanierService $panierService, $stripeSessionId)
    {
       
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if(!$order || $order->getUser() != $this->getUser())
        {
            return $this->redirectToRoute('home'); 
        } 

        if(!$order->getIsPaid())
        {
            // Modifier le statut isPaid en mettant 1
            $order->setIsPaid(1); 
            $this->entityManager->flush(); 

            //Envoyer un mail au client pour confirmer sa commande

        }

        

        // Afficher les quelques informations de la commande du user

        
        //Je voudrais vider le panier
        $panierService->viderPanier();

        //Je voudrais rediriger vers une page
        return $this->render('stripe_redirection/remerciement.html.twig', [
            'order' => $order
        ]);
    }
}