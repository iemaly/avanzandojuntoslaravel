<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubadminRequest;
use App\Http\Requests\UpdateSubadminRequest;
use App\Models\Subadmin;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SubadminController extends Controller
{

    use ImageUploadTrait;

    function index()
    {
        $subadmins = Subadmin::get();
        return response()->json(['status' => true, 'data' => $subadmins]);
    }

    function store(StoreSubadminRequest $request)
    {
        $request = $request->validated();

        try {
            $request['password'] = bcrypt($request['password']);
            if (!empty($request['image'])) {
                $imageName = $request['image']->getClientOriginalName() . '.' . $request['image']->extension();
                $request['image']->move(public_path('uploads/subadmin/images'), $imageName);
                $request['image'] = $imageName;
            }
            $subadmin = Subadmin::create($request);
            return response()->json(['status' => true, 'response' => 'Record Created', 'data' => $subadmin]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()]);
        }
    }

    function update(UpdateSubadminRequest $request, $subadmin)
    {
        $request = $request->validated();

        try {
            $subadmin = Subadmin::find($subadmin);
            $subadmin->update($request);
            return response()->json(['status' => true, 'response' => 'Record Updated', 'data' => $subadmin]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()]);
        }
    }

    function show($subadmin)
    {
        $subadmin = Subadmin::find($subadmin);
        return response()->json(['status' => true, 'data' => $subadmin]);
    }

    function destroy($subadmin)
    {
        return Subadmin::destroy($subadmin);
    }

    function activate($subadmin)
    {
        $subadmin = Subadmin::find($subadmin);
        if ($subadmin->status == 0) {
            $subadmin->update(['status' => 1]);

            Mail::raw("https://avanzandojuntos.dev-bt.xyz/login", function ($message) use ($subadmin) {
                $message->to($subadmin->email)->subject('Account Approved');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
            return response()->json(['status' => true, 'response' => "Account approved and mail sent to subadmin"]);
        }
        $subadmin->update(['status' => 0]);
        return response()->json(['status' => true, 'response' => "Account deactivated"]);
    }

    function subadminByEmail()
    {
        if (empty(request()->email)) return response(['status' => false, 'error' => 'Email is required']);
        return Subadmin::whereEmail(request()->email)->exists();
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

        $media = Subadmin::find(auth('subadmin_api')->id());
        try {
            // DELETING OLD IMAGE IF EXISTS
            if (!empty($media->image)) {
                $this->deleteImage($media->image);
                $media->update(['image' => (NULL)]);
            }

            // UPLOADING NEW IMAGE
            $filePath = $this->uploadImage(request()->image, 'uploads/subadmin/images');
            $media->update(['image' => $filePath]);
            return response()->json(['status' => true, 'response' => 'Profile Updated']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()]);
        }
    }

    function deleteProfilePic()
    {
        $subadmin = Subadmin::find(auth('subadmin_api')->id());
        if (!empty($subadmin->image)) {
            $this->deleteImage($subadmin->image);
            $subadmin->update(['image' => '']);
        }
        return response()->json(['status' => true, 'response' => 'Image Deleted']);
    }
}
