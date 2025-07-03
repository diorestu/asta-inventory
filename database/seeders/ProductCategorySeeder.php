<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Siapkan data kategori yang akan dimasukkan
        $categories = [
            [
                'name' => 'Makanan & Minuman',
                'description' => 'Berbagai macam makanan jadi, minuman kemasan, dan bahan makanan pokok.'
            ],
            [
                'name' => 'Elektronik',
                'description' => 'Peralatan elektronik rumah tangga, gadget, dan aksesorisnya.'
            ],
            [
                'name' => 'Fashion Pria',
                'description' => 'Pakaian, sepatu, jam tangan, dan aksesoris khusus untuk pria.'
            ],
            [
                'name' => 'Fashion Wanita',
                'description' => 'Pakaian, sepatu, tas, dan aksesoris khusus untuk wanita.'
            ],
            [
                'name' => 'Kesehatan & Kecantikan',
                'description' => 'Produk perawatan diri, kosmetik, suplemen, dan alat kesehatan.'
            ],
            [
                'name' => 'Alat Tulis Kantor',
                'description' => 'Kebutuhan alat tulis, kertas, dan berbagai perlengkapan kantor.'
            ],
            [
                'name' => 'Otomotif',
                'description' => 'Suku cadang dan aksesoris untuk kendaraan motor dan mobil.'
            ],
            [
                'name' => 'Lain-lain',
                'description' => 'Kategori untuk produk yang tidak termasuk dalam kategori lain.'
            ],
        ];

        // Tambahkan timestamp (created_at & updated_at) untuk setiap data
        foreach ($categories as $category) {
            $category['created_at'] = Carbon::now();
            $category['updated_at'] = Carbon::now();
        }

        // Masukkan data ke dalam tabel 'product_categories'
        DB::table('product_categories')->insert($categories);
    }
}
