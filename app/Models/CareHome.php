<?php

namespace App\Models;

use App\Imports\ImportCarehome;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class CareHome extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasFactory;

    // QUERIES
    public function import($sheet)
    {
        try {
            $excel = Excel::import(new ImportCarehome(), $sheet, null, \Maatwebsite\Excel\Excel::XLSX);
        } catch (\Throwable $th) {
            return ['status'=>false, 'error'=>$th->getMessage()];
        }
        return ['status'=>true];
    }

    function stripePayForFeature($request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $checkout_session = $stripe->checkout->sessions->create([
        'line_items' => [[
            'price_data' => [
            'currency' => 'usd',
            'product_data' => [
                'name' => 'Avanzandos Juntos',
            ],
            'unit_amount' => $this->amount($request)*100,
            ],
            'quantity' => 1,
        ]],
        'metadata' => [
            // 'order_id' => $data['order_id'],
        ],
        'customer_email'=>'hnhtechsolutions@gmail.com',
        'mode' => 'payment',
        'success_url' => route('carehome.feature_payment.success', ['carehome'=>$request['carehome']]),
        'cancel_url' => 'https://hnhtechsolutions.com/404',
        ]);
        CareHome::find($request['carehome'])->update(['featured_payment_id'=>$checkout_session->payment_intent, 'featured_payment_status'=>'pending']);
        return $checkout_session->url;
    }
    
    function paymentSuccess($carehome)
    {
        CareHome::find($carehome)->update(['featured_payment_status'=>'paid']);
        return ['status'=>true];
    }

    function amount($data)
    {
        $amount = Plan::find($data['plan_id'])->price;
        if (!empty($data['coupon'])) 
        {
            $plan = Plan::where('coupon', $data['coupon'])->first();
            if($plan!=null) 
            {
                $discountedAmount = $plan->price * ($plan->coupon_discount/100);
                return $amount = $plan->price - $discountedAmount;
            }
            return $amount;
        }
        return $amount;
    }

    // RELATIONS
    public function media()
    {
        return $this->hasMany(CareHomeMedia::class, 'carehome_id', 'id');
    }

    public function buildings()
    {
        return $this->hasMany(Building::class, 'carehome_id', 'id');
    }

    // ACCESSOR
    protected function image(): Attribute
    {
        return Attribute::make(
            fn ($value) => !empty($value)?asset($value):'',
        );
    }
}
