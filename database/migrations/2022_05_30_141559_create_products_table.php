<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->bigInteger('biller_id')->unsigned();
            $table->string('description')->nullable();
            $table->string('product_code')->nullable();
            $table->string('logo')->nullable();
            $table->bigInteger('product_category_id')->unsigned();
            $table->tinyInteger('has_validation')->nullable();
            $table->tinyInteger('enabled')->nullable();
            $table->tinyInteger('service_status')->nullable();
            $table->tinyInteger('deployed')->nullable();
            $table->float('min_amount')->nullable();
            $table->float('max_amount')->nullable();
            $table->string('commission_type')->nullable();
            $table->float('provider_commission_value')->nullable();
            $table->float('provider_commission_cap')->nullable();
            $table->float('provider_commission_amount_cap')->nullable();
            $table->float('integrator_commission_value')->nullable();
            $table->float('integrator_commission_cap')->nullable();
            $table->float('integrator_commission_amount_cap')->nullable();
            $table->tinyInteger('has_fee')->nullable();
            $table->text('fee_configuration')->nullable();
            // $table->string('source')->nullable();
            $table->string('type')->nullable();
            $table->string('implementation_code')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('biller_id')->references('id')->on('billers')->onDelete('cascade');
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
