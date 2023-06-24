<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfessionalRequest;
use App\Http\Requests\UpdateProfessionalRequest;
use App\Models\Professional;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;

class ProfessionalController extends Controller
{
    function index()
    {
        $professionals = Professional::with('carehome')->get();
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

    function storeByGet()
    {   
        $request = request()->all();
        $professional = json_decode($request['data']['professional']);
        try {
            $professional->password = bcrypt($professional->password);
            $professional = Professional::create((array) $professional);
            $request['data']['professional_id'] = $professional->id;
            $subscription = (new Subscription)->store($request);
            return redirect('https://avanzandojuntos.dev-bt.xyz/success');
            // return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$professional]);
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

    function activate($professional)
    {
        $professional = Professional::find($professional);
        $professional->update(['status'=>1]);
        $link = 'https://avanzandojuntos.dev-bt.xyz/nurse/login';

        Mail::raw("abc", function ($message) use ($professional) 
        {
            $message->to($professional->email)->subject('Account Approved');
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });
        return response()->json(['status'=>true, 'response'=>"Account approved and mail sent to professional"]);
    }
}
