<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $em, ProductRepository $productRepository): Response
    {

        $products = $productRepository->findByIsBest(1); 

       
 
        return $this->render('home/index.html.twig', [
            'products' => $products
            
        ]);
    }
}
