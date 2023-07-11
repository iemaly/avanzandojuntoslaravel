<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CareHomeMedia extends Model
{
    use HasFactory;

    // RELATIONS

    public function carehome()
    {
        return $this->belongsTo(CareHome::class, 'carehome_id', 'id');
    }

    // ACCESSOR
    protected function document(): Attribute
    {
        return Attribute::make(
            fn ($value) => !empty($value)?asset($value):'',
        );
    }
}
