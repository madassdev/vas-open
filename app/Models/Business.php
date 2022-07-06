<?php

namespace App\Models;

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

class Business extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function documents()
    {
        return $this->hasMany(BusinessDocument::class);
    }


    public function directors()
    {
        return $this->hasMany(BusinessDirector::class);
    }

    public function products()
    {
        return $this->hasMany(BusinessProduct::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
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
        for ($i = 0; $i < $count; $i++) {
            # code...
            $carbon = Carbon::now();
            $created_at = rand(0, 1) ? $carbon : (rand(0, 1) ? $carbon->subDays(rand(0, 6)) : $carbon->addDays(rand(0, 6)));
            $product = $this->products()->inRandomOrder()->first();
            $t = new Transaction();
            $t->product_id = $product->id;
            $t->business_id = $this->id;
            $t->idempotency_hash = md5(str()->random(12));
            $t->amount = $product->max_amount;
            // $t->amount = rand(0,50)*100 + rand(0,50)*10 + rand(0,50);
            $t->business_reference = strtoupper(str()->random(12));
            $t->debit_reference = strtoupper(str()->random(12));
            $t->debited_amount = $t->amount;
            $t->payment_status = $payment_status[array_rand($payment_status)];
            $t->value_given = rand(0, 1);
            $t->transaction_status = $t->payment_status;
            $t->phone_number = $this->phone;
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
}
