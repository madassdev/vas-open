<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions_extras', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('transaction_id')->index()->nullable();
            $table->integer('request_type')->nullable();
            $table->text('business_headers')->nullable();
            $table->text('business_body')->nullable();
            $table->text('provider_request')->nullable();
            $table->text('provider_response')->nullable();
            $table->text('commission_configuration')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('business_response')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions_extras');
    }
}
