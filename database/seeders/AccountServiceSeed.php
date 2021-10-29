<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Service;
use Illuminate\Database\Seeder;

class AccountServiceSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $account = Account::create([
            'name'=>'Broobe',
            'description'=>'Broobe Account'
        ]);
        $service = Service::create([
            'name'=>'Mercado libre',
            'country_code' => 'AR',
            'client_id'=>'1004963915532502',
            'client_secret'=>'54z5lzdVeunz0yDF72I9k4PdLLYcxPlV',
            'currency_code'=>'ARS',
            'language_code'=>'es'
        ]);
        $services[$service->id] = ['token'=>'APP_USR-1004963915532502-070116-27c8c69cf0e0ff77df8dc5c393b95a44-298519686','refresh_token'=>'TG-60ba592f8e0a8200079ea1aa-298519686','status'=>1];

        $account->services()->sync($services);


    }
}
