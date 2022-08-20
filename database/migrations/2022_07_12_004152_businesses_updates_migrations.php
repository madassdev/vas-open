<?php

use App\Models\Business;
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
        //
        $role = Role::whereName(sc('BUSINESS_ADMIN_ROLE'))->first();
        Business::all()->map(function ($business) use ($role) {
            $users = $business->users->pluck('id');
            $business_user = $business->businessUsers()
                ->syncWithPivotValues($users, [
                    "is_active" => true,
                    "role_id" => $role->id
                ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
