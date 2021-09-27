<?php 

namespace App\MesServices\Panier;

class PanierRealProduct
{
    public $product;

    public $qty;

    public $taille ;

    public function __construct($product, $qty, $taille = null)
    {
        $this->product = $product;
        $this->qty = $qty;
        $this->taille = $taille;
    }

    public function getTotal()
    {
        return $this->product->getPrice() * $this->qty;
    }
}