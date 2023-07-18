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
                // CAREHOME
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

                // PLAN
                [
                    'model'=>'Plan',
                    'permission'=>'index',
                ],
                [
                    'model'=>'Plan',
                    'permission'=>'show',
                ],
                [
                    'model'=>'Plan',
                    'permission'=>'store',
                ],
                [
                    'model'=>'Plan',
                    'permission'=>'update',
                ],
                [
                    'model'=>'Plan',
                    'permission'=>'delete',
                ],

                // PROFESSIONAL
                [
                    'model'=>'Professional',
                    'permission'=>'index',
                ],
                [
                    'model'=>'Professional',
                    'permission'=>'show',
                ],
                [
                    'model'=>'Professional',
                    'permission'=>'store',
                ],
                [
                    'model'=>'Professional',
                    'permission'=>'update',
                ],
                [
                    'model'=>'Professional',
                    'permission'=>'delete',
                ],

                // USER
                [
                    'model'=>'User',
                    'permission'=>'index',
                ],
                [
                    'model'=>'User',
                    'permission'=>'show',
                ],
                [
                    'model'=>'User',
                    'permission'=>'store',
                ],
                [
                    'model'=>'User',
                    'permission'=>'update',
                ],
                [
                    'model'=>'User',
                    'permission'=>'delete',
                ],

                // BUSINESS
                [
                    'model'=>'Business',
                    'permission'=>'index',
                ],
                [
                    'model'=>'Business',
                    'permission'=>'show',
                ],
                [
                    'model'=>'Business',
                    'permission'=>'store',
                ],
                [
                    'model'=>'Business',
                    'permission'=>'update',
                ],
                [
                    'model'=>'Business',
                    'permission'=>'delete',
                ],

                // BUSINESS ADVERTISEMENT
                [
                    'model'=>'Advertisement',
                    'permission'=>'index',
                ],
                [
                    'model'=>'Advertisement',
                    'permission'=>'show',
                ],
                [
                    'model'=>'Advertisement',
                    'permission'=>'store',
                ],
                [
                    'model'=>'Advertisement',
                    'permission'=>'update',
                ],
                [
                    'model'=>'Advertisement',
                    'permission'=>'delete',
                ],
            ]);
    }
}
