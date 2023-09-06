<?php

/**
 * @package D9SPL
 */

namespace Inc\Base;

class Stripe
{
    private $stripe;
    private $currency;


    function __construct()
    {
        // Initialize Stripe client
        \Stripe\Stripe::setApiKey(get_option('d9_settings_key'));

        $this->stripe = new \Stripe\StripeClient(get_option('d9_settings_key'));
        $this->currency = get_option('d9_settings_currency');
    }


    function create_product($name, $amount)
    {
        return $this->stripe->products->create([
            'name' => $name,
            'default_price_data' => [
                'unit_amount' => $amount,
                'currency' => $this->currency,
            ],
            'expand' => ['default_price'],
        ]);
    }

    function archive_product($id)
    {
        return $this->stripe->products->update($id, [
            'active' => false,
        ]);
    }


    function delete_product($id)
    {
        return $this->stripe->products->delete($id);
    }


    function create_payment_link($price_id, $quantity = 1)
    {
        return $this->stripe->paymentLinks->create([
            'line_items' => [
                [
                    'price' => $price_id,
                    'quantity' => $quantity,
                ],
            ],
        ]);
    }


    function get_payment_links($limit = 20, $pading = 0)
    {
        return $this->stripe->paymentLinks->allLineItems([
            'limit' => $limit,
            // 'starting_after' => $pading,
        ]);
    }

    function retrive_payment_link($id)
    {
        return $this->stripe->paymentLinks->retrieve($id);
    }
}
