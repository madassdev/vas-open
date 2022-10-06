<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\SubProduct;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SandboxProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $products = config('database.default') == 'mysqltest' ? 
        $products =[
            [
                'name' => '9mobile',
                'shortname' => '9mobile',
                'product_category_id' => 1,
                'product_code' => '12700',
                'service_type' => '9mobile_airtime',
                'biller_id' => 4,
            ],
            [
                'name' => '9mobile Databundle',
                'shortname' => '9mobile',
                'product_category_id' => 2,
                'product_code' => '12700',
                'service_type' => '9mobile_databundle',
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
                'name' => 'Airtel Databundle',
                'shortname' => 'Airtel',
                'product_category_id' => 2,
                'product_code' => '2347087214896',
                'service_type' => 'airtel_databundle',
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
                'name' => 'GLO Databundle',
                'shortname' => 'GLO_Databundle',
                'product_category_id' => 2,
                'product_code' => '300033',
                'service_type' => 'glo_databundle',
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
                'product_code' => '12682',
                'service_type' => 'mtn_airtime',
                'biller_id' => 1
            ],
            [
                'name' => 'MTN Databundle',
                'shortname' => 'MTN_Databundle',
                'product_category_id' => 2,
                'product_code' => '12682',
                'service_type' => 'MTN_Databundle',
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
                'product_category_id' => 2,
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
                'product_category_id' => 2,
            ],
            [
                'name' => 'STARTIMES',
                'shortname' => 'STARTIMES',
                'product_category_id' => 4,
            ],
            [
                'name' => 'Swift',
                'shortname' => 'Swift',
                'product_category_id' => 2,
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
                'product_category_id' => 2,
            ],

        ] ;
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
            if (isset($product['up_product_key'])) {
                $arr['up_product_key'] = $product['up_product_key'];
            }
            Product::factory()
                // ->has(SubProduct::factory(2), 'subProducts')
                ->create($arr);
        }
    }
}
