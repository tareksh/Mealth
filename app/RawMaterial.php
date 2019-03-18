<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    public $timestamps = false;

    protected $fillable = [
         'name'
    ];
}
