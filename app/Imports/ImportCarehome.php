<?php

namespace App\Imports;

use App\Models\CareHome;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportCarehome implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // VALIDATION
        Validator::make($row, [
            'establishment' => 'nullable',
            'director' => 'nullable',
            'address' => 'nullable',
            'town' => 'nullable',
            'telephone' => 'nullable',
            // 'email' => 'nullable|unique:care_homes,email',
            'email' => 'nullable',
            'license' => 'nullable',
            'license_status' => 'nullable',
            'ability' => 'nullable',
        ])->validate();

        $careHome = CareHome::where('email', $row['email'])->first();
        if($careHome!=null) $careHome->update($row);
        else CareHome::create($row);
    }
}
