<?php

namespace Database\Seeders;


use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        Department::insert([
            [
                'name' => 'Logistik',
                'pic' => 'Rahmat',
                'phone' => '081234567890',
            ],
            [
                'name' => 'Keuangan',
                'pic' => 'Gusti Ayu Apriliani Swantari',
                'phone' => '081234567890',
            ],
            [
                'name' => 'Operasional',
                'pic' => 'Arie Haryadi',
                'phone' => '081234567890',
            ],
            [
                'name' => 'Holding',
                'pic' => 'Luh Adi Sukarini',
                'phone' => '081234567890',
            ],
            [
                'name' => 'IT',
                'pic' => 'Gede Agus Adi Saputra',
                'phone' => '081234567890',
            ],
            [
                'name' => 'Commercial',
                'pic' => 'Vania Prajnani',
                'phone' => '081234567890',
            ],
            [
                'name' => 'HRD',
                'pic' => 'Komang Indri',
                'phone' => '081234567890',
            ],
            [
                'name' => 'Manah Liang',
                'pic' => 'Ervina Bachtiar',
                'phone' => '081234567890',
            ]
        ]);
    }
}
