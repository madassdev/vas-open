<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Biller;
use App\Models\Wallet;
use App\Models\Invitee;
use App\Models\Product;
use App\Models\Business;
use App\Models\BusinessBank;
use App\Models\WalletLog;
use App\Models\Transaction;
use App\Models\WalletSplit;
use App\Models\BusinessProduct;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use App\Models\BusinessCategory;
use App\Models\BusinessDirector;
use App\Models\BusinessDocument;
use App\Models\TransactionExtra;
use Database\Seeders\RoleSeeder;
use App\Models\WalletTransaction;
use Database\Factories\RoleFactory;
use Database\Seeders\BillerSeeder;
use Database\Seeders\ProductCategoriesSeeder;
use Database\Seeders\BusinessCategoriesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BillerSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ProductCategoriesSeeder::class);
        $this->call(BusinessCategoriesSeeder::class);
        // $billers = Biller::factory()->count(5)->create();
        $product_categories = ProductCategory::all();
        foreach ($product_categories as $product_category) {
            $product_category->products()->saveMany(Product::factory()->count(2)->make());
        }
        $business_categories = BusinessCategory::take(2)->get();
        foreach ($business_categories as $business_category) {
            $business_category->businesses()->saveMany(Business::factory()->count(2)->make());
        }
        // create 50 businesses
        $businesses = Business::all();
        foreach ($businesses as $business) {
            // foreach business create directors, documents and products
            $business->directors()->saveMany(BusinessDirector::factory()->count(2)->make());
            $business->documents()->saveMany(BusinessDocument::factory()->count(2)->make());
            $business->products()->saveMany(BusinessProduct::factory()->count(2)->make());
            $business->wallet()->save(Wallet::factory()->make());
            $business->users()->saveMany(User::factory()->count(1)->make());
            $business->invitees()->saveMany(Invitee::factory()->count(2)->make());
            $business->banks()->saveMany(BusinessBank::factory()->count(1)->make());
        }

        $transactions =  Transaction::factory()->count(3)->create();
        foreach ($transactions as $transaction) {
            $transaction->extra()->save(TransactionExtra::factory()->make());
        }
        $wallets = Wallet::all();
        foreach ($wallets as $wallet) {
            // foreach wallet create transactions
            $wallet->transactions()->saveMany(WalletTransaction::factory()->count(5)->make());
            $wallet->splits()->saveMany(WalletSplit::factory()->count(5)->make());
            $wallet->logs()->saveMany(WalletLog::factory()->count(5)->make());
        }
        // create 20 accounts
        // create 50 billers
        // create 50 transactions


    }
}
