<?php

namespace Database\Seeders;

use App\Helpers\DBSwap;
use App\Models\Business;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateBusinessKeysOnTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $businesses = Business::all();
        DBSwap::setConnection('mysqltest');

        $businesses->map(function($business){
            Business::whereEmail($business->email)->update([
            "test_api_key" => $business->test_api_key,
            "live_api_key" => $business->live_api_key,
            "test_secret_key" => $business->test_secret_key,
            "live_secret_key" => $business->live_secret_key,
            ]);
        });

    }
}
