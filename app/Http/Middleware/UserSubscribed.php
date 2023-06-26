<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;

class UserSubscribed
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
        $subscriptionExists = Subscription::where(['creatable_type'=>'App\Models\User', 'creatable_id'=>request()->user_id])->exists();
        if(!$subscriptionExists) return response()->json(['status'=>false, 'error'=>'Buy subscription first']);
        return $next($request);
    }
}
