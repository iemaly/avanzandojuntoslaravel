<?php

namespace App\Http\Controllers;

use App\Events\SendUserEmailVerificationEvent;
use App\Http\Requests\StoreAdvertisementRequest;
use App\Http\Requests\StoreBusinessRequest;
use App\Http\Requests\UpdateAdvertisementRequest;
use App\Http\Requests\UpdateBusinessRequest;
use App\Models\Admin;
use App\Models\Advertisement;
use App\Models\Business;
use App\Models\Subscription;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    use ImageUploadTrait;

    function index()
    {
        if(auth()->check()) $this->authorize('viewAny', Business::class);
   
        $businessId = request()->business_id;
        $business = Business::with('advertisements')->orderBy('id', 'desc')->get();
        if(!empty($businessId)) $business = Business::with('advertisements')->where('id',$businessId)->get();
        return response()->json(['status' => true, 'data' => $business]);
    }

    function store(StoreBusinessRequest $request)
    {
        if(auth()->check()) $this->authorize('create', Business::class);
        
        $request = $request->validated();

        try {
            $request['password'] = bcrypt($request['password']);
            if (!empty($request['image'])) {
                $imageName = $request['image']->getClientOriginalName() . '.' . $request['image']->extension();
                $request['image']->move(public_path('uploads/business/images'), $imageName);
                $request['image'] = $imageName;
            }
            $business = Business::create($request);
            return response()->json(['status' => true, 'response' => 'Record Created', 'data' => $business]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()]);
        }
    }

    function storeByGet()
    {   
        $request = request()->all();
        $business = json_decode($request['data']['business']);
        try {
            $business->password = bcrypt($business->password);
            $business = Business::create((array) $business);
            $business['role'] = 'business';
            event(new SendUserEmailVerificationEvent($business));
            $request['data']['business_id'] = $business->id;
            $subscription = (new Subscription())->afterPayBusiness($request);
            return redirect('https://business.avanzandojuntos.net');
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function update(UpdateBusinessRequest $request, $id)
    {
        if(auth()->check()) $this->authorize('update', Business::class);
        
        $request = $request->validated();

        try {
            $business = Business::find($id);
            $business->update($request);
            return response()->json(['status' => true, 'response' => 'Record Updated', 'data' => $business]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()]);
        }
    }

    function show($business)
    {
        if(auth()->check()) $this->authorize('view', Business::class);
        
        $business = Business::find($business);
        return response()->json(['status' => true, 'data' => $business]);
    }

    function destroy($business)
    {
        if(auth()->check()) $this->authorize('delete', Business::class);
        
        return Business::destroy($business);
    }

    function activate($business)
    {
        if(auth()->check()) $this->authorize('update', Business::class);

        $business = Business::find($business);
        if($business->status == 0)
        {
            $business->update(['status' => 1]);

            Mail::raw("https://avanbusiness.dev-bt.xyz", function ($message) use ($business) {
                $message->to($business->email)->subject('Account Approved');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
            return response()->json(['status' => true, 'response' => "Account approved and mail sent to business"]);
        }
        $business->update(['status'=>0]);
        return response()->json(['status'=>true, 'response'=>"Account deactivated"]);
    }

    function businessByEmail()
    {
        if (empty(request()->email)) return response(['status' => false, 'error' => 'Email is required']);
        return Business::whereEmail(request()->email)->exists();
    }

    function profilePicUpdate()
    {
        $validator = Validator::make(
            request()->all(),
            [
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:30000',
            ]
        );

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $media = Business::find(auth('business_api')->id());
        try {
            // DELETING OLD IMAGE IF EXISTS
            if (!empty($media->image)) {
                $this->deleteImage($media->image);
                $media->update(['image' => (NULL)]);
            }

            // UPLOADING NEW IMAGE
            $filePath = $this->uploadImage(request()->image, 'uploads/business/images');
            $media->update(['image' => $filePath]);
            return response()->json(['status' => true, 'response' => 'Profile Updated']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()]);
        }
    }

    function deleteProfilePic()
    {
        $business = Business::find(auth('business_api')->id());
        if (!empty($business->image)) {
            $this->deleteImage($business->image);
            $business->update(['image' => '']);
        }
        return response()->json(['status' => true, 'response' => 'Image Deleted']);
    }

    // ADVERTISEMENT
    function storeAdvertisement(StoreAdvertisementRequest $request)
    {
        if(auth()->check()) $this->authorize('create', Advertisement::class);
        
        $request = $request->validated();

        try {
            if (!empty($request['image'])) {
                $imageName = $request['image']->getClientOriginalName() . '.' . $request['image']->extension();
                $request['image']->move(public_path('uploads/business/advertisement/images'), $imageName);
                $request['image'] = $imageName;
            }
            $request['business_id'] = auth('business_api')->id();
            $advertisement = Advertisement::create($request);
            return response()->json(['status' => true, 'response' => 'Record Created', 'data' => $advertisement]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()]);
        }
    }

    function advertisementImageUpdate($advertisement)
    {
        $validator = Validator::make(
            request()->all(),
            [
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:30000',
            ]
        );

        if ($validator->fails()) return response()->json(['status'=>false, 'error'=>$validator->errors()]);

        $advertisement = Advertisement::find($advertisement);
        try {
            // DELETING OLD IMAGE IF EXISTS
            if (!empty($advertisement->image)) {
                $this->deleteImage($advertisement->image);
                $advertisement->update(['image' => (NULL)]);
            }

            // UPLOADING NEW IMAGE
            $imageName = request()->image->getClientOriginalName() . '.' . request()->image->extension();
            request()->image->move(public_path('uploads/business/advertisement/images'), $imageName);
            $advertisement->update(['image' => $imageName]);
            return response()->json(['status' => true, 'response' => 'Image Updated']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()]);
        }
    }

    function deleteAdvertisementImage($advertisement)
    {
        $advertisement = Advertisement::find($advertisement);
        if (!empty($advertisement->image)) {
            $this->deleteImage($advertisement->image);
            $advertisement->update(['image' => '']);
        }
        return response()->json(['status' => true, 'response' => 'Image Deleted']);
    }

    function updateAdvertisement(UpdateAdvertisementRequest $request, $advertisement)
    {
        if(auth()->check()) $this->authorize('update', Advertisement::class);
        
        $request = $request->validated();

        try {
            $advertisement = Advertisement::find($advertisement);
            $advertisement->update($request);
            return response()->json(['status' => true, 'response' => 'Record Updated', 'data' => $advertisement]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()]);
        }
    }

    function advertisements()
    {
        if(auth()->check()) $this->authorize('viewAny', Advertisement::class);
        
        $advertisements = Advertisement::with('business')->orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'data' => $advertisements]);
    }

    function businessAdvertisements()
    {
        $advertisements = Advertisement::with('business')->where('business_id', auth('business_api')->id())->orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'data' => $advertisements]);
    }

    function advertisementsForUser()
    {
        $advertisements = Advertisement::with('business')->where(['status'=>1])->get();
        if(!empty(request()->business_id)) $advertisements = Advertisement::with('business')->where(['status'=>1, 'business_id'=>request()->business_id])->orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'data' => $advertisements]);
    }

    function advertisementShow($advertisement)
    {
        if(auth()->check()) $this->authorize('view', Advertisement::class);
        
        $advertisement = Advertisement::with('business')->find($advertisement);
        return response()->json(['status' => true, 'data' => $advertisement]);
    }

    function destroyAdvertisement($advertisement)
    {
        if(auth()->check()) $this->authorize('delete', Advertisement::class);
        
        return Advertisement::destroy($advertisement);
    }

    function approveAdvertisement($Advertisement)
    {
        if(auth()->check()) $this->authorize('update', Advertisement::class);
        
        $Advertisement = Advertisement::with('business')->find($Advertisement);
        if ($Advertisement->status==0) 
        {
            $Advertisement->update(['status'=>1]);
            
            Mail::raw("Advertisement Approved.", function ($message) use ($Advertisement) 
            {
                $message->to($Advertisement->business->email)->subject('Advertisement Approved');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
            return response()->json(['status'=>true, 'response'=>"Advertisement approved and mail sent to business"]);
        }
        return response()->json(['status'=>true, 'response'=>"Already approved"]);
    }

    function refuseAdvertisement($Advertisement)
    {
        if(auth()->check()) $this->authorize('update', Advertisement::class);
        
        $Advertisement = Advertisement::with('business')->find($Advertisement);
        if ($Advertisement->status==1) $Advertisement->update(['status'=>0]);
        return response()->json(['status'=>true, 'response'=>"Advertisement refused"]);
    }

    function featureUnfeature($advertisement)
    {
        if(auth()->check()) $this->authorize('update', Advertisement::class);
        
        $advertisement = Advertisement::find($advertisement);
        if($advertisement->is_featured == 0)
        {
            $advertisement->update(['is_featured'=>1]);
            
            Mail::raw("Advertisement Featured", function ($message) use ($advertisement) 
            {
                $message->to($advertisement->business->email)->subject('Advertisement Featured');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
            return response()->json(['status'=>true, 'response'=>"Advertisement Featured"]);
        }
        $advertisement->update(['is_featured'=>0]);
        return response()->json(['status'=>true, 'response'=>"Advertisement Unfeature"]);
    }

}
