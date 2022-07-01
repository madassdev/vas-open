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
        Schema::table('business_documents', function (Blueprint $table) {
            //
            $table->string('director_1')->nullable();
            $table->string('director_2')->nullable();
            $table->string('director_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_documents', function (Blueprint $table) {
            //
        });
    }
};
