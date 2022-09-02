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
                "enabled" => true,
                "vendor_code" => "12682",
                "id" => 1,
            ],
            [
                "name" => "Glo",
                "shortname" => "glo",
                "logo" => "https://img/logo_url",
                "enabled" => true,
                "vendor_code" => "12699",
                "id" => 2,
            ],
            [
                "name" => "Airtel",
                "shortname" => "airtel",
                "logo" => "https://img/logo_url",
                "enabled" => true,
                "vendor_code" => "2347087214896",
                "id" => 3,
            ],
            [
                "name" => "9 Mobile",
                "shortname" => "9mobile",
                "logo" => "https://img/logo_url",
                "enabled" => true,
                "vendor_code" => "12700",
                "id" => 4,
            ],
            [
                "name" => "EKO ELECTRICITY",
                "shortname" => "eko-electricity",
                "logo" => "https://img/logo_url",
                "enabled" => true,
                "vendor_code" => "716",
                "id" => 5,
            ],
            [
                "name" => "PORT HARCOURT ELECTRICITY",
                "shortname" => "ph-electricity",
                "logo" => "https://img/logo_url",
                "enabled" => true,
                "vendor_code" => "817",
                "id" => 6,
            ],
            [
                "name" => "KADUNA ELECTRICITY",
                "shortname" => "ph-electricity",
                "logo" => "https://img/logo_url",
                "enabled" => true,
                "vendor_code" => "3264",
                "id" => 7,
            ],
            [
                "name" => "IBADAN ELECTRICITY",
                "shortname" => "ibadan-electricity",
                "logo" => "https://img/logo_url",
                "enabled" => true,
                "vendor_code" => "12684",
                "id" => 8,
            ],
            [
                "name" => "IKEJA ELECTRICITY",
                "shortname" => "ikeja-electricity",
                "logo" => "https://img/logo_url",
                "enabled" => true,
                "vendor_code" => "12697",
                "id" => 9,
            ],
            [
                "name" => "ABUJA ELECTRICITY",
                "shortname" => "abuja-electricity",
                "logo" => "https://img/logo_url",
                "enabled" => true,
                "vendor_code" => "3322",
                "id" => 10,
            ],
            [
                "name" => "JOS ELECTRICITY",
                "shortname" => "jos-electricity",
                "logo" => "https://img/logo_url",
                "enabled" => true,
                "vendor_code" => "3663",
                "id" => 11,
            ],
            [
                "name" => "BENIN ELECTRICITY",
                "shortname" => "benin-electricity",
                "logo" => "https://img/logo_url",
                "enabled" => true,
                "vendor_code" => "200017",
                "id" => 12,
            ]
        ]);
        $billers->map(function ($biller) {
            Biller::updateOrCreate(["name" => $biller["name"]], $biller);
        });
    }
}
