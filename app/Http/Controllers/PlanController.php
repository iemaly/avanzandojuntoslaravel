<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Models\Plan;

class PlanController extends Controller
{
    function index()
    {
        $plans = Plan::all();
        return response()->json(['status'=>true, 'data'=>$plans]);
    }

    function store(StorePlanRequest $request)
    {
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
        $plan = Plan::find($plan);
        return response()->json(['status'=>true, 'data'=>$plan]);
    }

    function destroy($plan)
    {
        return Plan::destroy($plan);
    }
}
