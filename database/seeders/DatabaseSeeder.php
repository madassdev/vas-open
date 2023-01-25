<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Biller;
use App\Models\Wallet;
use App\Models\Invitee;
use App\Models\Product;
use App\Models\Business;
use App\Models\WalletLog;
use App\Models\SubProduct;
use App\Models\Transaction;
use App\Models\WalletSplit;
use Illuminate\Support\Str;
use App\Models\BusinessBank;
use App\Models\BusinessProduct;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use App\Models\BusinessCategory;
use App\Models\BusinessDirector;
use App\Models\BusinessDocument;
use App\Models\TransactionExtra;
use Database\Seeders\RoleSeeder;
use App\Models\WalletTransaction;
use Database\Seeders\BillerSeeder;
use Database\Factories\RoleFactory;
use Database\Seeders\DevUsersSeeder;
use Database\Seeders\UpBusinessSeeder;
use Illuminate\Support\Facades\Artisan;
use Database\Seeders\LiveProductsSeeder;
use Database\Seeders\GloSubProductSeeder;
use Database\Seeders\MTNSubProductSeeder;
use Database\Seeders\SandboxProductsSeeder;
use Database\Seeders\AirtelSubProductSeeder;
use Database\Seeders\TransactionExtraSeeder;
use Database\Seeders\ProductCategoriesSeeder;
use Database\Seeders\BusinessCategoriesSeeder;
use Database\Seeders\NineMobileSubProductSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        // Artisan::call('permissions:sync');
        $this->call(BillerSeeder::class);
        $this->call(ProductCategoriesSeeder::class);
        $this->call(BusinessCategoriesSeeder::class);
        config('database.default') == 'mysqltest' ? $this->call(SandboxProductsSeeder::class) : $this->call(LiveProductsSeeder::class);
        #region
        // 1290,Africard
        // 300051,AKIRS
        // 200155,AkirsRevenueCode
        // 200274,AKWAGIS
        // 302294,AXAMANSARD
        // 301024,COAWurno
        // 302295,Cornerstone
        // 200139,CyberSpace
        // 09990,DSTV1
        // 300404,EKEDCOrderId

        // 12675,FAAN
        // 200214,FAANNaira
        // 301087,FcmbPFA
        // 300052,FRSC
        // 1081,GNLD
        // 9991,GOTV
        // 099910,GOTV1
        // 300122,Gtp
        // 200018,IBDCPostpaid
        // 200017,IBDCPrepaid


        // 1522,Innovate1
        // 301069,KadunaElectricPrepaid
        // 200209,Kwara
        // 301149,LASU
        // 520135,LCC
        // 302283,LSHS
        // 301023,MuhammaduMaccido
        // 300053,NIS
        // 300183,PayGateNoReference
        // 300140,PayGateReference
        // 1000,PHEDCPostpaid
        // 100012,PHEDCPrepaid
        // 200182,PlateDetect
        // 301691,RoyalExchange
        // 301015,SAbdulrahamanCofHTech
        // 300162,ShehuShagariCoED
        // 5153,SmileAirtime
        // 302108,SokotoCodeBilling
        // 301025,SokotoCollegeNursingScienceSokokoto
        // 302138,SokotoDirectBilling
        // 301011,SokotoStateUniversity
        // 5247,STARTIMES2
        // 12708,TSAGateway
        // 300124,UBAPrepaid
        // 300135,UmaruShinkafi
        // 301078,Veritas
        // 520153,VisaOnArrival
        // 12680,WAEC
        #endregion
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
            $business->products()->saveMany(BusinessProduct::factory()->count(1)->make());
            $business->wallet()->save(Wallet::factory()->make());
            $business->users()->saveMany(User::factory()->count(1)->make());
            $business->invitees()->saveMany(Invitee::factory()->count(2)->make());
            $business->banks()->saveMany(BusinessBank::factory()->count(1)->make());
        }

        Transaction::factory()->count(1)->create();
        // foreach ($transactions as $transaction) {
        //     $transaction->extra()->save(TransactionExtra::factory()->make());
        // }
        // $wallets = Wallet::all();
        // foreach ($wallets as $wallet) {
        //     // foreach wallet create transactions
        //     // $wallet->transactions()->saveMany(WalletTransaction::factory()->count(5)->make());
        //     $wallet->splits()->saveMany(WalletSplit::factory()->count(5)->make());
        //     $wallet->logs()->saveMany(WalletLog::factory()->count(5)->make());
        // }

        $this->call(DevUsersSeeder::class);
        $this->call(UpBusinessSeeder::class);
        $this->call(MTNSubProductSeeder::class);
        $this->call(GloSubProductSeeder::class);
        $this->call(AirtelSubProductSeeder::class);
        $this->call(NineMobileSubProductSeeder::class);
        // $this->call(TransactionExtraSeeder::class);
        $this->call(DSTVSeeder::class);
        $this->call(GotvSeeder::class);
        $this->call(StartimesSeeder::class);
        // all electricity products should have min amount of 900
        


    }
}
