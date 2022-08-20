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
        Schema::table('businesses', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
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
