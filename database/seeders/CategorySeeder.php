<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'T-Shirts',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Shirts',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pants',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jeans',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jackets',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Shoes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
