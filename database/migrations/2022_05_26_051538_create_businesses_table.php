<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('logo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->tinyInteger('enabled')->nullable();
            $table->string('current_env')->nullable();
            $table->string('live_api_key')->nullable();
            $table->string('test_api_key')->nullable();
            $table->string('live_secret_key')->nullable();
            $table->string('test_secret_key')->nullable();
            $table->double('low_balance_threshold')->default(0);
            $table->string('webhook')->nullable();
            $table->string('website')->nullable();
            $table->bigInteger('business_category_id')->unsigned();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('account_number')->nullable();
            $table->tinyInteger('document_verified')->nullable();
            $table->tinyInteger('live_enabled')->nullable();
            $table->text('ip_addresses')->nullable();
            $table->string('balance_notification_recipients')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::table('businesses', function (Blueprint $table) {
            $table->foreign('business_category_id')->references('id')->on('business_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
}
