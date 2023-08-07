<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny()
    {
        if(auth()->user()->getTable() != 'subadmins') return true;
        
        return auth()->user()->permissions->contains(fn ($permission) => $permission->permission->model === 'Business' && $permission->permission->permission === 'index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Business  $professional
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view()
    {
        if(auth()->user()->getTable() != 'subadmins') return true;
        
        return auth()->user()->permissions->contains(fn ($permission) => $permission->permission->model === 'Business' && $permission->permission->permission === 'show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create()
    {
        if(auth()->user()->getTable() != 'subadmins') return true;
        
        return auth()->user()->permissions->contains(fn ($permission) => $permission->permission->model === 'Business' && $permission->permission->permission === 'store');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Business  $professional
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update()
    {
        if(auth()->user()->getTable() != 'subadmins') return true;
        
        return auth()->user()->permissions->contains(fn ($permission) => $permission->permission->model === 'Business' && $permission->permission->permission === 'update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Business  $professional
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete()
    {
        if(auth()->user()->getTable() != 'subadmins') return true;
        
        return auth()->user()->permissions->contains(fn ($permission) => $permission->permission->model === 'Business' && $permission->permission->permission === 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Business  $professional
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore()
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Business  $professional
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete()
    {
        //
    }
}
