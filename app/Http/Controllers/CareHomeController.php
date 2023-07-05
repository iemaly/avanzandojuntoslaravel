<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCareHomeMediaRequest;
use App\Http\Requests\StoreCareHomeRequest;
use App\Http\Requests\UpdateCareHomeRequest;
use App\Models\CareHome;
use App\Models\CareHomeMedia;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Validator;

class CareHomeController extends Controller
{
    use ImageUploadTrait;

    function index()
    {
        $carehomes = CareHome::with('media')->get();
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
            if(!empty($request['password'])) $request['password'] = bcrypt($request['password']); 
            else unset($request['password']);
            $carehome = CareHome::find($carehome);
            $carehome->update($request);
            return response()->json(['status'=>true, 'response'=>'Record Updated', 'data'=>$carehome]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function show($carehome)
    {
        $carehome = Carehome::with('media')->find($carehome);
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

    function profilePicUpdate()
    {
        $validator = Validator::make(request()->all(),
        [
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:30000',
        ]);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $media = CareHome::find(auth('carehome_api')->id());
        try {
            // DELETING OLD IMAGE IF EXISTS
            if (!empty($media->image)) 
            {
                $this->deleteImage($media->image);
                $media->update(['image'=>(NULL)]);
            }
    
            // UPLOADING NEW IMAGE
            $filePath = $this->uploadImage(request()->image, 'uploads/carehome/images');
            $media->update(['image'=>$filePath]);
            return response()->json(['status'=>true, 'response'=>'Profile Updated']);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function deleteProfilePic()
    {
        $carehome = CareHome::find(auth('carehome_api')->id());
        if (!empty($carehome->image)) 
        {
            $this->deleteImage($carehome->image);
            $carehome->update(['image'=>'']);
        } 
        return response()->json(['status'=>true, 'response'=>'Image Deleted']);
    }

    function addMedia(StoreCareHomeMediaRequest $request)
    {
        $request = $request->validated();
        try {
            $carehome = Carehome::with('media')->find(auth('carehome_api')->id());   
            if (!empty($request['media'])) 
            {
                foreach($request['media'] as $media)
                {
                    switch ($media['type']) {
                        case 'blueprint':
                            $filePath = $this->uploadImage($media['document'], 'uploads/carehome/blueprints');
                            $media['document']=$filePath;
                            $carehome->media()->create($media);
                            break;

                        case 'hospital':
                            $filePath = $this->uploadImage($media['document'], 'uploads/carehome/hospital');
                            $media['document']=$filePath;
                            $carehome->media()->create($media);
                            break;

                        case 'personal':
                            $filePath = $this->uploadImage($media['document'], 'uploads/carehome/personal');
                            $media['document']=$filePath;
                            $carehome->media()->create($media);
                            break;

                        case 'resume':
                            $filePath = $this->uploadImage($media['document'], 'uploads/carehome/resume');
                            $media['document']=$filePath;
                            $carehome->media()->create($media);
                            break;
                    }
                }
            }
            return response()->json(['status'=>true, 'response'=>'Media Added', 'data'=>$carehome]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function deleteDocument($document)
    {
        $document = CareHomeMedia::find($document);
        if (!empty($document->document)) $this->deleteImage($document->document);
        return response()->json(['status'=>true, 'response'=>'Document Deleted']);
    }
}
