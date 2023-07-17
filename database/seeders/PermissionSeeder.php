<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert(
            [
                [
                    'model'=>'CareHome',
                    'permission'=>'index',
                ],
                [
                    'model'=>'CareHome',
                    'permission'=>'show',
                ],
                [
                    'model'=>'CareHome',
                    'permission'=>'store',
                ],
                [
                    'model'=>'CareHome',
                    'permission'=>'update',
                ],
                [
                    'model'=>'CareHome',
                    'permission'=>'delete',
                ],
            ]);
    }
}
