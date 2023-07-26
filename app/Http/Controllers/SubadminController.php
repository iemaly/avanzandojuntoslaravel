<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubadminRequest;
use App\Http\Requests\UpdateSubadminRequest;
use App\Models\Permission;
use App\Models\Subadmin;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SubadminController extends Controller
{

    use ImageUploadTrait;

    function index()
    {
        $subadmins = Subadmin::with('permissions.permission')->orderBy('id', 'desc')->get();
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

            Mail::raw("https://subadmin.avanzandojuntos.net/login", function ($message) use ($subadmin) {
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

    public function assignPermission($subadminId)
    {
        // Get the subadmin based on the given ID
        $subadmin = Subadmin::findOrFail($subadminId);

        // Retrieve all permissions and check if subadmin has each permission
        $permissions = Permission::select('permissions.*', DB::raw('IF(role_permissions.subadmin_id IS NULL, FALSE, TRUE) AS is_assigned'))
            ->leftJoin('role_permissions', function ($join) use ($subadminId) {
                $join->on('permissions.id', '=', 'role_permissions.permission_id')
                    ->where('role_permissions.subadmin_id', $subadminId);
            })
            ->get();

        return response()->json([
            'subadmin' => $subadmin,
            'permissions' => $permissions,
        ]);
    }

    public function savePermission(Request $request, $subadminId)
    {
        // Get the subadmin based on the given ID
        $subadmin = Subadmin::findOrFail($subadminId);

        // Validate the request data
        $this->validate($request, [
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Get the selected permission IDs
        $permissionIds = $request->input('permissions');

        // Assign the selected permissions to the subadmin
        $subadmin->permissions()->delete(); // Remove all existing permissions

        foreach ($permissionIds as $permissionId) {
            $subadmin->permissions()->create(['permission_id' => $permissionId]);
        }

        return response()->json([
            'message' => 'Permissions assigned successfully.',
        ]);
    }
}
