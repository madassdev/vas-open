<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('shortname')->nullable();
            $table->string('vendor_code')->nullable();
            $table->string('status')->nullable();
            $table->string('logo')->nullable();
            $table->tinyInteger('enabled')->nullable();
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
        Schema::dropIfExists('billers');
    }
}
