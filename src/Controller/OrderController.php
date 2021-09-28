<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use App\MesServices\Panier\PanierService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends AbstractController
{
    private $entityManager; 

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager; 
    }


    /**
     * @Route("/order", name="order")
     */
    public function index(PanierService $panierService): Response
    {

        if(!$this->getUser()->getAddresses()->getValues())
        {
            return $this->redirectToRoute('account_create_address');
        }

        // Je lui passe un tableau d'option en troisième arguments afin de pouvoir récupérer mon utilisateur via le formulaire.
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]); 

       

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(), 
            'cart'=> $panierService->detaillerLeContenu()
        ]);
    }

     /**
     * @Route("/order/recap", name="order_recap", methods={"POST"})
     */
    public function add(PanierService $panierService, Request $request): Response
    {

        if(!$this->getUser()->getAddresses()->getValues())
        {
            return $this->redirectToRoute('account_create_address');
        }

        // Je lui passe un tableau d'option en troisième arguments afin de pouvoir récupérer mon utilisateur via le formulaire.
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]); 

        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid())
        {
            $date = new DateTime();
            $carrier = $form->get('carrier')->getData(); 
            $delivery = $form->get('addresses')->getData();
           
            
            // Création de chaine de charactères avec toutes les infos necessaire a stocker deans order->setDelivery(); 
            $delivery_content = $delivery->getFirstname().' '.$delivery->getLastname();
            $delivery_content .= '<br/>'. $delivery->getPhone();
 

            if($delivery->getCompany())
            {
                $delivery_content .= '<br/>'. $delivery->getCompany();
            }
            
            $delivery_content .= '<br/>'. $delivery->getAddress();
            $delivery_content .= '<br/>'. $delivery->getPostal().' '.$delivery->getCity() ;
            $delivery_content .= '<br/>'. $delivery->getCountry();
            
           //Enregistrer ma commande => Order 
           $order = new Order; 
           $order->setUser($this->getUser()); 
           $order->setCreatedAt($date); 
           $order->setCarrierName($carrier->getName());
           $order->setCarrierPrice($carrier->getPrice()); 
           $order->setDelivery($delivery_content); 
           $order->setIsPaid(0); 

           $this->entityManager->persist($order); 

            // Enregistrer mes produits => OrderDetails
           foreach($panierService->detaillerLeContenu() as $product)
           {
               $orderDetails = new OrderDetails; 
               $orderDetails->setMyOrder($order);
               $orderDetails->setProduct($product->product->getName()); 
               $orderDetails->setQuantity($product->qty); 
               $orderDetails->setPrice($product->product->getPrice()); 
               $orderDetails->setTotal($product->product->getPrice() * $product->qty); 
               
               $this->entityManager->persist($orderDetails); 
              
           }

        //    $this->entityManager->flush(); 

            return $this->render('order/add.html.twig', [ 
                'cart'=> $panierService->detaillerLeContenu(), 
                'total' => $panierService->getTotal(),
                'carrier' => $carrier, 
                'address' => $delivery_content
            ]);
        }

        return $this->redirectToRoute('panier_detail'); 
        
    }
}
