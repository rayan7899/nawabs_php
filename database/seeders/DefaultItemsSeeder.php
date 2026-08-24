<?php

namespace Database\Seeders;

use App\Enums\CategoryTypeEnum;
use App\Enums\ItemTypeEnum;
use App\Enums\ListStatusEnum;
use App\Enums\ListTypeEnum;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemList;
use Illuminate\Support\Facades\Auth;

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
                    'قرنبيط',
                    'بروكلي',
                    'كوسا',
                    'فاصوليا خضراء',
                    'كرنب',
                    'فجل',
                    'ذرة',
                    'زعتر',
                    'شبت',
                    'سفرجل',
                    'كراث',
                    'بازلاء',
                    'ريحان',
                    'خس',
                    'جرجير',
                    'بطاطا حلوة',
                    'كزبرة',
                    'نعناع',
                    'بطاطس',
                    'فلفل',
                    'طماطم',
                    'جزر',
                    'سبانخ',
                    'بقدونس',
                    'كرفس',
                    'ثوم',
                    'رجلة',
                    'خيار',
                    'شمندر',
                    'بصل',
                ]
            ],
            [
                'name' => 'فواكه',
                'color' => '#F97316',
                'items' => [
                    'مانجو',
                    'خوخ',
                    'تين',
                    'رمان',
                    'بطيخ',
                    'عنب',
                    'موز',
                    'جوافة',
                    'كيوي',
                    'ليمون اخضر',
                    'شمام',
                    'فراولة',
                    'أناناس',
                    'كمثرى',
                    'ليمون',
                    'تفاح 🍎',
                    'برتقال',
                    'تفاح',
                ]
            ],
            [
                'name' => 'منتجات الألبان',
                'color' => '#3B82F6',
                'items' => [
                    'حليب',
                    'لبن',
                    'جبنة',
                    'لبنه',
                    'زبادي',
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
            ],
            [
                'name' => 'أدوات المطبخ',
                'color' => '#EF4444',
                'items' => [
                    'قصدير',
                ]
            ],
            [
                'name' => 'حلويات',
                'color' => '#EF4444',
                'items' => [
                    'شوكولاتة',
                    'بسكويت',
                    'كعكة',
                ]
            ],
            [
                'name' => 'عناية شخصية',
                'color' => '#EF4444',
                'items' => [
                    'معجون أسنان',
                ]
            ],
            [
                'name' => 'مجمدات 🧊',
                'color' => '#EF4444',
                'items' => [
                    'ستربس',
                    'لحم مفروم',
                    'صدور دجاج',
                ]
            ],
            [
                'name' => 'مخبوزات',
                'color' => '#EF4444',
                'items' => [
                    'خبز',
                    'بيتزا',
                    'كرواسون',
                ]
            ],
            [
                'name' => 'مشروبات',
                'color' => '#EF4444',
                'items' => [
                    'ماء',
                    'شاي',
                    'مشروبات غازية',
                    'قهوة',
                    'عصير',
                ]
            ],
            [
                'name' => 'معلبات',
                'color' => '#EF4444',
                'items' => [
                    'فاصوليا',
                    'حمص',
                    'عدس',
                    'خضار مشكلة',
                    'زيتون',
                    'طماطم',
                    'بازلاء',
                    'سمك سردين',
                    'سمك تونة',
                    'صلصة',
                    'ذرة',
                    'فطر',
                ]
            ],
            [
                'name' => 'منظفات 🧼',
                'color' => '#EF4444',
                'items' => [
                    'صابون الوزير',
                    'صابون يدين',
                    'صابون مواعين',
                    'مناديل',
                    'الأسفنجة العجيبة',
                    'صابون ملابس',
                    'ملح غسالة المواعين',
                ]
            ],
            [
                'name' => 'مواد غذائية',
                'color' => '#EF4444',
                'items' => [
                    'مايونيز',
                    'عسل',
                    'كاتشب',
                    'بيض',
                    'شطة',
                    'بيض السمان 🪺',
                    'طحين',
                    'سماق',
                    'سكر',
                    'شاهي لبتون',
                ]
            ],
        ];

        $list = ItemList::create([
            'name'          => __("My List"),
            'type'          => ListTypeEnum::DEFAULT->value,
            'status'        => ListStatusEnum::ACTIVE->value,
            'created_by'    => Auth::id(),
        ]);
        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name'          => $categoryData['name'],
                'color'         => $categoryData['color'],
                'type'          => CategoryTypeEnum::DEFAULT->value,
                'list_id'       => $list->id,
                'created_by'    => Auth::id(),
            ]);

            // Create items for this category
            foreach ($categoryData['items'] as $itemName) {
                Item::create([
                    'name'          => $itemName,
                    'category_id'   => $category->id,
                    'type'          => ItemTypeEnum::DEFAULT->value,
                    'created_by'    => Auth::id(),
                ]);
            }
        }
    }
}
