<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    // QUERIES
    
    function stripePay($data)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $checkout_session = $stripe->checkout->sessions->create([
        'line_items' => [[
            'price_data' => [
            'currency' => 'usd',
            'product_data' => [
                'name' => 'Avanzandos Juntos',
            ],
            'unit_amount' => $this->amount($data)*100,
            ],
            'quantity' => $data['total_quantity'],
            // 'quantity' => 1,
        ]],
        'metadata' => [
            'order_id' => $data['order_id'],
        ],
        'customer_email'=>$data['user_email'],
        'mode' => 'payment',
        'success_url' => route('users.orders.update_status', ['code'=>$data['code']]),
        'cancel_url' => 'https://daraz.dev-bt.xyz',
        ]);
        Order::find($data['order_id'])->update(['payment_id'=>$checkout_session->payment_intent]);
        return $checkout_session->url;
    }

    function amount($data)
    {
        return 10;
    }
}
