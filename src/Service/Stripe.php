<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderProduits;
use App\Entity\Produits;

class Stripe
{

    private $privateKey;

    public function __construct()
    {
        if($_ENV['APP_ENV'] === 'dev') {
            $this->privateKey = $_ENV['STRIPE_SECRET_KEY_TEST'];
        }
    }

    /**
     * @param Order $order
     * @return \Stripe\PaymentIntent
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function paymentIntent(Order $order)
    {
        \Stripe\Stripe::setApiKey($this->privateKey);

        return \Stripe\PaymentIntent::create([
            'amount' => $order->getPrice() * 100,
            'currency' => Order::DEVISE,
            'payment_method_types' => ['card']
        ]);
    }

    public function paiement($amount,$currency, $description, array $stripeParameter)
    {
        \Stripe\Stripe::setApiKey($this->privateKey);

        $payment_intent = null;

        if(isset( $stripeParameter['stripeIntentId'] )){
            $payment_intent = \Stripe\PaymentIntent::retrieve($stripeParameter['stripeIntentId']);
        }

        if ($stripeParameter['stripeIntentStatus'] === 'succeeded'){
            //TODO
        } else {
            $payment_intent->cancel();
        }

        return $payment_intent;
    }

    public function stripe(array $stripeParameter, Order $order, OrderProduits $orderProduits)
    {
        return $this->paiement(
            $order->getPrice() * 100,
            Order::DEVISE,
            $orderProduits->getQuantity() && $orderProduits->getProduits() && $orderProduits->getCommand(),
            $stripeParameter
        );
    }
}