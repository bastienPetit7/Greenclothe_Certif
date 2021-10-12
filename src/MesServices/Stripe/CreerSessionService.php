<?php 

namespace App\MesServices\Stripe;

use App\MesServices\Panier\PanierService;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\Security\Core\Security;

class CreerSessionService 
{
    protected $keySecret;

    protected $panierService;

    protected $security;

    protected $entityManager;

    public function __construct($keySecret, PanierService $panierService, Security $security, EntityManagerInterface $entityManager)
    {
        $this->keySecret = $keySecret;
        $this->panierService = $panierService;
        $this->security = $security;
        $this->entityManager = $entityManager; 
    }

    public function getDomain()
    {
        return 'https://localhost:8000';
    }

    public function getItems($order)
    {
        $produits_stripe = [];

        $products = $this->panierService->detaillerLeContenu();
        
      

        foreach( $products as $item)
        {
            $produits_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $item->product->getPrice(),
                    'product_data' => [
                        'name' => $item->product->getName()
                    ]
                ],
                'quantity' => $item->qty
            ];
        }
        // Product for stripe ===> Carrier infos
            $produits_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $order->getCarrierPrice(),
                    'product_data' => [
                        'name' => $order->getCarrierName()
                    ]
                ],
                'quantity' => 1
            ];

        
        return $produits_stripe;
    }

    public function create($order)
    {
        Stripe::setApiKey($this->keySecret);

        $checkout_session = Session::create([
            'customer_email' => $this->security->getUser()->getEmail(),
            'line_items' => [
                $this->getItems($order)
            ],
            'payment_method_types' => [
              'card',
            ],
            'mode' => 'payment',
            'success_url' => $this->getDomain() . '/success/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $this->getDomain() . '/cancel/{CHECKOUT_SESSION_ID}',
          ]);

          
          $order->setStripeSessionId($checkout_session->id); 
          $this->entityManager->flush(); 

           

        return $checkout_session; 
    }
}