<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreCareHomeRequest;
use App\Http\Requests\UpdateCareHomeRequest;
use App\Models\CareHome;

class CareHomeController extends Controller
{
    function index()
    {
        $carehomes = CareHome::all();
        return response()->json(['status'=>true, 'data'=>$carehomes]);
    }

    function store(StoreCareHomeRequest $request)
    {
        $request = $request->validated();
        
        try {
            if (!empty($request['image'])) 
            {
                $imageName = $request['image']->getClientOriginalName().'.'.$request['image']->extension();
                $request['image']->move(public_path('uploads/carehome/images'), $imageName);
                $request['image']=$imageName;
            }
            $carehome = CareHome::create($request);
            return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$carehome]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function update(UpdateCareHomeRequest $request, $carehome)
    {
        $request = $request->validated();
        
        try {
            $carehome = CareHome::find($carehome);
            $carehome->update($request);
            return response()->json(['status'=>true, 'response'=>'Record Updated', 'data'=>$carehome]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function show($carehome)
    {
        $carehome = Carehome::find($carehome);
        return response()->json(['status'=>true, 'data'=>$carehome]);
    }

    function destroy($carehome)
    {
        return CareHome::destroy($carehome);
    }

    function bulk()
    {
        $response = (new Carehome())->import(request()->sheet);
        return response()->json(['status'=>$response['status'], 'message'=>$response['status']===true?"Sheet Imported":$response['error']]);
    }
}
