<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAdminRequest;
use App\Models\Admin;
use App\Models\User;
use App\Models\Professional;
use App\Models\Business;
use App\Models\Subadmin;
use App\Models\Advertisement;
use App\Models\CareHome;
use App\Models\Post;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    protected function login(LoginAdminRequest $request)
    {
        $request = $request->validated();
        $login = (new Admin)->login($request['email'], $request['password'], $request['type']);
        $status = false;
        if($login['status'] === 404) return response()->json(['status' => $status, 'error' => 'Email Not Found']);
        if(!$login['attempt']) return response()->json(['status' => $status, 'error' => 'Invalid Credentials']);
        if ($login['attempt']) 
        {
            $data = auth($login['role'])->user();
            if($login['role'] == 'carehome') 
            { 
                if(!(new Admin)->checkCarehomeApproveStatus($data->id)) return response()->json(['status' => false, 'error' => 'Account Not Approved']);
                
                // CHECKING SUBSCRIPTION
                $is_subscribed = false;
                $subscriptionExists = Subscription::where(['creatable_type'=>'App\Models\Carehome', 'creatable_id'=>auth('carehome')->id()])->exists();
                if($subscriptionExists) $is_subscribed = true;
            }
            if($login['role'] == 'professional' && (!(new Admin)->checkProfessionalApproveStatus($data->id) || !(new Admin)->emailVerified($login['role'],$data->id))) return response()->json(['status' => false, 'error' => 'Account Not Approved Or Email not verified']);
            if($login['role'] == 'user' && (!(new Admin)->checkUserApproveStatus($data->id) || !(new Admin)->emailVerified($login['role'],$data->id))) return response()->json(['status' => false, 'error' => 'Account Not Approved Or Email not verified']);
            if($login['role'] == 'business' && (!(new Admin)->checkBusinessApproveStatus($data->id) || !(new Admin)->emailVerified($login['role'],$data->id))) return response()->json(['status' => false, 'error' => 'Account Not Approved Or Email not verified']);
            if($login['role'] == 'subadmin' && !(new Admin)->checkSubadminApproveStatus($data->id)) return response()->json(['status' => false, 'error' => 'Account Not Approved']);
            $data->update(['access_token' => $data->createToken('Access Token For '.$login['role'])->accessToken]);
            $data['role'] = $login['role'];
            if($login['role'] == 'carehome') $data['is_subscribed'] = $is_subscribed;
            $status = true;
        }

        return response()->json(['status' => $status, 'data' => $data]);
    }

    protected function forgetPwdProcess()
    {
        $validator = Validator::make(
            request()->all(),
            [
                'email' => 'required|min:6|max:50',
            ]
        );

        if ($validator->fails()) return response(['status' => false, 'errors' => $validator->errors()]);

        $admin = Admin::where('email', request()->email)->first();
        if ($admin == null) {
            return response(['status' => false, 'message' => 'It looks like we do not have this account!']);
        } else {
            $token = rand(1000, 9999);

            Mail::raw("$token", function ($message) {
                $message->to(request()->email)->subject('Forget Password');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });

            $admin->reset_token = $token;
            if ($admin->update()) return response(['status' => true, 'message' => 'Reset Token Has Been Sent! Check Your Email For The Link']);
        }
    }

    protected function resetPwdProcess()
    {
        $controls = request()->all();
        $rules = array(
            'password' => 'required|confirmed|min:6|max:60',
            'token' => 'required|digits:4',
            'password_confirmation' => 'required|min:6|max:60',
        );
        $messages = [
            'password.required' => 'Password is Required field',
            'password_confirmation.required' => 'Password Confirmation is Required field',
        ];
        $validator = Validator::make($controls, $rules, $messages);
        if ($validator->fails()) {
            return response(['status' => false, 'errors' => $validator->errors()]);
        }

        $admin = Admin::where('reset_token', request()->token)->first();
        if ($admin != null) {
            $admin->password = bcrypt(request()->password);
            $admin->reset_token = null;
            $admin->update();
            return response(['status' => true, 'errors' => 'Password Updated']);
        }
        return response(['status' => false, 'errors' => 'Token Incorrect Or Token Expired']);
    }

    function emailVerify($role, $id)
    {   
        switch ($role) {
            case 'user':
                $user = User::find($id);
                if($user->email_verified == 0)
                {
                    $user->update(['email_verified'=>1]);
        
                    Mail::raw("Thank You For Verification", function ($message) use ($user) 
                    {
                        $message->to($user->email)->subject('Email Verified');
                        $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    });
                    return response()->json(['status'=>true, 'response'=>"Email Verified"]);
                }
                return response()->json(['status'=>true, 'response'=>"Already verified"]);
                break;

            case 'professional':
                $professional = Professional::find($id);
                if($professional->email_verified == 0)
                {
                    $professional->update(['email_verified'=>1]);
        
                    Mail::raw("Thank You For Verification", function ($message) use ($professional) 
                    {
                        $message->to($professional->email)->subject('Email Verified');
                        $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    });
                    return response()->json(['status'=>true, 'response'=>"Email Verified"]);
                }
                return response()->json(['status'=>true, 'response'=>"Already verified"]);
                break;

            case 'business':
                $business = Business::find($id);
                if($business->email_verified == 0)
                {
                    $business->update(['email_verified'=>1]);
        
                    Mail::raw("Thank You For Verification", function ($message) use ($business) 
                    {
                        $message->to($business->email)->subject('Email Verified');
                        $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    });
                    return response()->json(['status'=>true, 'response'=>"Email Verified"]);
                }
                return response()->json(['status'=>true, 'response'=>"Already verified"]);
                break;
        }
    }

    function dashboard()
    {
        $data = [];
        $data['users'] = User::count();
        $data['professionals'] = Professional::count();
        $data['business'] = Business::count();
        $data['subadmins'] = Subadmin::count();
        $data['blogs'] = Post::count();
        $data['advertisements'] = Advertisement::count();
        return response()->json(['status'=>true, 'data'=>$data]);
    }

    function isViewed()
    {
        $data = [];
        $data['carehomes'] = CareHome::where('is_viewed', 0)->count();
        $data['users'] = User::where('is_viewed', 0)->count();
        $data['professionals'] = Professional::where('is_viewed', 0)->count();
        $data['business'] = Business::where('is_viewed', 0)->count();
        $data['subadmins'] = Subadmin::where('is_viewed', 0)->count();
        $data['blogs'] = Post::where('is_viewed', 0)->count();
        $data['advertisements'] = Advertisement::where('is_viewed', 0)->count();
        return response()->json(['status'=>true, 'data'=>$data]);
    }

    function isViewedUpdate($type)
    {
        switch($type)
        {
            case 'carehomes';
                CareHome::where('is_viewed', 0)->update(['is_viewed'=>1]);
            break;
            case 'users';
                User::where('is_viewed', 0)->update(['is_viewed'=>1]);
            break;
            case 'professionals';
                Professional::where('is_viewed', 0)->update(['is_viewed'=>1]);
            break;
            case 'business';
                Business::where('is_viewed', 0)->update(['is_viewed'=>1]);
            break;
            case 'subadmins';
                Subadmin::where('is_viewed', 0)->update(['is_viewed'=>1]);
            break;
            case 'blogs';
                Post::where('is_viewed', 0)->update(['is_viewed'=>1]);
            break;
            case 'advertisements';
                Advertisement::where('is_viewed', 0)->update(['is_viewed'=>1]);
            break;
        }
        return response()->json(['status'=>true, 'response'=>'Updated']);
    } 
}
