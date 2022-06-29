<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('account_id')->index()->nullable();
            $table->unsignedBigInteger('transaction_id')->index()->nullable();
            $table->decimal('prev_balance');
            $table->decimal('amount');
            $table->decimal('new_balance');
            $table->string('description')->nullable();
            $table->string('entry_type')->nullable();
            $table->tinyInteger('wallet_type')->nullable();
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
        Schema::dropIfExists('wallet_logs');
    }
}
