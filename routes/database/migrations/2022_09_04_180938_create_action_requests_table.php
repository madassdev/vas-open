<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roles = collect([
            [
                "name" => "action_maker",
                "guard_name" => "web",
                "readable_name" => "Action Maker",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "action_checker",
                "guard_name" => "web",
                "readable_name" => "Action Checker",
                "description" => null,
                "is_admin" => true
            ],
        ]);

        $roles->map(function ($r) {
            Role::updateOrCreate(
                ["name" => $r["name"]],
                $r
            );
        });
        Schema::create('action_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('maker_id')->unsigned();
            $table->bigInteger('checker_id')->unsigned()->nullable();
            $table->text('payload')->nullable();
            $table->text('handler')->nullable();
            $table->text('initial_data')->nullable();
            $table->text('final_data')->nullable();
            $table->string('status')->default('pending');
            $table->timestamp('treated_at')->nullable();
            $table->timestamps();
            $table->foreign('maker_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('checker_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('action_requests');
    }
};
