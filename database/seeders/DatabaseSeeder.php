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
        // foreach ($product_categories as $product_category) {
        //     $product_category->products()->saveMany(Product::factory()->count(2)->make());
        // }
        $products =  [
            [
                'name' => '9mobile',
                'shortname' => '9mobile',
            ],
            [
                'name' => 'Abuja Electricty Distribution Company Postpaid',
                'shortname' => 'AEDC-Postpaid',
            ],
            [
                'name' => 'Abuja Electricty Distribution Company Prepaid',
                'shortname' => 'AEDC-Prepaid',
            ],
            [
                'name' => 'Aiico Motor Insurance',
                'shortname' => 'AiicoMotorInsurance',
            ],
            [
                'name' => 'Airtel',
                'shortname' => 'Airtel',
            ],
            [
                'name' => 'Akwa Ibom Internal Revenue Services',
                'shortname' => 'AIIRS',
            ],
            [
                'name' => 'Bayelsa Internal Revenue Service',
                'shortname' => 'BIRS',
            ],
            [
                'name' => 'Benin Electricty Distribution Company Postpaid',
                'shortname' => 'BEDC-Postpaid',
            ],
            [
                'name' => 'Benin Electricty Distribution Company Prepaid',
                'shortname' => 'BEDC-Prepaid',
            ],
            [
                'name' => 'College of Agriculture Wurno',
                'shortname' => 'CAGW',
            ],
            [
                'name' => 'CollegeBasicRemedialStudies',
                'shortname' => 'CBR',
            ],
            [
                'name' => 'College of Legal Islamic Studies',
                'shortname' => 'COLIS',
            ],
            [
                'name' => 'College of Nursing Science Sokoto',
                'shortname' => 'CNCS',
            ],
            [
                'name' => 'Consolidated',
                'shortname' => 'Consolidated',
            ],
            [
                'name' => 'CyberSpace',
                'shortname' => 'CyberSpace',
            ],
            [
                'name' => 'DSTV',
                'shortname' => 'DSTV',
            ],
            [
                'name' => 'EKEDC Postpaid',
                'shortname' => 'EKEDC-Postpaid',
            ],
            [
                'name' => 'EKEDC Prepaid',
                'shortname' => 'EKEDC-Prepaid',
            ],
            [
                'name' => 'FCMB Pension Fund Administrator',
                'shortname' => 'FCMB-PFA',
            ],
            [
                'name' => 'FRSC',
                'shortname' => 'FRSC',
            ],
            [
                'name' => 'GLO',
                'shortname' => 'GLO',
            ],
            [
                'name' => 'GOTV',
                'shortname' => 'GOTV',
            ],
            [
                'name' => 'Ibadan Electricity Distribution Company Postpaid',
                'shortname' => 'IEDC-Postpaid',
            ],
            [
                'name' => 'Ibadan Electricity Distribution Company Prepaid',
                'shortname' => 'IEDC-Prepaid',
            ],
            [
                'name' => 'IKEDC Postpaid',
                'shortname' => 'IKEDC-Postpaid',
            ],
            [
                'name' => 'IKEDC Prepaid',
                'shortname' => 'IKEDC-Prepaid',
            ],
            [
                'name' => 'JambEpin',
                'shortname' => 'JambEpin',
            ],
            [
                'name' => 'JambReference',
                'shortname' => 'JambReference',
            ],
            [
                'name' => 'Jos Electricty Distribution Company Postpaid',
                'shortname' => 'JEDC-Postpaid',
            ],
            [
                'name' => 'Jos Electricty Distribution Company Prepaid',
                'shortname' => 'JEDC-Prepaid',
            ],
            [
                'name' => 'Kaduna Electricty Distribution Company Prepaid',
                'shortname' => 'KEDC-Prepaid',
            ],
            [
                'name' => 'LCC',
                'shortname' => 'LCC',
            ],
            [
                'name' => 'LASHMA',
                'shortname' => 'LASHMA',
            ],
            [
                'name' => 'MTN',
                'shortname' => 'MTN',
            ],
            [
                'name' => 'Sultan Muhammadu Maccido Institute for Qur\'an and General Studies',
                'shortname' => 'SMMCIS',
            ],
            [
                'name'  => 'Nigeria Immigration Service',
                'shortname' => 'NIS',
            ],
            [
                'name' => 'Portharcourt Electricty Distribution Company Postpaid',
                'shortname' => 'PEDC-Postpaid',
            ],
            [
                'name' => 'Portharcourt Electricty Distribution Company Prepaid',
                'shortname' => 'PEDC-Prepaid',
            ],
            [
                'name' => 'RoyalExchange Insurance',
                'shortname' => 'RoyalExchangeInsurance',
            ],
            [
                'name' => 'Sultan Abdulrahaman College of Health Technology',
                'shortname' => 'SACHT',
            ],
            [
                'name' => 'Shehu Shagari College of Education',
                'shortname' => 'SSCE',
            ],
            [
                'name' => 'Smile Bundle',
                'shortname' => 'SmileBundle',
            ],
            [
                'name' => 'Sokoto College of Nursing Science',
                'shortname' => 'SNCS',
            ],
            [
                'name' => 'Sokoto E-tax',
                'shortname' => 'SET',
            ],
            [
                'name' => 'Sokoto State University',
                'shortname' => 'SSU',
            ],
            [
                'name' => 'Spectranet',
                'shortname' => 'Spectranet',
            ],
            [
                'name' => 'STARTIMES',
                'shortname' => 'STARTIMES',
            ],
            [
                'name' => 'Swift',
                'shortname' => 'Swift',
            ],
            [
                'name' => 'Umaru Shinkafi College of Education',
                'shortname' => 'USCE',
            ],
            [
                'name' => 'Veritas Pension Fund Administrator',
                'shortname' => 'VPFA',
            ],
            [
                'name' => 'Waec PIN Service',
                'shortname' => 'WPS',
            ],
            [
                'name' => 'Waec Token Service',
                'shortname' => 'WTS',
            ],
            [
                'name' => 'Wakanow',
                'shortname' => 'Wakanow',
            ],
            [
                'name' => 'Zamtel',
                'shortname' => 'Zamtel',
            ],

        ];
        foreach ($products as $product) {
            Product::factory()->make([
                'name' => $product['name'],
                'shortname' => $product['shortname'],
            ])->save();
        }
        $business_categories = BusinessCategory::take(2)->get();
        foreach ($business_categories as $business_category) {
            $business_category->businesses()->saveMany(Business::factory()->count(1)->make());
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

        $this->call(DevUsersSeeder::class);
        // create 20 accounts
        // create 50 billers
        // create 50 transactions


    }
}
