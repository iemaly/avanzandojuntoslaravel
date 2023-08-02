<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;

class isSubscribedCarehome
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $subscriptionExists = Subscription::where(['creatable_type'=>'App\Models\Carehome', 'creatable_id'=>auth('carehome_api')->id()])->exists();
        if(!$subscriptionExists) return response()->json(['status'=>false, 'error'=>'Buy subscription first']);
        return $next($request);
    }
}
