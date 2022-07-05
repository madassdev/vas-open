<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsToMany(Product::class, 'business_products');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function businessDocument()
    {
        return $this->hasOne(BusinessDocument::class);
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
}
