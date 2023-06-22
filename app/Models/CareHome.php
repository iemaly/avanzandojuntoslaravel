<?php

namespace App\Models;

use App\Imports\ImportCarehome;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;

class CareHome extends Model
{
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
}
