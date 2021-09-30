<?php 

namespace App\Controller\Stripe\RouteDeRedirection;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CancelController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/cancel/{stripeSessionId}", name="payment_cancel")
     */
    public function cancel($stripeSessionId)
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if(!$order || $order->getUser() != $this->getUser())
        {
            return $this->redirectToRoute('home'); 
        } 

        // Envoyer un mail à notre utilisateur pour lui indiquer l'echec de paiement
        
        return $this->render('stripe_redirection/erreur.html.twig', [
            'order' => $order
        ]);
    }
}