<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Department;
use App\Models\ProductUnit;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'masteradmin']);
        Role::create(['name' => 'department']);
        Role::create(['name' => 'warehouse']);
        Role::create(['name' => 'management']);

        $this->call([
            DepartmentSeeder::class,
            SupplierSeeder::class,
            ProductUnitSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
        ]);

        User::insert([
            [
                'dept_id' => 1,
                'name' => 'Master Admin',
                'username' => 'masteradmin',
                'phone' => '123456',
                'password' => Hash::make('password'),
            ],
            [
                'dept_id' => 2,
                'name' => 'Admin Keuangan',
                'username' => 'keuangan',
                'phone' => '123456',
                'password' => Hash::make('password'),
            ],
            [
                'dept_id' => 3,
                'name' => 'Admin Ops',
                'username' => 'operasional',
                'phone' => '123456',
                'password' => Hash::make('password'),
            ],
            [
                'dept_id' => 8,
                'name' => 'Admin Manah Liang',
                'username' => 'manahliang',
                'phone' => '123456',
                'password' => Hash::make('password'),
            ],
            [
                'dept_id' => 1,
                'name' => 'Admin RS Prof Ngoerah',
                'username' => 'WHS01',
                'phone' => '123456',
                'password' => Hash::make('password'),
            ]
        ]);

        $user = User::find(1);
        $user->assignRole('masteradmin');
    }
}
