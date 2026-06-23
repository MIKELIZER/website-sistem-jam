<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Luxury Watch', 'slug' => 'luxury-watch', 'description' => 'High-end luxury timepieces for the discerning collector.', 'is_active' => true],
            ['name' => 'Sport Watch', 'slug' => 'sport-watch', 'description' => 'Durable watches built for active lifestyles and outdoor adventures.', 'is_active' => true],
            ['name' => 'Dress Watch', 'slug' => 'dress-watch', 'description' => 'Elegant slim watches designed for formal occasions.', 'is_active' => true],
            ['name' => 'Smartwatch', 'slug' => 'smartwatch', 'description' => 'Modern smartwatches combining technology with style.', 'is_active' => true],
            ['name' => 'Vintage Watch', 'slug' => 'vintage-watch', 'description' => 'Classic timepieces with timeless vintage appeal.', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
