<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class CartService
{
    protected $cartKey = 'shopping_cart';

    public function add($productId, $productName, $price, $quantity = 1, $options = [])
    {
        $cart = Session::get($this->cartKey, []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $productName,
                'price' => $price,
                'quantity' => $quantity,
                'options' => $options
            ];
        }

        Session::put($this->cartKey, $cart);
    }

    public function remove($productId)
    {
        $cart = Session::get($this->cartKey, []);
        unset($cart[$productId]);
        Session::put($this->cartKey, $cart);
    }

    public function getContent()
    {
        return Session::get($this->cartKey, []);
    }

    public function total()
    {
        return array_reduce($this->getContent(), function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public function clear()
    {
        Session::forget($this->cartKey);
    }
}