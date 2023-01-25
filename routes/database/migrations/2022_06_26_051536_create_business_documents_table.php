<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'business_documents',
            function (Blueprint $table) {
                $table->id();
                $table->bigInteger('business_id')->unsigned();
                $table->string('cac_2')->nullable();
                $table->string('cac_7')->nullable();
                $table->string('certificate')->nullable();
                $table->string('company_profile')->nullable();
                $table->string('board_resolution')->nullable();
                $table->string('memo_article')->nullable();
                $table->string('share_allotment')->nullable();
                $table->string('director_1')->nullable();
                $table->string('director_2')->nullable();
                $table->string('director_3')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            }
        );

        Schema::table('business_documents', function (Blueprint $table) {
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_documents');
    }
}
