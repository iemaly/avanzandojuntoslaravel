<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAdminRequest;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Subadmin;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    protected function login(LoginAdminRequest $request)
    {
        $request = $request->validated();
        $login = (new Admin)->login($request['email'], $request['password']);
        $status = false;
        if($login['status'] === 404) return response()->json(['status' => $status, 'error' => 'Email Not Found']);
        if(!$login['attempt']) return response()->json(['status' => $status, 'error' => 'Invalid Credentials']);
        if ($login['attempt']) 
        {
            $data = auth($login['role'])->user();
            if($login['role'] == 'carehome' && !(new Admin)->checkCarehomeApproveStatus($data->id)) return response()->json(['status' => false, 'error' => 'Account Not Approved']);
            if($login['role'] == 'professional' && !(new Admin)->checkProfessionalApproveStatus($data->id)) return response()->json(['status' => false, 'error' => 'Account Not Approved']);
            if($login['role'] == 'user' && !(new Admin)->checkUserApproveStatus($data->id)) return response()->json(['status' => false, 'error' => 'Account Not Approved']);
            $data->update(['access_token' => $data->createToken('Access Token For '.$login['role'])->accessToken]);
            $data['role'] = $login['role'];
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

    function activeDeactive($subadmin)
    {
        $subadmin = Subadmin::find($subadmin);
        if($subadmin->status) 
        {
            $subadmin->update(['status'=>0]);
            return ['status'=>true, 'response'=>"Status changed to deactive"];
        }
        $subadmin->update(['status'=>1]);
        return ['status'=>true, 'response'=>"Status changed to active"];
    }

    function activeDeactiveDoctor($doctor)
    {
        $doctor = Doctor::find($doctor);
        if($doctor->status) 
        {
            $doctor->update(['status'=>0]);
            return ['status'=>true, 'response'=>"Status changed to deactive"];
        }
        $doctor->update(['status'=>1]);
        return ['status'=>true, 'response'=>"Status changed to active"];
    }

    function activeDeactiveUser($user)
    {
        $user = User::find($user);
        if($user->status) 
        {
            $user->update(['status'=>0]);
            return ['status'=>true, 'response'=>"Status changed to deactive"];
        }
        $user->update(['status'=>1]);
        return ['status'=>true, 'response'=>"Status changed to active"];
    }
}
