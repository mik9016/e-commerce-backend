<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Stripe;


class CheckoutController extends Controller
{
    private $cartPrices = [];

    private function findPrice($id)
    {
        $item = Item::findOrFail($id);
        return $item;
    }

    private function calculatePrices()
    {
        return array_sum($this->cartPrices);
    }
    //check price in DB after id
    //add to array
    //calculate total price
    //return totalprice to stripe object
    public function checkout(Request $request)
    {
        $cartItems = $request['cartItems'];


        foreach ($cartItems as $value) {

            $itemDB = $this->findPrice($value['id']);
            $price = $itemDB['price'] * $value['quantity'];
            array_push($this->cartPrices, $price);
        }
        $totalPrice = $this->calculatePrices();


        $stripe = Stripe::make(env('STRIPE_API_KEY'));

        $checkout = $stripe->checkout()->sessions()->create([
            'success_url' => 'http://localhost:3000/checkout/success',
            'cancel_url' => 'http://localhost:3000/checkout/cancel',
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'unit_amount' => $totalPrice * 100,
                        'product_data' => [
                            'name' => 'Uni Shop Checkout'
                        ]
                    ],
                    'quantity' => 1,
                ],
            ],
            "payment_method_types" => [
                "card",
                "klarna",
                "p24",
            ],
            'mode' => 'payment',
        ]);

        return $checkout;
    }
}
