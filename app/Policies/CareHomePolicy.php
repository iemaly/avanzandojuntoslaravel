<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class CareHomePolicy
{
    use HandlesAuthorization;

    public function viewAny()
    {
        $permission = Permission::where(['model'=>'CareHome', 'permission'=>'index'])->first();
        return RolePermission::where(['subadmin_id'=>auth('subadmin_api')->id(), 'permission_id'=>$permission->id])->exists();
    }

    public function view()
    {
        //
    }

    public function create()
    {
        //
    }

    public function update()
    {
        //
    }

    public function delete()
    {
        //
    }

    public function restore()
    {
        //
    }

    public function forceDelete()
    {
        //
    }
}
