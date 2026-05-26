<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            ['ar' => 'دمشق',                 'en' => 'Damascus'],
            ['ar' => 'ريف دمشق',              'en' => 'Rural Damascus'],
            ['ar' => 'حلب',                  'en' => 'Aleppo'],
            ['ar' => 'حمص',                  'en' => 'Homs'],
            ['ar' => 'حماه',                 'en' => 'Hama'],
            ['ar' => 'اللاذقية',              'en' => 'Latakia'],
            ['ar' => 'طرطوس',                'en' => 'Tartus'],
            ['ar' => 'دير الزور',             'en' => 'Deir ez-Zor'],
            ['ar' => 'الرقة',                 'en' => 'Raqqa'],
            ['ar' => 'الحسكة',                'en' => 'Hasakah'],
            ['ar' => 'درعا',                  'en' => 'Daraa'],
            ['ar' => 'السويداء',              'en' => 'Suwayda'],
            ['ar' => 'القنيطرة',              'en' => 'Quneitra'],
            ['ar' => 'إدلب',                  'en' => 'Idlib'],


            ['ar' => 'جرمانا',                'en' => 'Jaramana'],
            ['ar' => 'دوما',                  'en' => 'Douma'],
            ['ar' => 'حرستا',                 'en' => 'Harasta'],
            ['ar' => 'داريا',                 'en' => 'Dariya'],
            ['ar' => 'قطنا',                  'en' => 'Qatana'],
            ['ar' => 'التل',                  'en' => 'Al-Tall'],
            ['ar' => 'النبك',                 'en' => 'Al-Nabk'],
            ['ar' => 'يبرود',                 'en' => 'Yabroud'],
            ['ar' => 'الزبداني',               'en' => 'Al-Zabadani'],

            ['ar' => 'منبج',                  'en' => 'Manbij'],
            ['ar' => 'الباب',                 'en' => 'Al-Bab'],
            ['ar' => 'عفرين',                 'en' => 'Afrin'],
            ['ar' => 'عين العرب',              'en' => 'Kobani'],

            ['ar' => 'تدمر',                  'en' => 'Palmyra'],
            ['ar' => 'القصير',                'en' => 'Al-Qusayr'],
            ['ar' => 'تلبيسة',                'en' => 'Talbiseh'],

            ['ar' => 'سلمية',                 'en' => 'Salamiyah'],
            ['ar' => 'مصياف',                 'en' => 'Masyaf'],
            ['ar' => 'محردة',                 'en' => 'Mahardah'],

            ['ar' => 'جبلة',                  'en' => 'Jableh'],
            ['ar' => 'القرداحة',              'en' => 'Qardaha'],
            ['ar' => 'الحفة',                 'en' => 'Al-Haffah'],

            ['ar' => 'بانياس',                'en' => 'Baniyas'],
            ['ar' => 'صافيتا',                'en' => 'Safita'],
            ['ar' => 'دركيش',                 'en' => 'Dreikish'],

            ['ar' => 'البوكمال',              'en' => 'Abu Kamal'],
            ['ar' => 'الميادين',              'en' => 'Al-Mayadin'],

            ['ar' => 'الطبقة',                'en' => 'Al-Thawrah'],
            ['ar' => 'تل أبيض',               'en' => 'Tal Abyad'],

            ['ar' => 'القامشلي',              'en' => 'Qamishli'],
            ['ar' => 'المالكية',              'en' => 'Al-Malikiyah'],

            ['ar' => 'صنمين',                 'en' => 'Sanamayn'],
            ['ar' => 'إزرع',                  'en' => 'Izra'],
            ['ar' => 'نوى',                   'en' => 'Nawa'],

            ['ar' => 'شهبا',                  'en' => 'Shahba'],
            ['ar' => 'صلخد',                  'en' => 'Salkhad'],
        ];

        foreach ($cities as $city) {
            City::create([
                'name' => [
                    'ar' => $city['ar'],
                    'en' => $city['en'],
                ],
            ]);
        }
    }
}

