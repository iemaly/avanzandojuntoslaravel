<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Professional extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
        'success_url' => route('professional.feature_payment.success', ['professional'=>$request['professional']]),
        'cancel_url' => 'https://hnhtechsolutions.com/404',
        ]);
        $this->find($request['professional'])->update(['featured_payment_id'=>$checkout_session->payment_intent, 'featured_payment_status'=>'pending']);
        return $checkout_session->url;
    }
    
    function paymentSuccess($professional)
    {
        $this->find($professional)->update(['featured_payment_status'=>'paid']);
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

    // RELATION

    public function carehome()
    {
        return $this->belongsTo(CareHome::class, 'carehome_id', 'id');
    }

    public function professionalMedia()
    {
        return $this->hasMany(ProfessionalDocument::class, 'professional_id', 'id');
    }

    public function slots()
    {
        return $this->hasMany(ProfessionalSlot::class, 'professional_id', 'id');
    }

    public function paymentMethods()
    {
        return $this->hasMany(ProfessionalPaymentMethod::class, 'professional_id', 'id');
    }

    // ACCESSOR
    protected function image(): Attribute
    {
        return Attribute::make(
            fn ($value) => !empty($value)?asset($value):asset('assets/profile_pics/professional.jpg'),
        );
    }
}
