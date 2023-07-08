<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionForBusiness;
use App\Http\Requests\StoreSubscriptionForCarehome;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Models\Subscription;
use App\Http\Requests\StoreSubscriptionForUser;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubscriptionRequest  $request
     * @return \Illuminate\Http\Response
     */
    function store(StoreSubscriptionRequest $request)
    {
        $request = $request->validated();
        
        try {
            $subscription = (new Subscription())->stripePay($request);
            return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$subscription]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function storeForCarehome(StoreSubscriptionForCarehome $request)
    {
        $request = $request->validated();
        
        try {
            $subscription = (new Subscription())->stripePayCarehome($request);
            return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$subscription]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function storeForBusiness(StoreSubscriptionForBusiness $request)
    {
        $request = $request->validated();
        
        try {
            $subscription = (new Subscription())->stripePayBusiness($request);
            return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$subscription]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function storeForUser(StoreSubscriptionForUser $request)
    {
        $request = $request->validated();
        
        try {
            $subscription = (new Subscription())->stripePayUser($request);
            return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$subscription]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function afterPayForUser()
    {
        (new Subscription)->afteryPayUser(request()->all());
        return redirect('https://avanzandojuntos.dev-bt.xyz/success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubscriptionRequest  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubscriptionRequest $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }

    function deleteEmpty()
    {
        Subscription::where('creatable_id', (NULL))->delete();
        return redirect('https://avanzandojuntos.dev-bt.xyz/cancel');
    }
}
