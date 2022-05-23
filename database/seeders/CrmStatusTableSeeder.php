<?php

namespace Database\Seeders;

use App\Models\CrmStatus;
use Illuminate\Database\Seeder;

class CrmStatusTableSeeder extends Seeder
{
    public function run()
    {
        $crmStatuses = [
            [
                'id'         => 1,
                'name'       => 'Lead',
                'created_at' => '2022-05-19 12:47:17',
                'updated_at' => '2022-05-19 12:47:17',
            ],
            [
                'id'         => 2,
                'name'       => 'Customer',
                'created_at' => '2022-05-19 12:47:17',
                'updated_at' => '2022-05-19 12:47:17',
            ],
            [
                'id'         => 3,
                'name'       => 'Partner',
                'created_at' => '2022-05-19 12:47:17',
                'updated_at' => '2022-05-19 12:47:17',
            ],
        ];

        CrmStatus::insert($crmStatuses);
    }
}
