<?php

namespace App\Models;

use App\Helpers\DBSwap;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Invitee;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\BusinessBank;
use App\Models\BusinessProduct;
use App\Models\BusinessDirector;
use App\Models\BusinessDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Business extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        "live_enabled" => "boolean",
        "enabled" => "boolean",
    ];


    public function documents()
    {
        return $this->hasMany(BusinessDocument::class);
    }


    public function directors()
    {
        return $this->hasMany(BusinessDirector::class);
    }

    public function businessProducts()
    {
        return $this->belongsToMany(BusinessProduct::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'business_products');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function businessUsers()
    {
        return $this->belongsToMany(User::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function businessDocument()
    {
        return $this->hasOne(BusinessDocument::class);
    }

    public function businessBank()
    {
        return $this->hasOne(BusinessBank::class);
    }

    public function createWallet()
    {
        $wallet = $this->wallet;
        if (!$wallet) {
            $this->wallet()->create([
                "main_balance" => 0,
                "main_locked" => 0,
                "commission_balance" => 0,
                "commission_locked" => 0,
            ]);
        }
    }

    public function createDummyAccount($type = "live")
    {
        if ($type === "live") {
            $bank = $this->businessBank()->create([
                "bankname" => "First Bank",
                "account_number" => "000000000"
            ]);
            return $bank;
        }
        $bank = $this->businessBank()->create([
            "bankname" => "Access Bank",
            "account_number" => "000000000"
        ]);
    }


    public function createDemoTransaction($count = 1)
    {
        $payment_status = ["success", "success", "success", "pending", "failed"];
        $tx = [];
        // $bp = $this->products()->count();
        // echo($bp);
        // return;
        $product_ids =Product::inRandomOrder()->take(5)->get()->pluck('id')->toArray();
        
        for ($i = 0; $i < $count; $i++) {
            # code...
            $status = $payment_status[array_rand($payment_status)];
            $carbon = Carbon::now();
            $created_at = rand(0, 1) ? $carbon : (rand(0, 1) ? $carbon->subDays(rand(0, 10)) : $carbon->addDays(rand(0, 8)));
            $product = $this->products()->inRandomOrder()->first();
            $t = new Transaction();
            $t->product_id = $product->id;
            $t->business_id = $this->id;
            $t->idempotency_hash = md5(str()->random(12));
            $t->amount = $product->max_amount;
            // $t->amount = rand(0,50)*100 + rand(0,50)*10 + rand(0,50);
            $t->business_reference = strtoupper(str()->random(12));
            $t->transaction_reference = strtoupper(str()->random(12));
            $t->provider_reference = strtoupper(str()->random(12));
            $t->debit_reference = strtoupper(str()->random(12));
            $t->debited_amount = $t->amount;
            $t->payment_status = $status;
            $t->value_given = rand(0, 1);
            $t->transaction_status = $t->payment_status;
            $t->phone_number = $this->phone;
            $t->account_number = $this->phone;
            $t->provider_message = $status;
            $t->status_code = 200;
            $t->status_message = "Status Message";
            $t->product_price = $product->max_amount;
            $t->fee = rand(0, 20);
            $t->integrator_commission = rand(0, 20);
            $t->owner_commission = rand(0, 50);
            $t->created_at = $created_at;
            $t->save(['timestamps' => false]);
            $tx[] = $t;
        }
        return $tx;
    }

    public function invitees()
    {
        return $this->hasMany(Invitee::class);
    }

    public function banks()
    {
        return $this->hasMany(BusinessBank::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function moveToTestDb()
    {
        $user = $this->user;
        $business = $this;
        DBSwap::setConnection('mysqltest');
        $test_business = Business::updateOrCreate([
            "email" => $business->business_email,
        ], [
            "name" => $business->business_name,
            "email" => $business->business_email.'nnn',
            "phone" => $business->business_phone_number,
            "address" => $business->business_address,
            "current_env" => "test",
            "test_api_key" => $business->test_api_key,
            "live_enabled" => true,
            "business_category_id" => $business->business_category_id,
        ]);

        return $test_business;
        $test_business->createDummyAccount();
        $test_business->createWallet();
        // Create User
        $test_user = User::updateOrCreate([
            "email" => $user->email,
        ], [
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "email" => $user->email,
            "phone" => $user->phone_number,
            "business_id" => $test_business->id,
            "password" => $user->password,
            "verification_code" => $user->password,
            "verified" => false,
        ]);

        $test_role = Role::whereName('business_super_admin')->first();
        // Attach business to user
        $test_user->businesses()->attach($test_business->id, ["is_active" => true, "role_id" => $test_role->id]);

        // Assign role to user 
        $test_user->assignRole('business_super_admin');

    }
}
