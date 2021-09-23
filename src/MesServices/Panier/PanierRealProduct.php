<?php 

namespace App\MesServices\Panier;

class PanierRealProduct
{
    public $product;

    public $qty;

    public function __construct($product, $qty)
    {
        $this->product = $product;
        $this->qty = $qty;
    }

    public function getTotal()
    {
        return $this->product->getPrice() * $this->qty;
    }
}