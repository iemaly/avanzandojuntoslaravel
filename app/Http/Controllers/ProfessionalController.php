<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfessionalRequest;
use App\Http\Requests\UpdateProfessionalRequest;
use App\Models\Professional;

class ProfessionalController extends Controller
{
    function index()
    {
        $professionals = Professional::all();
        return response()->json(['status'=>true, 'data'=>$professionals]);
    }

    function store(StoreProfessionalRequest $request)
    {
        $request = $request->validated();
        
        try {
            $request['password'] = bcrypt($request['password']);
            if (!empty($request['image'])) 
            {
                $imageName = $request['image']->getClientOriginalName().'.'.$request['image']->extension();
                $request['image']->move(public_path('uploads/professional/images'), $imageName);
                $request['image']=$imageName;
            }
            $professional = Professional::create($request);
            return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$professional]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function update(UpdateProfessionalRequest $request, $professional)
    {
        $request = $request->validated();
        
        try {
            $professional = Professional::find($professional);
            $professional->update($request);
            return response()->json(['status'=>true, 'response'=>'Record Updated', 'data'=>$professional]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function show($professional)
    {
        $professional = Professional::find($professional);
        return response()->json(['status'=>true, 'data'=>$professional]);
    }

    function destroy($professional)
    {
        return Professional::destroy($professional);
    }
}
