<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Item;

class DefaultItemsSeeder extends Seeder
{
    public function run(): void
    {
        // Create default categories
        $categories = [
            [
                'name' => 'خضروات',
                'color' => '#22C55E',
                'items' => [
                    'طماطم',
                    'خيار',
                    'بصل',
                    'بطاطس',
                    'جزر'
                ]
            ],
            [
                'name' => 'فواكه',
                'color' => '#F97316',
                'items' => [
                    'تفاح',
                    'موز',
                    'برتقال',
                    'عنب',
                    'مانجو'
                ]
            ],
            [
                'name' => 'منتجات الألبان',
                'color' => '#3B82F6',
                'items' => [
                    'حليب',
                    'جبن',
                    'زبادي',
                    'لبن',
                    'زبدة'
                ]
            ],
            [
                'name' => 'لحوم',
                'color' => '#EF4444',
                'items' => [
                    'دجاج',
                    'لحم',
                    'سمك',
                    'برجر'
                ]
            ]
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'color' => $categoryData['color']
            ]);

            // Create items for this category
            foreach ($categoryData['items'] as $itemName) {
                Item::create([
                    'name' => $itemName,
                    'category_id' => $category->id,
                    'private' => false,
                    'active' => false
                ]);
            }
        }
    }
}