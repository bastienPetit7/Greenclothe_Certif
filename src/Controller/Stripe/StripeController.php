<?php 

namespace App\Controller\Stripe;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\MesServices\Stripe\CreerSessionService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    /**
     * @Route("/stripe/creer/session/{reference}", name="stripe_checkout")
     */
    public function createSession(CreerSessionService $creerSessionService, EntityManagerInterface $em, $reference)
    {
        $order = $em->getRepository(Order::class)->findOneByReference($reference); 

        if(!$order) 
        {
            $this->redirectToRoute('order'); 
        }

        $sessionStripe = $creerSessionService->create($order);
 

        return $this->redirect($sessionStripe->url);
    }
}