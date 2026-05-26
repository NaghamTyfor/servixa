<?php

namespace Database\Seeders;

use App\Models\ActivityType;
use Illuminate\Database\Seeder;

class ActivityTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['ar' => 'مقاولات عامة',                     'en' => 'General Contracting'],
            ['ar' => 'مقاولات بناء',                     'en' => 'Building Construction'],
            ['ar' => 'مقاولات كهرباء',                   'en' => 'Electrical Contracting'],
            ['ar' => 'مقاولات سباكة',                    'en' => 'Plumbing Contracting'],
            ['ar' => 'مقاولات تشطيبات',                  'en' => 'Finishing Works'],
            ['ar' => 'مقاولات دهان',                      'en' => 'Painting Contracting'],
            ['ar' => 'مقاولات جبس وبلاستر',               'en' => 'Plaster & Gypsum'],
            ['ar' => 'مقاولات سيراميك ورخام',             'en' => 'Ceramic & Marble'],
            ['ar' => 'مقاولات حدادة',                     'en' => 'Metal Works'],
            ['ar' => 'مقاولات نجارة',                     'en' => 'Carpentry'],
            ['ar' => 'مقاولات زجاج ومرايا',               'en' => 'Glass & Mirrors'],
            ['ar' => 'مقاولات واجهات',                    'en' => 'Facades'],
            ['ar' => 'مقاولات عزل',                       'en' => 'Insulation'],
            ['ar' => 'مقاولات تدفئة وتكييف',              'en' => 'HVAC'],
            ['ar' => 'مقاولات مصاعد',                     'en' => 'Elevators'],
            ['ar' => 'مقاولات أمن وسلامة',                'en' => 'Safety & Security'],

            ['ar' => 'توريد مواد بناء',                   'en' => 'Building Materials Supply'],
            ['ar' => 'توريد سيراميك وبورسلان',            'en' => 'Ceramics Supply'],
            ['ar' => 'توريد رخام',                        'en' => 'Marble Supply'],
            ['ar' => 'توريد أخشاب',                       'en' => 'Wood Supply'],
            ['ar' => 'توريد حديد تسليح',                  'en' => 'Steel Reinforcement'],
            ['ar' => 'توريد أسمنت',                       'en' => 'Cement Supply'],
            ['ar' => 'توريد أدوات صحية',                  'en' => 'Sanitaryware'],
            ['ar' => 'توريد أدوات كهربائية',              'en' => 'Electrical Supplies'],
            ['ar' => 'توريد دهانات',                      'en' => 'Paints'],
            ['ar' => 'توريد زجاج',                        'en' => 'Glass Supply'],
            ['ar' => 'توريد مطابخ',                       'en' => 'Kitchens'],
            ['ar' => 'توريد أثاث',                        'en' => 'Furniture'],
            ['ar' => 'توريد إضاءة',                       'en' => 'Lighting'],
            ['ar' => 'توريد أبواب وشبابيك',               'en' => 'Doors & Windows'],
            ['ar' => 'توريد أنظمة ألمنيوم',                'en' => 'Aluminum Systems'],

            ['ar' => 'صيانة عامة',                        'en' => 'General Maintenance'],
            ['ar' => 'صيانة كهرباء',                      'en' => 'Electrical Maintenance'],
            ['ar' => 'صيانة سباكة',                       'en' => 'Plumbing Maintenance'],
            ['ar' => 'صيانة تكييف وتبريد',                'en' => 'AC & Refrigeration'],
            ['ar' => 'صيانة مصاعد',                       'en' => 'Elevator Maintenance'],
            ['ar' => 'صيانة منازل',                       'en' => 'Home Maintenance'],
            ['ar' => 'صيانة حدائق',                       'en' => 'Garden Maintenance'],
            ['ar' => 'صيانة مسابح',                       'en' => 'Pool Maintenance'],

            ['ar' => 'تنظيف عام',                         'en' => 'General Cleaning'],
            ['ar' => 'تنظيف منازل',                       'en' => 'House Cleaning'],
            ['ar' => 'تنظيف سجاد وموكيت',                 'en' => 'Carpet Cleaning'],
            ['ar' => 'تنظيف واجهات',                      'en' => 'Facade Cleaning'],
            ['ar' => 'تنظيف بعد البناء',                   'en' => 'Post-Construction Cleaning'],

            ['ar' => 'نقل أثاث',                          'en' => 'Furniture Moving'],
            ['ar' => 'تخزين',                             'en' => 'Storage Services'],
            ['ar' => 'تأجير معدات',                       'en' => 'Equipment Rental'],
            ['ar' => 'تأجير آليات',                       'en' => 'Machinery Rental'],

            ['ar' => 'استشارات هندسية',                   'en' => 'Engineering Consulting'],
            ['ar' => 'تصميم داخلي',                       'en' => 'Interior Design'],
            ['ar' => 'ديكور',                             'en' => 'Decoration'],
            ['ar' => 'تنسيق حدائق',                       'en' => 'Landscaping'],
            ['ar' => 'مساحة',                             'en' => 'Surveying'],
            ['ar' => 'تقييم عقاري',                       'en' => 'Property Valuation'],
            ['ar' => 'تسويق عقاري',                       'en' => 'Real Estate Marketing'],
            ['ar' => 'إدارة أملاك',                       'en' => 'Property Management'],
            ['ar' => 'وساطة عقارية',                      'en' => 'Real Estate Brokerage'],
            ['ar' => 'استثمار عقاري',                     'en' => 'Real Estate Investment'],
        ];

        foreach ($types as $type) {
            ActivityType::create([
                'name' => [
                    'ar' => $type['ar'],
                    'en' => $type['en'],
                ],
            ]);
        }
    }
}
