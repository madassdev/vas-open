<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletSplitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_splits', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('transaction_id')->index()->nullable();
            $table->unsignedInteger('wallet_transaction_id')->index()->nullable();
            $table->unsignedInteger('wallet_id')->nullable();
            $table->integer('wallet_type')->nullable();
            $table->integer('transaction_type')->nullable();
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
        Schema::dropIfExists('wallet_splits');
    }
}
