<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Biller;
use App\Models\Wallet;
use App\Models\Invitee;
use App\Models\Product;
use App\Models\Business;
use App\Models\WalletLog;
use App\Models\Transaction;
use App\Models\WalletSplit;
use App\Models\BusinessBank;
use App\Models\BusinessProduct;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use App\Models\BusinessCategory;
use App\Models\BusinessDirector;
use App\Models\BusinessDocument;
use App\Models\TransactionExtra;
use App\Models\WalletTransaction;
use Spatie\Permission\Models\Role;
use Database\Factories\RoleFactory;

class ExtraSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $wallets = Wallet::all();
        foreach ($wallets as $wallet) {
            // foreach wallet create transactions
            $wallet->transactions()->saveMany(WalletTransaction::factory()->count(10)->make());
            $wallet->splits()->saveMany(WalletSplit::factory()->count(10)->make());
            $wallet->logs()->saveMany(WalletLog::factory()->count(10)->make());
        }
    }
}
