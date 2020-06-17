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
        DB::table('users')->insert([
            'id' => 1,
            'username' => 'Administrator',
            'pwd' => Hash::make('12345678'),
            'email' => 'admin@example.com',
            'type' => 3,
            'sex' => 0,
            'age' => 24,
        ]);
        DB::table('users')->insert([
            'id' => 2,
            'username' => '测试医生',
            'pwd' => Hash::make('12345678'),
            'email' => 'me@example.com',
            'type' => 0,
            'sex' => 0,
            'age' => 24,
            'clinic_id' => 1,
            'certificate_checked' => 2
        ]);

        DB::table('clinics')->insert([
            [
                'id' => 1,
                'name' => '达明口腔门诊部',
                'city' => '广州',
                'position' => '113.595114,23.544983',
                'intro' => '暂无介绍'
            ]
        ]);

        DB::table('patients')->insert([
            [
                'id' => 'DLE200617083554',
                'user_id' => 2,
                'name' => '某人',
                'age' => 10,
                'sex' => 0,
                'comments' => '无'
            ]
        ]);

        DB::table('addresses')->insert([
            [
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
    }
}
