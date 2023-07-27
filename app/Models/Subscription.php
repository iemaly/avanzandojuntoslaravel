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
        $uniqueCode = uniqid();
        $data['uniqueCode'] = $uniqueCode;
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
            'quantity' => 1,
        ]],
        'metadata' => [
            // 'order_id' => $data['order_id'],
        ],
        'customer_email'=>'hnhtechsolutions@gmail.com',
        'mode' => 'payment',
        'success_url' => route('professional.store', ['data'=>$data]),
        'cancel_url' => route('subscriptions.delete'),
        ]);
        Subscription::create(['creatable_type'=>'App\Models\Professional', 'plan_id'=>$data['plan_id'], 'code'=>$uniqueCode, 'payment_id'=>$checkout_session->payment_intent]);
        return $checkout_session->url;
    }

    function stripePayUser($data)
    {
        $uniqueCode = uniqid();
        $data['uniqueCode'] = $uniqueCode;
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
            'quantity' => 1,
        ]],
        'metadata' => [
            // 'order_id' => $data['order_id'],
        ],
        'customer_email'=>'hnhtechsolutions@gmail.com',
        'mode' => 'payment',
        'success_url' => route('subscriptions.user.afterpay', ['user_id'=>$data['user_id'], 'code'=>$uniqueCode]),
        'cancel_url' => route('subscriptions.delete'),
        ]);
        Subscription::create(['creatable_type'=>'App\Models\User', 'plan_id'=>$data['plan_id'], 'code'=>$uniqueCode, 'payment_id'=>$checkout_session->payment_intent]);
        return $checkout_session->url;
    }

    function stripePayCarehome($data)
    {
        $uniqueCode = uniqid();
        $data['uniqueCode'] = $uniqueCode;
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
            'quantity' => 1,
        ]],
        'metadata' => [
            // 'order_id' => $data['order_id'],
        ],
        'customer_email'=>'hnhtechsolutions@gmail.com',
        'mode' => 'payment',
        'success_url' => route('carehome.storeByGet', ['data'=>$data]),
        'cancel_url' => route('subscriptions.delete'),
        ]);
        Subscription::create(['creatable_type'=>'App\Models\Carehome', 'plan_id'=>$data['plan_id'], 'code'=>$uniqueCode, 'payment_id'=>$checkout_session->payment_intent]);
        return $checkout_session->url;
    }

    function stripePayBusiness($data)
    {
        $uniqueCode = uniqid();
        $data['uniqueCode'] = $uniqueCode;
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
            'quantity' => 1,
        ]],
        'metadata' => [
            // 'order_id' => $data['order_id'],
        ],
        'customer_email'=>'hnhtechsolutions@gmail.com',
        'mode' => 'payment',
        'success_url' => route('business.storeByGet', ['data'=>$data]),
        'cancel_url' => route('subscriptions.delete'),
        ]);
        Subscription::create(['creatable_type'=>'App\Models\Business', 'plan_id'=>$data['plan_id'], 'code'=>$uniqueCode, 'payment_id'=>$checkout_session->payment_intent]);
        return $checkout_session->url;
    }

    function amount($data)
    {
        $amount = Plan::find($data['plan_id'])->price;
        if (!empty($data['coupon'])) 
        {
            $plan = Plan::where(['id'=>$data['plan_id'],'coupon'=>$data['coupon']])->first();
            if($plan!=null) 
            {
                $discountedAmount = $plan->price * ($plan->coupon_discount/100);
                return $amount = $plan->price - $discountedAmount;
            }
            return $amount;
        }
        return $amount;
    }

    function store($data)
    {
        $subscription = Subscription::where(['creatable_type'=>'App\Models\Professional', 'creatable_id'=>$data['data']['professional_id']])->first();
        if($subscription!=null) return ['status'=>false, 'error'=>'Subscription already exists'];
        Subscription::where('code', $data['data']['uniqueCode'])->update(['creatable_type'=>'App\Models\Professional', 'creatable_id'=>$data['data']['professional_id'], 'code'=>'']);
        return ['status'=>true];
    }

    function afteryPayUser($data)
    {
        $subscription = Subscription::where(['creatable_type'=>'App\Models\User', 'creatable_id'=>$data['user_id']])->first();
        if($subscription!=null) return ['status'=>false, 'error'=>'Subscription already exists'];
        Subscription::where('code', $data['code'])->update(['creatable_type'=>'App\Models\User', 'creatable_id'=>$data['user_id'], 'code'=>'']);
        return ['status'=>true];
    }

    function afterPayCarehome($data)
    {
        $subscription = Subscription::where(['creatable_type'=>'App\Models\Carehome', 'creatable_id'=>$data['data']['carehome']])->first();
        if($subscription!=null) return ['status'=>false, 'error'=>'Subscription already exists'];
        Subscription::where('code', $data['data']['uniqueCode'])->update(['creatable_type'=>'App\Models\Carehome', 'creatable_id'=>$data['data']['carehome'], 'code'=>'']);
        return ['status'=>true];
    }

    function afterPayBusiness($data)
    {
        $subscription = Subscription::where(['creatable_type'=>'App\Models\Business', 'creatable_id'=>$data['data']['business_id']])->first();
        if($subscription!=null) return ['status'=>false, 'error'=>'Subscription already exists'];
        Subscription::where('code', $data['data']['uniqueCode'])->update(['creatable_type'=>'App\Models\Business', 'creatable_id'=>$data['data']['business_id'], 'code'=>'']);
        return ['status'=>true];
    }
}
