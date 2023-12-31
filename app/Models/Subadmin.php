<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Subadmin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function permissions()
    {
        return $this->hasMany(RolePermission::class, 'subadmin_id', 'id');
    }

    // POLYMORPHIC RELATION
    function addedUsers()
    {
        return $this->morphMany(User::class, 'added_by');
    }

    public function hasPermission($model, $action)
    {
        return $this->permissions->contains(function ($permission) use ($model, $action) {
            return $permission->permission->model === $model && $permission->permission->permission === $action;
        });
    }

    // ACCESSOR
    protected function image(): Attribute
    {
        return Attribute::make(
            fn ($value) => !empty($value)?asset('uploads/subadmin/images/'.$value):asset('assets/profile_pics/subadmin.png'),
        );
    }
}
