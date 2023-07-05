<?php

namespace App\Models;

use App\Imports\ImportCarehome;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class CareHome extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasFactory;

    // QUERIES
    public function import($sheet)
    {
        try {
            $excel = Excel::import(new ImportCarehome(), $sheet, null, \Maatwebsite\Excel\Excel::XLSX);
        } catch (\Throwable $th) {
            return ['status'=>false, 'error'=>$th->getMessage()];
        }
        return ['status'=>true];
    }

    // RELATIONS
    public function media()
    {
        return $this->hasMany(CareHomeMedia::class, 'carehome_id', 'id');
    }

    // ACCESSOR
    protected function image(): Attribute
    {
        return Attribute::make(
            fn ($value) => !empty($value)?asset($value):'',
        );
    }
}
