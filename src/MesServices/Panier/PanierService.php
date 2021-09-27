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
        //Je cree un tableau vide que je vais remplir et renvoyer 
        $contenu = [];

        //Je vais chercher mon panier
        $panier = $this->getPanier();

        //Je boucle sur mon panier et ce qu il contient.
        foreach($panier as $item)
        {
            //Chaque item du panier a un Id et une Qty
            //Grace a l id , je peux recuperer le produit lié à l'id
            $product = $this->productRepository->find($item->getId());

            if(!$product)
            {
               continue; 
            }

            //Je vais chercher la quantité de l item
            $qty = $item->getQty();

            //J ajoute le produit que j ai trouve en bdd et sa quantite dans une nouvelle classe
            //Une classe qui va vraiment representer le produit reel
            //J ajoute cet instance de la classe de Produit Reel dans le tableau à retourner
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

    public function supprimer(int $id, $taille = null) 
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