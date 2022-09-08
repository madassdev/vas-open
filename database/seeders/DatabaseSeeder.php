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
use Illuminate\Support\Str;
use App\Models\BusinessBank;
use App\Models\BusinessProduct;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use App\Models\BusinessCategory;
use App\Models\BusinessDirector;
use App\Models\BusinessDocument;
use App\Models\SubProduct;
use App\Models\TransactionExtra;
use Database\Seeders\RoleSeeder;
use App\Models\WalletTransaction;
use Database\Seeders\BillerSeeder;
use Database\Factories\RoleFactory;
use Database\Seeders\DevUsersSeeder;
use Database\Seeders\UpBusinessSeeder;
use Illuminate\Support\Facades\Artisan;
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
        $this->call(RoleSeeder::class);
        // Artisan::call('permissions:sync');
        $this->call(BillerSeeder::class);
        $this->call(ProductCategoriesSeeder::class);
        $this->call(BusinessCategoriesSeeder::class);


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

        $products = config('database.default') == 'mysqltest' ? [
            [
                'name' => '9mobile',
                'shortname' => '9mobile',
                'product_category_id' => 1,
                'product_code' => '12700',
                'service_type' => '9mobile_airtime',
                'biller_id' => 4,
            ],
            [
                'name' => 'Abuja Electricty Distribution Company Postpaid',
                'shortname' => 'AEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '3300',
                'biller_id' => 10,
            ],
            [
                'name' => 'Abuja Electricty Distribution Company Prepaid',
                'shortname' => 'AEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '3322',
                'biller_id' => 10,
            ],
            [
                'name' => 'Aiico Motor Insurance',
                'shortname' => 'AiicoMotorInsurance',
                'product_category_id' => 7,
            ],
            [
                'name' => 'Airtel',
                'shortname' => 'Airtel',
                'product_category_id' => 1,
                'product_code' => '2347087214896',
                'service_type' => 'airtel_airtime',
                'biller_id' => 3,
            ],
            [
                'name' => 'Akwa Ibom Internal Revenue Services',
                'shortname' => 'AIIRS',
                'product_category_id' => 7,
            ],
            [
                'name' => 'Bayelsa Internal Revenue Service',
                'shortname' => 'BIRS',
                'product_category_id' => 7,
            ],
            [
                'name' => 'Benin Electricty Distribution Company Postpaid',
                'shortname' => 'BEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '3355',
                'biller_id' => 12
            ],
            [
                'name' => 'Benin Electricty Distribution Company Prepaid',
                'shortname' => 'BEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '3344',
                'biller_id' => 12
            ],
            [
                'name' => 'College of Agriculture Wurno',
                'shortname' => 'CAGW',
                'product_category_id' => 9,
            ],
            [
                'name' => 'CollegeBasicRemedialStudies',
                'shortname' => 'CBR',
                'product_category_id' => 9,
                'product_code' => '301012',
            ],
            [
                'name' => 'College of Legal Islamic Studies',
                'shortname' => 'COLIS',
                'product_category_id' => 9,
                'product_code' => '301014',
            ],
            [
                'name' => 'College of Nursing Science Sokoto',
                'shortname' => 'CNCS',
                'product_category_id' => 9,
            ],
            [
                'name' => 'Consolidated',
                'shortname' => 'Consolidated',
                'product_category_id' => 9,
                'product_code' => '301021',
            ],
            [
                'name' => 'CyberSpace',
                'shortname' => 'CyberSpace',
                'product_category_id' => 9,
                'product_code' => '200139',
            ],
            [
                'name' => 'DSTV',
                'shortname' => 'DSTV',
                'product_category_id' => 4,
                'service_type' => 'dstv',
                'product_code' => '999',
            ],
            [
                'name' => 'EKEDC Postpaid',
                'shortname' => 'EKEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '1262',
                'biller_id' => 5
            ],
            [
                'name' => 'EKEDC Prepaid',
                'shortname' => 'EKEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '1263',
                'biller_id' => 5
            ],
            [
                'name' => 'FCMB Pension Fund Administrator',
                'shortname' => 'FCMB-PFA',
                'product_category_id' => 7,
            ],
            [
                'name' => 'FRSC',
                'shortname' => 'FRSC',
                'product_category_id' => 7,
            ],
            [
                'name' => 'GLO',
                'shortname' => 'GLO',
                'product_category_id' => 1,
                'product_code' => '300033',
                'service_type' => 'glo_airtime',
                'biller_id' => 2,
            ],
            [
                'name' => 'GOTV',
                'shortname' => 'GOTV',
                'product_category_id' => 4,
            ],
            [
                'name' => 'Ibadan Electricity Distribution Company Postpaid',
                'shortname' => 'IEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '12685',
                'biller_id' => 8
            ],
            [
                'name' => 'Ibadan Electricity Distribution Company Prepaid',
                'shortname' => 'IEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '12684',
                'biller_id' => 8
            ],
            [
                'name' => 'IKEDC Postpaid',
                'shortname' => 'IKEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '200031',
                'biller_id' => 9
            ],
            [
                'name' => 'IKEDC Prepaid',
                'shortname' => 'IKEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '200032',
                'biller_id' => 9
            ],
            [
                'name' => 'JambEpin',
                'shortname' => 'JambEpin',
                'product_category_id' => 9,
            ],
            [
                'name' => 'JambReference',
                'shortname' => 'JambReference',
                'product_category_id' => 9,
            ],
            [
                'name' => 'Jos Electricty Distribution Company Postpaid',
                'shortname' => 'JEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '301068',
                'biller_id' => 11
            ],
            [
                'name' => 'Jos Electricty Distribution Company Prepaid',
                'shortname' => 'JEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '301067',
                'biller_id' => 11
            ],
            [
                'name' => 'Kaduna Electricty Distribution Company Prepaid',
                'shortname' => 'KEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '3264',
                'biller_id' => 7
            ],
            [
                'name' => 'Kaduna Electricty Distribution Company Postpaid',
                'shortname' => 'KEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '3265',
                'biller_id' => 7
            ],
            [
                'name' => 'LCC',
                'shortname' => 'LCC',
                'product_category_id' => 9,

            ],
            [
                'name' => 'LASHMA',
                'shortname' => 'LASHMA',
                'product_category_id' => 9,
            ],
            [
                'name' => 'MTN',
                'shortname' => 'MTN',
                'product_category_id' => 1,
                'product_code' => '2347037819054',
                'service_type' => 'mtn_airtime',
                'biller_id' => 1
            ],
            [
                'name' => 'Sultan Muhammadu Maccido Institute for Qur\'an and General Studies',
                'shortname' => 'SMMCIS',
                'product_category_id' => 9,
            ],
            [
                'name'  => 'Nigeria Immigration Service',
                'shortname' => 'NIS',
                'product_category_id'  => 7,
            ],
            [
                'name' => 'Portharcourt Electricty Distribution Company Postpaid',
                'shortname' => 'PEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '959',
                'biller_id' => 6
            ],
            [
                'name' => 'Portharcourt Electricty Distribution Company Prepaid',
                'shortname' => 'PEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '817',
                'biller_id' => 6
            ],
            [
                'name' => 'RoyalExchange Insurance',
                'shortname' => 'RoyalExchangeInsurance',
                'product_category_id' => 7,
            ],
            [
                'name' => 'Sultan Abdulrahaman College of Health Technology',
                'shortname' => 'SACHT',
                'product_category_id' => 9,
            ],
            [
                'name' => 'Shehu Shagari College of Education',
                'shortname' => 'SSCE',
                'product_category_id' => 9,
            ],
            [
                'name' => 'Smile Bundle',
                'shortname' => 'SmileBundle',
                'product_category_id' => 1,
            ],
            [
                'name' => 'Sokoto College of Nursing Science',
                'shortname' => 'SNCS',
                'product_category_id' => 9,
            ],
            [
                'name' => 'Sokoto E-tax',
                'shortname' => 'SET',
                'product_category_id' => 7,
            ],
            [
                'name' => 'Sokoto State University',
                'shortname' => 'SSU',
                'product_category_id' => 9,
            ],
            [
                'name' => 'Spectranet',
                'shortname' => 'Spectranet',
                'product_category_id' => 1,
            ],
            [
                'name' => 'STARTIMES',
                'shortname' => 'STARTIMES',
                'product_category_id' => 4,
            ],
            [
                'name' => 'Swift',
                'shortname' => 'Swift',
                'product_category_id' => 1,
                'product_code' => '1001',
            ],
            [
                'name' => 'Umaru Shinkafi College of Education',
                'shortname' => 'USCE',
                'product_category_id' => 9,
            ],
            [
                'name' => 'Veritas Pension Fund Administrator',
                'shortname' => 'VPFA',
                'product_category_id' => 7,
            ],
            [
                'name' => 'Waec PIN Service',
                'shortname' => 'WPS',
                'product_category_id' => 9,
            ],
            [
                'name' => 'Waec Token Service',
                'shortname' => 'WTS',
                'product_category_id' => 9,
            ],
            [
                'name' => 'Wakanow',
                'shortname' => 'Wakanow',
                'product_category_id' => 4,
            ],
            [
                'name' => 'Zamtel',
                'shortname' => 'Zamtel',
                'product_category_id' => 1,
            ],

        ] : [
            [
                'name' => '9mobile',
                'shortname' => '9mobile',
                'product_category_id' => 1,
                'product_code' => '2348094190022',
                'service_type' => '9mobile_airtime',
                'biller_id' => 4,
            ],
            [
                'name' => 'Abuja Electricty Distribution Company Postpaid',
                'shortname' => 'AEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '300065',
                'biller_id' => 10,
            ],
            [
                'name' => 'Abuja Electricty Distribution Company Prepaid',
                'shortname' => 'AEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '300064',
                'biller_id' => 10,
            ],
            [
                'name' => 'Aiico Motor Insurance',
                'shortname' => 'AiicoMotorInsurance',
                'product_category_id' => 7,
                'product_code' => '301086',
            ],
            [
                'name' => 'Airtel',
                'shortname' => 'Airtel',
                'product_category_id' => 1,
                'product_code' => '2347087214896',
                'service_type' => 'airtel_airtime',
                'biller_id' => 3,
            ],
            [
                'name' => 'Akwa Ibom Internal Revenue Services',
                'shortname' => 'AIIRS',
                'product_category_id' => 7,
            ],
            [
                'name' => 'Bayelsa Internal Revenue Service',
                'shortname' => 'BIRS',
                'product_category_id' => 7,
                'product_code' => '300136',
            ],
            [
                'name' => 'Benin Electricty Distribution Company Postpaid',
                'shortname' => 'BEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '20018',
                'biller_id' => 12
            ],
            [
                'name' => 'Benin Electricty Distribution Company Prepaid',
                'shortname' => 'BEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '20017',
                'biller_id' => 12
            ],
            [
                'name' => 'College of Agriculture Wurno',
                'shortname' => 'CAGW',
                'product_category_id' => 9,
            ],
            [
                'name' => 'CollegeBasicRemedialStudies',
                'shortname' => 'CBR',
                'product_category_id' => 9,
            ],
            [
                'name' => 'College of Legal Islamic Studies',
                'shortname' => 'COLIS',
                'product_category_id' => 9,
            ],
            [
                'name' => 'College of Nursing Science Sokoto',
                'shortname' => 'CNCS',
                'product_category_id' => 9,
            ],
            [
                'name' => 'Consolidated',
                'shortname' => 'Consolidated',
                'product_category_id' => 9,
            ],
            [
                'name' => 'CyberSpace',
                'shortname' => 'CyberSpace',
                'product_category_id' => 9,
            ],
            [
                'name' => 'EKEDC Postpaid',
                'shortname' => 'EKEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '717',
                'biller_id' => 5
            ],
            [
                'name' => 'EKEDC Prepaid',
                'shortname' => 'EKEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '716',
                'biller_id' => 5
            ],
            [
                'name' => 'FCMB Pension Fund Administrator',
                'shortname' => 'FCMB-PFA',
                'product_category_id' => 7,
            ],
            [
                'name' => 'FRSC',
                'shortname' => 'FRSC',
                'product_category_id' => 7,
            ],
            [
                'name' => 'GLO',
                'shortname' => 'GLO',
                'product_category_id' => 1,
                'product_code' => '12699',
                'service_type' => 'glo_airtime',
                'biller_id' => 2,
            ],
            [
                'name' => 'GOTV',
                'shortname' => 'GOTV',
                'product_category_id' => 4,
            ],
            [
                'name' => 'Ibadan Electricity Distribution Company Postpaid',
                'shortname' => 'IEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '12685',
                'biller_id' => 8
            ],
            [
                'name' => 'Ibadan Electricity Distribution Company Prepaid',
                'shortname' => 'IEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '12684',
                'biller_id' => 8
            ],
            [
                'name' => 'IKEDC Postpaid',
                'shortname' => 'IKEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '12696',
                'biller_id' => 9
            ],
            [
                'name' => 'IKEDC Prepaid',
                'shortname' => 'IKEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '12697',
                'biller_id' => 9
            ],
            [
                'name' => 'JambEpin',
                'shortname' => 'JambEpin',
                'product_category_id' => 9,
                'product_code' => '300049',
            ],
            [
                'name' => 'JambReference',
                'shortname' => 'JambReference',
                'product_category_id' => 9,
                'product_code' => '300048',
            ],
            [
                'name' => 'Jos Electricty Distribution Company Postpaid',
                'shortname' => 'JEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '3662',
                'biller_id' => 11
            ],
            [
                'name' => 'Jos Electricty Distribution Company Prepaid',
                'shortname' => 'JEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '3663',
                'biller_id' => 11
            ],
            [
                'name' => 'Kaduna Electricty Distribution Company Prepaid',
                'shortname' => 'KEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '3264',
                'biller_id' => 7
            ],
            [
                'name' => 'Kaduna Electricty Distribution Company Postpaid',
                'shortname' => 'KEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '3265',
                'biller_id' => 7
            ],
            [
                'name' => 'LCC',
                'shortname' => 'LCC',
                'product_category_id' => 9,

            ],
            [
                'name' => 'LASHMA',
                'shortname' => 'LASHMA',
                'product_category_id' => 9,
            ],
            [
                'name' => 'MTN',
                'shortname' => 'MTN',
                'product_category_id' => 1,
                'product_code' => '12682',
                'service_type' => 'mtn_airtime',
                'biller_id' => 1
            ],
            [
                'name' => 'Sultan Muhammadu Maccido Institute for Qur\'an and General Studies',
                'shortname' => 'SMMCIS',
                'product_category_id' => 9,
            ],
            [
                'name'  => 'Nigeria Immigration Service',
                'shortname' => 'NIS',
                'product_category_id'  => 7,
            ],
            [
                'name' => 'Portharcourt Electricty Distribution Company Postpaid',
                'shortname' => 'PEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '959',
                'biller_id' => 6
            ],
            [
                'name' => 'Portharcourt Electricty Distribution Company Prepaid',
                'shortname' => 'PEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '817',
                'biller_id' => 6
            ],
            [
                'name' => 'RoyalExchange Insurance',
                'shortname' => 'RoyalExchangeInsurance',
                'product_category_id' => 7,
            ],
            [
                'name' => 'Sultan Abdulrahaman College of Health Technology',
                'shortname' => 'SACHT',
                'product_category_id' => 9,
            ],
            [
                'name' => 'Shehu Shagari College of Education',
                'shortname' => 'SSCE',
                'product_category_id' => 9,
            ],
            [
                'name' => 'Smile Bundle',
                'shortname' => 'SmileBundle',
                'product_category_id' => 1,
                'product_code' => '5154',
            ],
            [
                'name' => 'Sokoto College of Nursing Science',
                'shortname' => 'SNCS',
                'product_category_id' => 9,
            ],
            [
                'name' => 'Sokoto E-tax',
                'shortname' => 'SET',
                'product_category_id' => 7,
                'product_code' => '301098',
            ],
            [
                'name' => 'Sokoto State University',
                'shortname' => 'SSU',
                'product_category_id' => 9,
            ],
            [
                'name' => 'Spectranet',
                'shortname' => 'Spectranet',
                'product_category_id' => 1,
                'product_code' => '300058',
            ],
            [
                'name' => 'STARTIMES',
                'shortname' => 'STARTIMES',
                'product_category_id' => 4,
            ],
            [
                'name' => 'Swift',
                'shortname' => 'Swift',
                'product_category_id' => 1,
            ],
            [
                'name' => 'Umaru Shinkafi College of Education',
                'shortname' => 'USCE',
                'product_category_id' => 9,
            ],
            [
                'name' => 'Veritas Pension Fund Administrator',
                'shortname' => 'VPFA',
                'product_category_id' => 7,
                'product_code' => '301143',
            ],
            [
                'name' => 'Waec PIN Service',
                'shortname' => 'WPS',
                'product_category_id' => 9,
                'product_code' => '300138',
            ],
            [
                'name' => 'Waec Token Service',
                'shortname' => 'WTS',
                'product_category_id' => 9,
                'product_code' => '300137',
            ],
            [
                'name' => 'Wakanow',
                'shortname' => 'Wakanow',
                'product_category_id' => 4,
                'product_code' => '300139',
            ],
            [
                'name' => 'Zamtel',
                'shortname' => 'Zamtel',
                'product_category_id' => 1,
            ],

        ];
        foreach ($products as $product) {
            $arr = [
                'name' => $product['name'],
                'shortname' => $product['shortname'],
                'product_category_id' => $product['product_category_id'],
            ];
            if (isset($product['product_code'])) {
                $arr['vendor_code'] = $product['product_code'];
            }
            $arr['service_type'] = $product['service_type'] ??  Str::slug($product['name'], '_');
            if (isset($product['biller_id'])) {
                $arr['biller_id'] = $product['biller_id'];
            }
            Product::factory()
                // ->has(SubProduct::factory(2), 'subProducts')
                ->create($arr);
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
            $business->products()->saveMany(BusinessProduct::factory()->count(1)->make());
            $business->wallet()->save(Wallet::factory()->make());
            $business->users()->saveMany(User::factory()->count(1)->make());
            $business->invitees()->saveMany(Invitee::factory()->count(2)->make());
            $business->banks()->saveMany(BusinessBank::factory()->count(1)->make());
        }

        $transactions =  Transaction::factory()->count(3)->create();
        // foreach ($transactions as $transaction) {
        //     $transaction->extra()->save(TransactionExtra::factory()->make());
        // }
        $wallets = Wallet::all();
        foreach ($wallets as $wallet) {
            // foreach wallet create transactions
            $wallet->transactions()->saveMany(WalletTransaction::factory()->count(5)->make());
            $wallet->splits()->saveMany(WalletSplit::factory()->count(5)->make());
            $wallet->logs()->saveMany(WalletLog::factory()->count(5)->make());
        }

        $this->call(DevUsersSeeder::class);
        $this->call(UpBusinessSeeder::class);
        $this->call(MTNSubProductSeeder::class);
        $this->call(TransactionExtraSeeder::class);
        // create 20 accounts
        // create 50 billers
        // create 50 transactions


    }
}
