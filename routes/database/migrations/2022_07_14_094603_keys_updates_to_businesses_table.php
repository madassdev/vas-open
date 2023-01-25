<?php

use App\Models\Business;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('businesses', function (Blueprint $table) {
            //
        });
        Business::all()->map(function ($business) {
            $business->test_api_key = strtoupper("ak_test_" . md5(str()->uuid()));
            $business->live_api_key = strtoupper("ak_live_" . md5(str()->uuid()));
            $business->test_secret_key = strtoupper("sk_test_" . md5(str()->uuid()));
            $business->live_secret_key = strtoupper("sk_live_" . md5(str()->uuid()));
            $business->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('businesses', function (Blueprint $table) {
            //
        });
    }
};
