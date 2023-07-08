<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBusinessRequest;
use App\Http\Requests\UpdateBusinessRequest;
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
        $business = Business::get();
        return response()->json(['status' => true, 'data' => $business]);
    }

    function store(StoreBusinessRequest $request)
    {
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
            $request['data']['business_id'] = $business->id;
            $subscription = (new Subscription())->afterPayBusiness($request);
            return redirect('https://avanbusiness.dev-bt.xyz');
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function update(UpdateBusinessRequest $request, $business)
    {
        $request = $request->validated();

        try {
            $business = Business::find($business);
            $business->update($request);
            return response()->json(['status' => true, 'response' => 'Record Updated', 'data' => $business]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()]);
        }
    }

    function show($business)
    {
        $business = Business::find($business);
        return response()->json(['status' => true, 'data' => $business]);
    }

    function destroy($business)
    {
        return Business::destroy($business);
    }

    function activate($business)
    {
        $business = Business::find($business);
        $business->update(['status' => 1]);

        Mail::raw("https://avanbusiness.dev-bt.xyz", function ($message) use ($business) {
            $message->to($business->email)->subject('Account Approved');
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });
        return response()->json(['status' => true, 'response' => "Account approved and mail sent to business"]);
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
}
