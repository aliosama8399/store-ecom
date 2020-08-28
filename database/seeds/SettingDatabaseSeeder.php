<?php
use  App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Setting::create([
//           'key'=>'My Name',
//           'is_translatable'=>0,
//           'plain_value'=> 'Ali Osama'
//
//        ]);
        Setting::setMany([
            'default_locale'=>'ar',
            'default_timezone'=>'Africa/Cairo',
            'reviews_enabled'=>true,
            'auto_approve_reviews'=>true,
            'supported_currencies'=>['USD','LE','SAR'],
            'default_currency'=>'USD',
            'store_email'=>'ali@commerce.com',
            'search_engine'=>'mysql',
            'local_shipping_cost'=>0,
            'outer_shipping_cost'=>0,
            'free_shipping_cost'=>0,
            'translatable'=>[
//                'store_name'=>'Alol Store',
//                'free_shipping_label'=>'Free Shipping',
//                'local_label'=>'Local Shipping',
//                'outer_label'=>'Outer Shipping',


                'store_name'=>'متجر علول',
                'free_shipping_label'=>'توصيل مجانى',
                'local_label'=>'توصيل داخلى',
                'outer_label'=>'نوصيل خارجى',

            ],

        ]);


    }
}
