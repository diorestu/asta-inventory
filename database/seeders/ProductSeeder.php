<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductUnit;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Inisialisasi Faker untuk membuat data palsu.
        $faker = \Faker\Factory::create('id_ID'); // Menggunakan lokal Indonesia untuk data yang lebih relevan

        // Ambil semua ID yang ada dari tabel relasi.
        // Ini memastikan bahwa foreign key yang kita masukkan valid.
        $categoryIds = ProductCategory::pluck('id')->all();
        $unitIds = ProductUnit::pluck('id')->all();

        // Jika tidak ada kategori atau unit, seeder tidak bisa berjalan.
        if (empty($categoryIds) || empty($unitIds)) {
            $this->command->error("Please seed product categories and units before seeding products.");
            return;
        }

        // Buat 50 data produk palsu.
        for ($i = 0; $i < 50; $i++) {
            $name = $faker->unique()->word();
            Product::create([
                'cat_id' => $faker->randomElement($categoryIds), // Ambil ID kategori secara acak
                'unit_id' => $faker->randomElement($unitIds),   // Ambil ID unit secara acak
                'name' => $name,
                'slug' => Str::slug($name),
                'sku' => $faker->unique()->ean8(), // SKU unik dengan 8 digit
                'description' => $faker->optional()->sentence(15), // Deskripsi, kadang-kadang null
                'min_stock' => $faker->numberBetween(5, 15),
                'max_stock' => $faker->optional()->numberBetween(100, 500), // Max stock, kadang-kadang null
            ]);
        }
    }
}
