<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('business_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            
            $table->double('amount')->nullable();
            $table->double('integrator_debited_amount')->nullable();
            $table->double('provider_debited_amount')->nullable();
            
            $table->string('idempotency_hash')->unique()->nullable();
            $table->string('business_reference')->nullable();
            $table->string('debit_reference')->nullable();
            $table->string('transaction_reference')->nullable();
            $table->string('provider_reference')->nullable();
            $table->double('debited_amount')->nullable();
            
            $table->decimal('product_price')->nullable();
            $table->decimal('fee')->nullable();
            $table->decimal('integrator_commission')->nullable();
            $table->decimal('owner_commission')->nullable();
            
            $table->string('account_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->tinyInteger('value_given')->nullable();
            
            $table->string('transaction_status')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('status_code')->nullable();
            $table->string('status_message')->nullable();
            $table->text('provider_message')->nullable();
            $table->tinyInteger('retries')->nullable();
            $table->text('narration')->nullable();
            
            // $table->tinyInteger('is_settled')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->index('created_at','tx.created_at');
            $table->unique(['business_id', 'business_reference']);

        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
