<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCareHomeRequest;
use App\Http\Requests\UpdateCareHomeRequest;
use App\Models\CareHome;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;

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
            $request['password'] = bcrypt($request['password']);
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

    function storeByGet()
    {   
        $request = request()->all();
        $carehome = json_decode($request['data']['carehome']);
        try {
            $carehome->password = bcrypt($carehome->password);
            $carehome = CareHome::create((array) $carehome);
            $request['data']['carehome_id'] = $carehome->id;
            $subscription = (new Subscription())->afterPayCarehome($request);
            return redirect('https://avanzandojuntos.dev-bt.xyz/success');
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

    function activate($carehome)
    {
        $carehome = CareHome::find($carehome);
        $carehome->update(['status'=>1]);

        Mail::raw("https://avanzandojuntos.dev-bt.xyz/carehome/login", function ($message) use ($carehome) 
        {
            $message->to($carehome->email)->subject('Account Approved');
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });
        return response()->json(['status'=>true, 'response'=>"Account approved and mail sent to carehome"]);
    }

    function findByEmail()
    {
        if(empty(request()->email)) return response(['status'=>false, 'error'=>'Email is required']);
        return CareHome::whereEmail(request()->email)->exists();
    }
}
