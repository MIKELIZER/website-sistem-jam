<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        // Map product slug => high-quality Unsplash watch image URL
        $images = [
            'audemars-royal-oak-gold'   => 'https://images.unsplash.com/photo-1587836374828-4dbafa94cf0e?w=600&q=80',
            'patek-philippe-calatrava'  => 'https://images.unsplash.com/photo-1548169874-53e85f753f1e?w=600&q=80',
            'rolex-datejust-41'         => 'https://images.unsplash.com/photo-1623998022290-a74f8cc36563?w=600&q=80',
            'rolex-submariner-date'     => 'https://images.unsplash.com/photo-1612817288484-6f916006741a?w=600&q=80',
            'tag-heuer-aquaracer'       => 'https://images.unsplash.com/photo-1614164185128-e4ec99c436d7?w=600&q=80',
            'casio-g-shock-gw-9400'     => 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=600&q=80',
            'jlc-master-ultra-thin'     => 'https://images.unsplash.com/photo-1600003014755-ba31aa59c4b6?w=600&q=80',
            'longines-elegant-collection' => 'https://images.unsplash.com/photo-1619134778706-7015533a6150?w=600&q=80',
            'apple-watch-ultra-2'       => 'https://images.unsplash.com/photo-1551816230-ef5deaed4a26?w=600&q=80',
            'garmin-fenix-7-pro'        => 'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=600&q=80',
            'omega-seamaster-300-heritage' => 'https://images.unsplash.com/photo-1585123334904-845d60e97b29?w=600&q=80',
            'seiko-presage-spb143'      => 'https://images.unsplash.com/photo-1434056886845-dac89ffe9b56?w=600&q=80',
        ];

        foreach ($images as $slug => $url) {
            $product = Product::where('slug', $slug)->first();
            if (!$product) continue;

            // Skip if already has an image
            if ($product->images()->exists()) continue;

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $url,
                'is_primary' => true,
            ]);
        }
    }
}
