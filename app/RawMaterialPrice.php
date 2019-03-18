<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RawMaterialPrice extends Model
{
    protected $fillable = [
        'raw_material_id',
        'country_id',
        'price'
    ];
}
