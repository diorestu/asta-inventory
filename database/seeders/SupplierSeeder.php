<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductUnit;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inisialisasi Faker untuk membuat data palsu.
        $faker = \Faker\Factory::create('id_ID'); // Menggunakan lokal Indonesia untuk data yang lebih relevan
        for ($i = 0; $i < 10; $i++) {
            // Membuat data supplier dengan informasi yang relevan.
            Supplier::create([
                'name'           => $faker->company(),
                'contact_person' => $faker->name(),
                'email'          => $faker->unique()->safeEmail(),
                'phone_number'   => $faker,
                'tax_id'         => $faker->unique()->numerify('###########'), // Contoh format NPWP
                'is_active'      => true, // Status aktif
                'city'           => $faker->city(),
                'country'        => $faker->country(),
                'address'        => $faker->address(),
                'payment_method' => $faker->randomElement(['Cash', 'Transfer', 'Credit']),
                'payment_terms'  => $faker->randomElement(['Net 30', 'Net 60', 'Due on Receipt']),
            ]);
        }
    }
}
