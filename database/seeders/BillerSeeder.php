<?php

namespace Database\Seeders;

use App\Models\Biller;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $billers = collect([
            [
                "name" => "MTN",
                "shortname" => "mtn",
                "logo" => "https://img/logo_url",
                "enabled" => true
            ],
            [
                "name" => "Glo",
                "shortname" => "glo",
                "logo" => "https://img/logo_url",
                "enabled" => true
            ],
            [
                "name" => "Airtel",
                "shortname" => "airtel",
                "logo" => "https://img/logo_url",
                "enabled" => true
            ],
            [
                "name" => "9 Mobile",
                "shortname" => "9mobile",
                "logo" => "https://img/logo_url",
                "enabled" => true
            ]
        ]);
        $billers->map(function ($biller) {
            Biller::updateOrCreate(["name" => $biller["name"]], $biller);
        });
    }
}
