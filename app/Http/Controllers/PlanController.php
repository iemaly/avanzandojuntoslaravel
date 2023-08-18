<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Models\Admin;
use App\Models\Plan;

class PlanController extends Controller
{
    function index()
    {
        if(auth()->check()) $this->authorize('viewAny', Plan::class);
        
        $plans = Plan::orderBy('id', 'desc')->get();
        return response()->json(['status'=>true, 'data'=>$plans]);
    }

    function store(StorePlanRequest $request)
    {
        if(auth()->check()) $this->authorize('create', Plan::class);

        $request = $request->validated();
        
        try {
            $plan = Plan::create($request);
            return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$plan]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function update(UpdatePlanRequest $request, $plan)
    {
        if(auth()->check()) $this->authorize('update', Plan::class);

        $request = $request->validated();
        
        try {
            $plan = Plan::find($plan);
            $plan->update($request);
            return response()->json(['status'=>true, 'response'=>'Record Updated', 'data'=>$plan]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function show($plan)
    {
        if(auth()->check()) $this->authorize('view', Plan::class);

        $plan = Plan::find($plan);
        return response()->json(['status'=>true, 'data'=>$plan]);
    }

    function destroy($plan)
    {
        if(auth()->check()) $this->authorize('delete', Plan::class);

        return Plan::destroy($plan);
    }
}
