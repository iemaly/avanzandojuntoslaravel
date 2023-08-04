<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Admin extends Authenticatable
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
        'access_token',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'access_token',
        'remember_token',
        'reset_token',
        'auth_token',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    private function adminExists($email, $type)
    {
        switch ($type) 
        {
            case 'carehome':
                $carehome =  CareHome::where('email',$email)->exists();
                if($carehome) return ['status'=>true, 'role'=>'carehome'];
                break;
            case 'user':
                $user =  User::where('email',$email)->exists();
                if($user) return ['status'=>true, 'role'=>'user'];
                break;
            case 'professional':
                $professional =  Professional::whereEmail($email)->exists();
                if($professional) return ['status'=>true, 'role'=>'professional'];
                break;
            case 'subadmin':
                $subadmin =  Subadmin::where('email',$email)->exists();
                if($subadmin) return ['status'=>true, 'role'=>'subadmin'];
            break;
            case 'business':
                $business =  Business::where('email',$email)->exists();
                if($business) return ['status'=>true, 'role'=>'business'];
                break;
            case 'admin':
                $admin = $this->whereEmail($email)->exists();
                if($admin) return ['status'=>true, 'role'=>'admin'];
                break;
            
            default:
                return false;
            break;
        }
    }

    private function adminByTokenExists($token)
    {
        $admin =  $this->where('reset_token' , $token);
        if ($admin->exists()) return $admin->first()->id;
        return false;
    }

    public function login($email, $password, $type)
    {
        $recordExists = $this->adminExists($email, $type);
        if (!$recordExists) return ['status'=>404]; 
        $attempt = auth($recordExists['role'])->attempt(['email' => $email, 'password' => $password]);
        return ['status'=>true, 'role'=>$recordExists['role'], 'attempt'=>$attempt];
    }

    function emailVerified($type,$id) : bool
    {
        switch ($type) {
            case 'user':
                $user = User::find($id);
                if(!$user->email_verified) return false;
                return true;
                break;
            case 'professional':
                $professional = Professional::find($id);
                if(!$professional->email_verified) return false;
                return true;
                break;
            case 'business':
                $business = Business::find($id);
                if(!$business->email_verified) return false;
                return true;
                break;
            default:
                return false;
                break;
        }
    }

    public function checkSubadminApproveStatus($id) : bool
    {
        $subadmin = Subadmin::find($id);
        if(!$subadmin->status) return false;
        return true;
    }

    public function checkUserApproveStatus($id) : bool
    {
        $user = User::find($id);
        if(!$user->status) return false;
        return true;
    }

    public function checkCarehomeApproveStatus($id) : bool
    {
        $carehome = CareHome::find($id);
        if(!$carehome->status) return false;
        return true;
    }

    public function checkProfessionalApproveStatus($id) : bool
    {
        $professional = Professional::find($id);
        if(!$professional->status) return false;
        return true;
    }

    public function checkBusinessApproveStatus($id) : bool
    {
        $business = Business::find($id);
        if(!$business->status) return false;
        return true;
    }

    public function setResetToken($email, $token, $type)
    {
        if ($this->adminExists($email, $type)) return $this->whereEmail($email)->update(['reset_token' => $token]);
    }

    public function resetPassword($token, $password)
    {
        $admin = $this->adminByTokenExists($token);
        if (!$admin) return false;

        $admin = $this->find($admin);
        $admin->reset_token = null;
        $admin->password = bcrypt($password);
        return $admin->update();
    }

    public function changeStatus($id)
    {
        $subadmin = Subadmin::find($id);
        if($subadmin->status==1) 
        {
            $subadmin->update(['status'=>0]);
            return 0;
        }
        $subadmin->update(['status'=>1]);
        return 1;
    }

    static function permission($model, $slug, $subadmin)
    {
        $user = auth()->user();
        if(!empty($user) && $user->getTable() == 'subadmins')
        {
            $permission = Permission::where(['model'=>$model, 'permission'=>$slug])->first();
            $permission = RolePermission::where(['subadmin_id'=>$subadmin, 'permission_id'=>$permission->id])->exists();
            if(!$permission) return ['status'=>false, 'error'=>'Unauthorized'];
        }
        return ['status'=>true];
    }

    // POLYMORPHIC RELATION
    function addedUsers()
    {
        return $this->morphMany(User::class, 'added_by');
    }

    // RELATIONS

    // ACCESSOR
    protected function image(): Attribute
    {
        return Attribute::make(
            fn ($value) => !empty($value)?asset($value):asset('assets/profile_pics/admin.jpg'),
        );
    }
}
