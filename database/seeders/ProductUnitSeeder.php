<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Siapkan data unit yang akan dimasukkan
        $units = [
            ['name' => 'Piece', 'short' => 'pcs'],
            ['name' => 'Kilogram', 'short' => 'kg'],
            ['name' => 'Gram', 'short' => 'g'],
            ['name' => 'Liter', 'short' => 'L'],
            ['name' => 'Box', 'short' => 'box'],
            ['name' => 'Pack', 'short' => 'pack'],
            ['name' => 'Sachet', 'short' => 'sachet'],
            ['name' => 'Bottle', 'short' => 'btl'],
            ['name' => 'Unit', 'short' => 'unit'],
        ];

        // Tambahkan timestamp untuk setiap data secara otomatis
        foreach ($units as $unit) {
            $unit['created_at'] = Carbon::now();
            $unit['updated_at'] = Carbon::now();
        }

        // Masukkan data ke dalam tabel 'product_units'
        // Menggunakan DB::table()->insert() lebih efisien untuk data dalam jumlah besar
        DB::table('product_units')->insert($units);
    }
}
