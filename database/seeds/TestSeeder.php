<?php

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([[
            'created_at' => '2020-06-26 13:33:58',
            'updated_at' => '2020-06-26 13:33:58',
            'id' => 1,
            'username' => 'Administrator',
            'pwd' => Hash::make('12345678'),
            'email' => 'admin@example.com',
            'type' => 3,
            'sex' => 0,
            'age' => 24,
        ], [
            'created_at' => '2020-06-26 13:33:58',
            'updated_at' => '2020-06-26 13:33:58',
            'id' => 3,
            'username' => 'Professor',
            'pwd' => Hash::make('12345678'),
            'email' => 'professor@example.com',
            'type' => 2,
            'sex' => 0,
            'age' => 24,
        ]]);
        DB::table('users')->insert([
            'created_at' => '2020-06-26 13:33:58',
            'updated_at' => '2020-06-26 13:33:58',
            'id' => 2,
            'username' => '测试医生',
            'pwd' => Hash::make('12345678'),
            'email' => 'me@example.com',
            'type' => 0,
            'sex' => 0,
            'age' => 24,
            'head_portrait' => 'https://ivory.r.samnya.cn/api/files/public/avatar.png',
            'clinic_id' => 1,
            'mobile' => '+8613800000000',
            'fix_phone_number' => '',
            'certificate' => 'https://ivory.r.samnya.cn/api/files/public/certificate.jpg',
            'certificate_checked' => 2,
            'wechat' => '00000',
            'intro' => 'To specify a list of valid parameters your API route accepts, use the @urlParam, @bodyParam and @queryParam annotations.',
            'school' => '没读大学',
            'major' => '忽悠专业'
        ]);

        DB::table('addresses')->insert([
            [
                'created_at' => '2020-06-26 13:33:58',
                'updated_at' => '2020-06-26 13:33:58',
                'id' => 1,
                'user_id' => 2,
                'real_name' => '某医生',
                'telephone' => '13800000000',
                'country' => 86,
                'province' => 44,
                'city' => 01,
                'area' => 84,
                'street' => '某街道',
                'zip' => 500000,
                'is_default' => true,

            ]
        ]);

        DB::table('clinics')->insert([
            [
                'created_at' => '2020-06-26 13:33:58',
                'updated_at' => '2020-06-26 13:33:58',
                'id' => 1,
                'name' => '达明口腔门诊部',
                'city' => '广州',
                'image' => 'https://ivory.r.samnya.cn/api/files/public/hospital.jpg',
                'position' => '23.544983,113.595114',
                'address' => '广州市从化区河东北路5号',
                'intro' => '暂无介绍'
            ]
        ]);

        DB::table('patients')->insert([
            [
                'created_at' => '2020-06-26 13:33:58',
                'updated_at' => '2020-06-26 13:33:58',
                'id' => 'DLE200617083554',
                'user_id' => 2,
                'name' => '某人',
                'age' => 10,
                'sex' => 0,
                'comments' => '无',
                'photo_url' => 'patientPhoto/ogzMlT0vOp53PGgc5KwWmkUZ7mh4ndbFLdH1RS2h.png'
            ]
        ]);

        DB::table('patient_cases')->insert([
            [
                'created_at' => '2020-06-26 13:33:58',
                'updated_at' => '2020-06-26 13:33:58',
                'id' => 1,
                'patient_id' => 'DLE200617083554',
                'user_id' => 2,
                'state' => 2,
                'features' => '无症状',
                'files' => '{}',
                'therapy_program' => '无需治疗'
            ]
        ]);

        DB::table('orders')->insert([
            [
                'created_at' => '2020-06-26 13:33:58',
                'updated_at' => '2020-06-26 13:33:58',
                'id' => 1,
                'clinic_id' => 1,
                'professor_id' => 1,
                'doctor_id' => 2,
                'patient_case_id' => 1,
                'is_first' => true,
                'state' => 0,
                'product_count' => 3,
                'total_price' => 1000,
                'payment_price' => 998,
                'shipping_fee' => 14,
                'pay_method' => 1,
                'pay_number' => '15233958572390',
                'pay_time' => '2020-06-19 13:26:43',
                'tracking_number' => 'SF000002231231',
                'address_id' => 1,
                'shipping_time' => '2020-06-19 13:26:43',
                'fapiao_id' => 1,
                'comments' => '无备注'
            ]
        ]);

        DB::table('order_detail')->insert([
            [
                'created_at' => '2020-06-26 13:33:58',
                'updated_at' => '2020-06-26 13:33:58',
                'id' => 1,
                'order_id' => 1,
                'product_no' => 'XXSD02',
                'product_name' => '器具',
                'product_params' => '{"size": 0}',
                'product_count' => 2,
                'product_price' => 20,
                'customer_comments' => '无备注'
            ]
        ]);
    }
}
