<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'id' => 1,
                'name' => 'Uniqlo Blue Baggy Jeans',
                'price' => 80000,
                'description' => 'A relaxed-fit denim style designed for ultimate comfort and streetwear appeal. Featuring a loose silhouette from the waist down, these jeans offer extra room in the thighs and legs without compromising on style. Perfect for casual outfits, they pair well with oversized tees, hoodies, and sneakers for a laid-back, trendy look. Made from durable denim with classic five-pocket styling and a button fly for everyday wear.',
                'category_id' => 4, // Jeans
                'stock' => 10,
                'image' => '68b93347e778emen_baggy_jeans.webp',
                'created_at' => '2025-09-04 00:05:51',
                'updated_at' => '2025-09-04 00:05:51',
            ],
            [
                'id' => 3,
                'name' => 'Ralph Lauren Sweater',
                'price' => 200000,
                'description' => 'Elevate your wardrobe with this classic Ralph Lauren men’s sweater, crafted from premium-quality fabric for lasting comfort and style. Featuring the iconic Polo Ralph Lauren logo, this sweater combines timeless design with modern sophistication. Perfect for layering or wearing on its own, it pairs effortlessly with jeans, chinos, or dress pants, making it an essential piece for both casual and smart-casual looks. Soft, breathable, and tailored for a flattering fit, this sweater brings elegance to every occasion.',
                'category_id' => 5, // Jackets / Outerwear
                'stock' => 0,
                'image' => '68b944d2de585ralph_laurne_sweatshirt.avif',
                'created_at' => '2025-09-04 01:20:42',
                'updated_at' => '2025-09-22 08:55:45',
            ],
            [
                'id' => 4,
                'name' => "Uniqlo Men's Linen Pants",
                'price' => 60000,
                'description' => 'This clothing item is versatile, comfortable, and stylish, making it a staple for any wardrobe. Made from quality materials, it suits both casual and formal occasions and pairs easily with different outfits.',
                'category_id' => 3, // Pants
                'stock' => 15,
                'image' => '68bac572796f0linen_pants.jpg',
                'created_at' => '2025-09-05 04:41:46',
                'updated_at' => '2025-09-24 23:53:07',
            ],
            [
                'id' => 5,
                'name' => 'Calvin Klein Back Logo T-shirt',
                'price' => 120000,
                'description' => 'This clothing item is versatile, comfortable, and stylish, making it a staple for any wardrobe. Made from quality materials, it suits both casual and formal occasions and pairs easily with different outfits.',
                'category_id' => 1, // T-Shirts
                'stock' => 1,
                'image' => '68bac613358d2calvin_klein_tshirt.webp',
                'created_at' => '2025-09-05 04:44:27',
                'updated_at' => '2025-10-01 07:44:04',
            ],
            [
                'id' => 6,
                'name' => 'Nike Air Force 1',
                'price' => 600000,
                'description' => 'This clothing item is versatile, comfortable, and stylish, making it a staple for any wardrobe. Made from quality materials, it suits both casual and formal occasions and pairs easily with different outfits.',
                'category_id' => 6, // Shoes
                'stock' => 7,
                'image' => '68bac6c39ff7eaf1.webp',
                'created_at' => '2025-09-05 04:47:23',
                'updated_at' => '2025-09-24 23:52:48',
            ],
            [
                'id' => 7,
                'name' => "Carharrt Men's Detroit Lined Workwear Jacket",
                'price' => 800000,
                'description' => 'This clothing item is versatile, comfortable, and stylish, making it a staple for any wardrobe. Made from quality materials, it suits both casual and formal occasions and pairs easily with different outfits.',
                'category_id' => 5, // Jackets
                'stock' => 6,
                'image' => '68bac7a3eb8dbcarhartt_jacket.jpg',
                'created_at' => '2025-09-05 04:51:07',
                'updated_at' => '2025-09-24 23:52:41',
            ],
            [
                'id' => 8,
                'name' => 'Uniqlo Relaxed Ankle Jeans',
                'price' => 250000,
                'description' => 'This clothing item is versatile, comfortable, and stylish, making it a staple for any wardrobe. Made from quality materials, it suits both casual and formal occasions and pairs easily with different outfits.',
                'category_id' => 4, // Jeans
                'stock' => 2,
                'image' => '68bbd117f079auniqlo_ralaxed_ankle_jeans.avif',
                'created_at' => '2025-09-05 23:43:43',
                'updated_at' => '2025-09-24 23:52:34',
            ],
            [
                'id' => 9,
                'name' => 'H&M Loose Fit Twill Trousers',
                'price' => 250000,
                'description' => 'This clothing item is versatile, comfortable, and stylish, making it a staple for any wardrobe. Made from quality materials, it suits both casual and formal occasions and pairs easily with different outfits.',
                'category_id' => 3, // Pants
                'stock' => 1,
                'image' => '68bbd1e9abc92LooseFitTwiltrousers.avif',
                'created_at' => '2025-09-05 23:47:13',
                'updated_at' => '2025-10-01 07:44:04',
            ],
            [
                'id' => 10,
                'name' => 'H&M Loose Fit Printed Tee',
                'price' => 170000,
                'description' => 'This clothing item is versatile, comfortable, and stylish, making it a staple for any wardrobe. Made from quality materials, it suits both casual and formal occasions and pairs easily with different outfits.',
                'category_id' => 1, // T-Shirts
                'stock' => 18,
                'image' => '68bbd240e8debLoose Fit Printed T-shirt.webp',
                'created_at' => '2025-09-05 23:48:40',
                'updated_at' => '2025-10-01 07:31:34',
            ],
        ]);
    }
}
