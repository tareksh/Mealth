<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'country_name',
        'currency_name',
        'currency_symbol',
        'exchange_rate',
    ];

}
