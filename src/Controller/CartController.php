<?php

namespace App\Controller;


use App\Repository\ProductRepository;
use App\MesServices\Panier\PanierService;
use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    protected $panierService;

    public function __construct(PanierService $panierService)
    {
        $this->panierService = $panierService; 
    }


    /**
     * @Route("panier/ajouter/{id}", name="ajouter_panier")
     */
    public function ajouter(int $id, ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $product = $productRepository->find($id); 

        if(!$product)
        {
            throw $this->createNotFoundException("Le produit n'existe plus. ");
        }

        $this->panierService->ajouter($id); 

        $getId = $productRepository->findCategoryId($id);
        
        $categoryId = $getId[1]["category_id"];
         
        $this->addFlash('success', 'Le produit a bien été ajouté à votre panier');

        return $this->redirectToRoute('category_show',[
            'id' => $categoryId
        ]);

    }


    /**
     * @Route("/panier/detail", name="panier_detail")
     */
    public function voirMonPanier()
    {
        return $this->render("panier/detail_panier.html.twig",[
            'panier' => $this->panierService->detaillerLeContenu() ,
            'total' => $this->panierService->getTotal()
        ]);
    }

    /**
     * @Route("/panier/supprimer/{id}", name="panier_supprimer_article")
     */
    public function supprimerArticle( int $id)
    {
        $this->panierService->supprimer($id);

        return $this->redirectToRoute('panier_detail');
    }

    /**
     *  @Route("/panier/diminuer/{id}", name="panier_diminuer_article")
     */
    public function diminuerArticle( int $id)
    {
        $this->panierService->diminuer($id);

        return $this->redirectToRoute('panier_detail');
    }
}