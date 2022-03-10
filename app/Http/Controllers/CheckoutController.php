<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Stripe;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $stripe = Stripe::make(env('STRIPE_API_KEY'));        
        // Log::info($request);
        $checkout = $stripe->checkout()->sessions()->create([
            'success_url' => 'http://localhost:3000/checkout/success',
            'cancel_url' => 'http://localhost:3000/checkout/cancel',
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'unit_amount' => 500,
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
