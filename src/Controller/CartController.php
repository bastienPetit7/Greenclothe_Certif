<?php

namespace App\Controller;


use App\Repository\ProductRepository;
use App\Form\AjouterTailleProduitType;
use App\Repository\CategoryRepository;
use App\MesServices\Panier\PanierService;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("panier/ajouter/{id}/{taille?null}", name="ajouter_panier")
     */
    public function ajouter(int $id,  $taille, ProductRepository $productRepository, CategoryRepository $categoryRepository, Request $request)
    {
        $product = $productRepository->find($id); 

        if(!$product)
        {
            throw $this->createNotFoundException("Le produit n'existe plus. ");
        }

        $this->panierService->ajouter($id, $taille); 

        $routeARediriger = $request->query->get('redirige');

        if($routeARediriger)
        {
            return $this->redirectToRoute('panier_detail');
        }

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
    public function voirMonPanier(Request $request)
    {
        $form= $this->createForm(AjouterTailleProduitType::class); 
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid())
        {
            
        }
        
        return $this->render("panier/detail_panier.html.twig",[
            'panier' => $this->panierService->detaillerLeContenu() ,
            'total' => $this->panierService->getTotal(), 
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/panier/supprimer/{id}/{taille?null}", name="panier_supprimer_article")
     */
    public function supprimerArticle( int $id, $taille)
    {
        $this->panierService->supprimer($id, $taille);

        return $this->redirectToRoute('panier_detail');
    }

    /**
     *  @Route("/panier/diminuer/{id}/{taille?null}", name="panier_diminuer_article")
     */
    public function diminuerArticle( int $id, $taille)
    {
        $this->panierService->diminuer($id, $taille);

        return $this->redirectToRoute('panier_detail');
    }
}