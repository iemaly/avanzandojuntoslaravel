<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfessionalDocumentRequest;
use App\Http\Requests\StoreProfessionalRequest;
use App\Http\Requests\StoreProfessionalSlotRequest;
use App\Http\Requests\UpdateProfessionalRequest;
use App\Models\Professional;
use App\Models\ProfessionalDocument;
use App\Models\ProfessionalSlot;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Traits\ImageUploadTrait;

class ProfessionalController extends Controller
{
    use ImageUploadTrait;

    function index()
    {
        $professionals = Professional::with('carehome.media', 'professionalMedia', 'slots')->get();
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
        $professional = Professional::with('carehome.media', 'professionalMedia', 'slots')->find($professional);
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

        Mail::raw("https://avanzandojuntos.dev-bt.xyz/nurse/login", function ($message) use ($professional) 
        {
            $message->to($professional->email)->subject('Account Approved');
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });
        return response()->json(['status'=>true, 'response'=>"Account approved and mail sent to professional"]);
    }

    function proFessionalByEmail()
    {
        if(empty(request()->email)) return response(['status'=>false, 'error'=>'Email is required']);
        return Professional::whereEmail(request()->email)->exists();
    }

    function profilePicUpdate()
    {
        $validator = Validator::make(request()->all(),
        [
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:30000',
        ]);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $media = Professional::find(auth('professional_api')->id());
        try {
            // DELETING OLD IMAGE IF EXISTS
            if (!empty($media->image)) 
            {
                $this->deleteImage($media->image);
                $media->update(['image'=>(NULL)]);
            }
    
            // UPLOADING NEW IMAGE
            $filePath = $this->uploadImage(request()->image, 'uploads/professional/images');
            $media->update(['image'=>$filePath]);
            return response()->json(['status'=>true, 'response'=>'Profile Updated']);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function deleteProfilePic()
    {
        $professional = Professional::find(auth('professional_api')->id());
        if (!empty($professional->image)) 
        {
            $this->deleteImage($professional->image);
            $professional->update(['image'=>'']);
        } 
        return response()->json(['status'=>true, 'response'=>'Image Deleted']);
    }

    function addMedia(StoreProfessionalDocumentRequest $request)
    {
        $request = $request->validated();
        try {
            $professional = Professional::with('professionalMedia')->find(auth('professional_api')->id());   
            if (!empty($request['media'])) 
            {
                foreach($request['media'] as $media)
                {
                    switch ($media['type']) {
                        case 'driver_license':
                            $filePath = $this->uploadImage($media['document'], 'uploads/professional/driver_license');
                            $media['document']=$filePath;
                            $professional->professionalMedia()->create($media);
                            break;

                        case 'ley_300':
                            $filePath = $this->uploadImage($media['document'], 'uploads/professional/ley_300');
                            $media['document']=$filePath;
                            $professional->professionalMedia()->create($media);
                            break;

                        case 'covid_19_vaccine':
                            $filePath = $this->uploadImage($media['document'], 'uploads/professional/covid_19_vaccine');
                            $media['document']=$filePath;
                            $professional->professionalMedia()->create($media);
                            break;

                        case 'buena_conduct_certificate':
                            $filePath = $this->uploadImage($media['document'], 'uploads/professional/buena_conduct_certificate');
                            $media['document']=$filePath;
                            $professional->professionalMedia()->create($media);
                            break;

                        case 'rn_license_certificate':
                            $filePath = $this->uploadImage($media['document'], 'uploads/professional/rn_license_certificate');
                            $media['document']=$filePath;
                            $professional->professionalMedia()->create($media);
                            break;
                    }
                }
            }
            return response()->json(['status'=>true, 'response'=>'Media Added', 'data'=>$professional]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function deleteDocument($document)
    {
        $document = ProfessionalDocument::find($document);
        if (!empty($document->document)) 
        {
            $this->deleteImage($document->document);
            $document->destroy($document->id);
        }
        return response()->json(['status'=>true, 'response'=>'Document Deleted']);
    }

    function storeSlot(StoreProfessionalSlotRequest $request, $professional)
    {        
        $request = $request->validated();
        
        try {
            $professional = Professional::with('slots')->find($professional);
            foreach ($request['slot'] as $slot) $professional->slots()->create($slot);
            return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$professional]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function deleteSlot($slot)
    {
        return ProfessionalSlot::destroy($slot);
    }

}
