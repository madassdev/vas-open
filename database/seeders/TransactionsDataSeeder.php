<?php

namespace Database\Seeders;

use App\Helpers\DBSwap;
use App\Models\Business;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionsDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DBSwap::setConnection('mysqltest');
        $business = Business::find(1);
        $transactions = $business->createDemoTransaction(100);
    }
}
