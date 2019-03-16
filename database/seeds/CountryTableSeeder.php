<?php

use App\Country;
use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Country::create
        ([
            'country_name'=>'syria',
            'currency_name'=>'Syrian Pound',
            'currency_symbol'=>'SP',
            'exchange_rate'=>33,

        ]);

        Country::create
        ([
            'country_name'=>'Lebanon',
            'currency_name'=>'Lebanon Pound',
            'currency_symbol'=>'LP',
            'exchange_rate'=>33,

        ]);


    }
}
