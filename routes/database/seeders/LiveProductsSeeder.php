<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\SubProduct;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LiveProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => '9mobile',
                'logo' => 'https://res.cloudinary.com/vas-reseller/image/upload/v1665055007/722567D5-FEF0-4594-AC39-551AE3CB7772_i3d5tx.png',
                'shortname' => '9mobile',
                'product_category_id' => 1,
                'product_code' => '2348094190022',
                'service_type' => '9mobile_airtime',
                'biller_id' => 4,
                'up_product_key' => '001'
            ],
            [
                'name' => '9mobile Databundle',
                'logo' => 'https://res.cloudinary.com/vas-reseller/image/upload/v1665055007/722567D5-FEF0-4594-AC39-551AE3CB7772_i3d5tx.png',
                'shortname' => '9mobile',
                'product_category_id' => 2,
                'product_code' => '2348094190022',
                'service_type' => '9mobile_databundle',
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
                'logo' => 'https://res.cloudinary.com/vas-reseller/image/upload/v1665055006/557D0571-C4FA-4BF2-B331-09B3CEBEC7A4_ichasg.png',
                'shortname' => 'Airtel',
                'product_category_id' => 1,
                'product_code' => '2347087214896',
                'service_type' => 'airtel_airtime',
                'biller_id' => 3,
                'up_product_key' => 'EXRCTRFREQ',
            ],
            [
                'name' => 'Airtel Databundle',
                'logo' => 'https://res.cloudinary.com/vas-reseller/image/upload/v1665055006/557D0571-C4FA-4BF2-B331-09B3CEBEC7A4_ichasg.png',
                'shortname' => 'Airtel',
                'product_category_id' => 2,
                'product_code' => '2347087214896',
                'service_type' => 'airtel_databundle',
                'biller_id' => 3,
            ],
            [
                'name' => 'Akwa Ibom Internal Revenue Services',
                'shortname' => 'AKIRS',
                'product_category_id' => 7,
                'product_code' => '300051',
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
                'product_code' => '301024',
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
                'product_code' => '301013',
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
                'logo' => 'https://res.cloudinary.com/vas-reseller/image/upload/v1665055006/ED0FC27F-FDCC-4FBD-8A8E-4C8B2B2B5194_m5bpbd.png',
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
                'biller_id' => 5,
                'min_amount' => 900,
            ],
            [
                'name' => 'EKEDC Prepaid',
                'shortname' => 'EKEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '1263',
                'biller_id' => 5,
                'min_amount' => 900,
            ],
            [
                'name' => 'FCMB Pension Fund Administrator',
                'shortname' => 'FCMBPFA',
                'product_category_id' => 7,
                'product_code' => '301087',
            ],
            [
                'name' => 'FRSC',
                'shortname' => 'FRSC',
                'product_category_id' => 7,
                'product_code' => '300052',
            ],
            [
                'name' => 'GLO',
                'shortname' => 'GLO',
                'product_category_id' => 1,
                'logo' => 'https://res.cloudinary.com/vas-reseller/image/upload/v1665055006/0C2F50FB-2B96-4E2E-A1DD-D4EB7CEC329E_yflizx.png',
                'product_code' => '300033',
                'service_type' => 'glo_airtime',
                'biller_id' => 2,
                'up_product_key' => 'AIRTIME',
            ],
            [
                'name' => 'GLO Databundle',
                'shortname' => 'GLO_Databundle',
                'logo' => 'https://res.cloudinary.com/vas-reseller/image/upload/v1665055006/0C2F50FB-2B96-4E2E-A1DD-D4EB7CEC329E_yflizx.png',
                'product_category_id' => 2,
                'product_code' => '300033',
                'service_type' => 'glo_databundle',
                'biller_id' => 2,
            ],
            [
                'name' => 'GOTV',
                'shortname' => 'GOTV',
                'logo' => 'https://res.cloudinary.com/vas-reseller/image/upload/v1665055006/73E9A419-1CEA-4122-8A41-1361BF01DA14_lrxaat.png',
                'product_category_id' => 4,
                'product_code' => '9991',
            ],
            [
                'name' => 'Ibadan Electricity Distribution Company Postpaid',
                'shortname' => 'IEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '200018',
                'biller_id' => 8
            ],
            [
                'name' => 'Ibadan Electricity Distribution Company Prepaid',
                'shortname' => 'IEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '200017',
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
                'product_code' => '301068',
                'biller_id' => 11,
                'min_amount' => 2000,
            ],
            [
                'name' => 'Jos Electricty Distribution Company Prepaid',
                'shortname' => 'JEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '301067',
                'biller_id' => 11,
                'min_amount' => 2000,
            ],
            [
                'name' => 'Kaduna Electricty Distribution Company Prepaid',
                'shortname' => 'KEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '301069',
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
                'product_code' => '520135',

            ],
            [
                'name' => 'LASHMA',
                'shortname' => 'LASHMA',
                'product_category_id' => 9,
            ],
            [
                'name' => 'MTN',
                'shortname' => 'MTN',
                'logo' => 'https://res.cloudinary.com/vas-reseller/image/upload/v1665055006/F5D9367A-863C-49D9-99E0-3C4277AC040E_k3homd.png',
                'product_category_id' => 1,
                'product_code' => '2347037819054',
                'service_type' => 'mtn_airtime',
                'biller_id' => 1,
                'up_product_key' => '1',
            ],
            [
                'name' => 'MTN Databundle',
                'logo' => 'https://res.cloudinary.com/vas-reseller/image/upload/v1665055006/F5D9367A-863C-49D9-99E0-3C4277AC040E_k3homd.png',
                'shortname' => 'MTN_Databundle',
                'product_category_id' => 2,
                'product_code' => '2347037819054',
                'service_type' => 'MTN_Databundle',
                'biller_id' => 1
            ],
            [
                'name' => 'Sultan Muhammadu Maccido Institute for Qur\'an and General Studies',
                'shortname' => 'SMMCIS',
                'product_category_id' => 9,
                'product_code' => '301023',
            ],
            [
                'name'  => 'Nigeria Immigration Service',
                'shortname' => 'NIS',
                'product_category_id'  => 7,
                'product_code' => '300053'
            ],
            [
                'name' => 'Portharcourt Electricty Distribution Company Postpaid',
                'shortname' => 'PEDC-Postpaid',
                'product_category_id' => 3,
                'product_code' => '1000',
                'biller_id' => 6
            ],
            [
                'name' => 'Portharcourt Electricty Distribution Company Prepaid',
                'shortname' => 'PEDC-Prepaid',
                'product_category_id' => 3,
                'product_code' => '100012',
                'biller_id' => 6
            ],
            [
                'name' => 'RoyalExchange Insurance',
                'shortname' => 'RoyalExchangeInsurance',
                'product_category_id' => 7,
                'product_code' => '301691',
            ],
            [
                'name' => 'Sultan Abdulrahaman College of Health Technology',
                'shortname' => 'SACHT',
                'product_category_id' => 9,
                'product_code' => '301015',
            ],
            [
                'name' => 'Shehu Shagari College of Education',
                'shortname' => 'SSCE',
                'product_category_id' => 9,
                'product_code' => '300162',
            ],
            [
                'name' => 'Smile Bundle',
                'shortname' => 'SmileBundle',
                'product_category_id' => 2,
                'product_code' => '5154',
            ],
            [
                'name' => 'Smile Airtime',
                'shortname' => 'SmileAirtime',
                'product_category_id' => 1,
                'product_code' => '5153',
            ],
            [
                'name' => 'Sokoto College of Nursing Science',
                'shortname' => 'SNCS',
                'product_category_id' => 9,
                'product_code' => '301025',
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
                'product_code' => '301011',
            ],
            [
                'name' => 'Spectranet',
                'shortname' => 'Spectranet',
                'product_category_id' => 2,
                'product_code' => '300058',
            ],
            [
                'name' => 'STARTIMES',
                'shortname' => 'STARTIMES2',
                'logo' => 'https://res.cloudinary.com/vas-reseller/image/upload/v1665055006/73C97332-60D4-4BB2-B39B-3879FC43DFD3_w4onmw.png',
                'product_category_id' => 4,
                'product_code' => '5247',
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
                'product_code' => '300135',
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
                'product_category_id' => 2,
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
            // logo
            if (isset($product['logo'])) {
                $arr['logo'] = $product['logo'];
            }
            $arr['service_type'] = $product['service_type'] ??  Str::slug($product['name'], '_');
            if (isset($product['biller_id'])) {
                $arr['biller_id'] = $product['biller_id'];
            }
            if (isset($product['up_product_key'])) {
                $arr['up_product_key'] = $product['up_product_key'];
            }
            if (isset($product['min_amount'])) {
                $arr['min_amount'] = $product['min_amount'];
            }
            Product::factory()
                // ->has(SubProduct::factory(2), 'subProducts')
                ->create($arr);
        }
    }
}
