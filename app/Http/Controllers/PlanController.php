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
        $permission = Admin::permission('Plan', 'index', auth('subadmin_api')->id());
        if(!$permission['status']) return $permission;
        
        $plans = Plan::all();
        return response()->json(['status'=>true, 'data'=>$plans]);
    }

    function store(StorePlanRequest $request)
    {
        $permission = Admin::permission('Plan', 'store', auth('subadmin_api')->id());
        if(!$permission['status']) return $permission;

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
        $permission = Admin::permission('Plan', 'update', auth('subadmin_api')->id());
        if(!$permission['status']) return $permission;

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
        $permission = Admin::permission('Plan', 'show', auth('subadmin_api')->id());
        if(!$permission['status']) return $permission;

        $plan = Plan::find($plan);
        return response()->json(['status'=>true, 'data'=>$plan]);
    }

    function destroy($plan)
    {
        $permission = Admin::permission('Plan', 'delete', auth('subadmin_api')->id());
        if(!$permission['status']) return $permission;

        return Plan::destroy($plan);
    }
}
