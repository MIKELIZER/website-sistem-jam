<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $luxury    = Category::where('slug', 'luxury-watch')->first();
        $sport     = Category::where('slug', 'sport-watch')->first();
        $dress     = Category::where('slug', 'dress-watch')->first();
        $smart     = Category::where('slug', 'smartwatch')->first();
        $vintage   = Category::where('slug', 'vintage-watch')->first();

        $products = [
            // Luxury
            [
                'category_id' => $luxury->id,
                'name'        => 'Audemars Royal Oak Gold',
                'brand'       => 'Audemars Piguet',
                'slug'        => 'audemars-royal-oak-gold',
                'description' => 'Iconic octagonal bezel with integrated bracelet in 18k yellow gold. A symbol of luxury watchmaking.',
                'price'       => 85000000,
                'stock'       => 5,
                'is_active'   => true,
            ],
            [
                'category_id' => $luxury->id,
                'name'        => 'Patek Philippe Calatrava',
                'brand'       => 'Patek Philippe',
                'slug'        => 'patek-philippe-calatrava',
                'description' => 'The quintessential dress watch from Patek Philippe, featuring a clean white dial and elegant rose gold case.',
                'price'       => 120000000,
                'stock'       => 3,
                'is_active'   => true,
            ],
            [
                'category_id' => $luxury->id,
                'name'        => 'Rolex Datejust 41',
                'brand'       => 'Rolex',
                'slug'        => 'rolex-datejust-41',
                'description' => 'A watch of distinction — Rolex Datejust 41 in Oystersteel with fluted bezel and Jubilee bracelet.',
                'price'       => 95000000,
                'stock'       => 8,
                'is_active'   => true,
            ],
            // Sport
            [
                'category_id' => $sport->id,
                'name'        => 'Rolex Submariner Date',
                'brand'       => 'Rolex',
                'slug'        => 'rolex-submariner-date',
                'description' => 'The iconic diver\'s watch with 300m water resistance and unidirectional rotatable bezel.',
                'price'       => 110000000,
                'stock'       => 10,
                'is_active'   => true,
            ],
            [
                'category_id' => $sport->id,
                'name'        => 'Tag Heuer Aquaracer',
                'brand'       => 'TAG Heuer',
                'slug'        => 'tag-heuer-aquaracer',
                'description' => 'Professional 300m water resistance with a bold sporty design for diving enthusiasts.',
                'price'       => 15000000,
                'stock'       => 15,
                'is_active'   => true,
            ],
            [
                'category_id' => $sport->id,
                'name'        => 'Casio G-Shock GW-9400',
                'brand'       => 'Casio',
                'slug'        => 'casio-g-shock-gw-9400',
                'description' => 'Triple sensor Rangeman with GPS solar charging. Built to handle extreme environments.',
                'price'       => 3500000,
                'stock'       => 30,
                'is_active'   => true,
            ],
            // Dress
            [
                'category_id' => $dress->id,
                'name'        => 'Jaeger-LeCoultre Master Ultra Thin',
                'brand'       => 'Jaeger-LeCoultre',
                'slug'        => 'jlc-master-ultra-thin',
                'description' => 'Impossibly thin at just 5.9mm, this watch sets the standard for elegant dress wear.',
                'price'       => 55000000,
                'stock'       => 4,
                'is_active'   => true,
            ],
            [
                'category_id' => $dress->id,
                'name'        => 'Longines Elegant Collection',
                'brand'       => 'Longines',
                'slug'        => 'longines-elegant-collection',
                'description' => 'Swiss elegance at its finest with diamond-set bezel and mother-of-pearl dial.',
                'price'       => 8500000,
                'stock'       => 12,
                'is_active'   => true,
            ],
            // Smartwatch
            [
                'category_id' => $smart->id,
                'name'        => 'Apple Watch Ultra 2',
                'brand'       => 'Apple',
                'slug'        => 'apple-watch-ultra-2',
                'description' => 'The most rugged and capable Apple Watch ever, with titanium case and Action Button.',
                'price'       => 12500000,
                'stock'       => 20,
                'is_active'   => true,
            ],
            [
                'category_id' => $smart->id,
                'name'        => 'Garmin Fenix 7 Pro',
                'brand'       => 'Garmin',
                'slug'        => 'garmin-fenix-7-pro',
                'description' => 'Ultimate multisport GPS smartwatch with solar charging and advanced performance metrics.',
                'price'       => 9500000,
                'stock'       => 18,
                'is_active'   => true,
            ],
            // Vintage
            [
                'category_id' => $vintage->id,
                'name'        => 'Omega Seamaster 300 Heritage',
                'brand'       => 'Omega',
                'slug'        => 'omega-seamaster-300-heritage',
                'description' => 'Inspired by the original 1957 Seamaster 300, this re-edition celebrates Omega\'s diving heritage.',
                'price'       => 35000000,
                'stock'       => 6,
                'is_active'   => true,
            ],
            [
                'category_id' => $vintage->id,
                'name'        => 'Seiko Presage SPB143',
                'brand'       => 'Seiko',
                'slug'        => 'seiko-presage-spb143',
                'description' => 'Arita porcelain dial with automaticmovement, inspired by traditional Japanese craftsmanship.',
                'price'       => 6500000,
                'stock'       => 22,
                'is_active'   => true,
            ],
        ];

        foreach ($products as $data) {
            Product::create($data);
        }
    }
}
