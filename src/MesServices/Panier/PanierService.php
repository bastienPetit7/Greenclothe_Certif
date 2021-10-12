<?php

namespace App\MesServices\Panier;


use App\Repository\ProductRepository;
use App\MesServices\Panier\PanierItem;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService 

{

    protected $session;

    protected $productRepository; 

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session; 
        $this->productRepository = $productRepository; 
    }


    public function getPanier()
    {
        return $this->session->get('panier', []); 
    }

    public function sauvegarderPanier($panier)
    {
        return $this->session->set('panier', $panier);
    }

    public function viderPanier()
    {
        $this->sauvegarderPanier([]);
    }


    public function ajouter(int $id, $taille = null)
    {

        $panier = $this->getPanier(); 


        foreach($panier as $item)
        {
            if($item->getId() === $id && $item->getTaille() === $taille)
            {
                $item->setQty( $item->getQty() + 1); 
                
                $this->sauvegarderPanier($panier); 
                return; 

            }
            
        }

        
        $nouvelItem= new PanierItem();
        $nouvelItem->setId($id); 
        $nouvelItem->setTaille($taille);
        $nouvelItem->setQty(1);

        $panier[] = $nouvelItem; 
        $this->sauvegarderPanier($panier); 
        return;

    }

    public function detaillerLeContenu(): array
    {
        
        $contenu = [];

        
        $panier = $this->getPanier();

        
        foreach($panier as $item)
        {
            $product = $this->productRepository->find($item->getId());

            if(!$product)
            {
               continue; 
            }

     
            
            $qty = $item->getQty();

            $contenu[] = new PanierRealProduct($product,$qty, $item->getTaille());
        }
        
        return $contenu;
    }

    public function getTotal()
    {
        $total = 0;

        //Je vais chercher mon panier
        $panier = $this->getPanier();

        //Je boucle sur mon panier et ce qu il contient.
        foreach($panier as $item)
        {
            $product = $this->productRepository->find($item->getId());

            if(!$product)
            {
               continue; 
            }

            $total += $product->getPrice() * $item->getQty();
        }

        return $total;
    }

    public function supprimer(int $id, $taille) 
    {
        
        $panier = $this->getPanier();

        
        foreach($panier as $item)
        {
            
            if($item->getId() === $id && $item->getTaille() === $taille)
            {
                $key = array_search($item,$panier);
                unset($panier[$key]);
                $this->sauvegarderPanier($panier);
                return;
            }
        }
    }

    public function diminuer(int $id, $taille = null)
    {
        //Je vais chercher un panier
        $panier = $this->getPanier();

        foreach($panier as $item)
        {
            if($item->getId() === $id && $item->getTaille() === $taille)
            {
                $quantite = $item->getQty();

                if($quantite === 1)
                {
                    $this->supprimer($id, $taille);
                    return;
                }
                else
                {
                    $item->setQty( $item->getQty() - 1);
                    $this->sauvegarderPanier($panier);
                    return;
                }
            
            }
        }
    }

}