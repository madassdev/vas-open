<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewBusinessWalletSeeder extends Seeder
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
        $businesses->map(function($business){
            $business->createWallet();
        });
    }
}
