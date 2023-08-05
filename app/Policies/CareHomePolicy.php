<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class CareHomePolicy
{
    use HandlesAuthorization;

    public function viewAny()
    {
        if(auth()->user()->getTable() != 'subadmins') return true;
        
        return auth()->user()->permissions->contains(fn ($permission) => $permission->permission->model === 'CareHome' && $permission->permission->permission === 'index');
    }

    public function view()
    {
        if(auth()->user()->getTable() != 'subadmins') return true;
        
        return auth()->user()->permissions->contains(fn ($permission) => $permission->permission->model === 'CareHome' && $permission->permission->permission === 'show');
    }

    public function create()
    {
        if(auth()->user()->getTable() != 'subadmins') return true;
        
        return auth()->user()->permissions->contains(fn ($permission) => $permission->permission->model === 'CareHome' && $permission->permission->permission === 'store');
    }

    public function update()
    {
        if(auth()->user()->getTable() != 'subadmins') return true;
        
        return auth()->user()->permissions->contains(fn ($permission) => $permission->permission->model === 'CareHome' && $permission->permission->permission === 'update');
    }

    public function delete()
    {
        if(auth()->user()->getTable() != 'subadmins') return true;
        
        return auth()->user()->permissions->contains(fn ($permission) => $permission->permission->model === 'CareHome' && $permission->permission->permission === 'delete');
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
