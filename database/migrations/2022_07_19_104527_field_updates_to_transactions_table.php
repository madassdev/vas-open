<?php

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
        Schema::table('transactions', function (Blueprint $table) {
            $table->text('provider_message')->nullable();
            $table->string('provider_reference')->nullable();
            $table->string('transaction_reference')->nullable();
            $table->renameColumn('value_number', 'account_number');
        });
        Schema::table('products', function (Blueprint $table) {
            //
            $table->float('unit_cost')->nullable();
            $table->string('shortname')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};
