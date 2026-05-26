<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\DynamicField;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class CategoriesAndDynamicFieldsSeeder extends Seeder
{

    public function run(): void
    {
        $categories = [
            'construction' => ['ar' => 'مقاولات وبناء', 'en' => 'Construction & Building'],
            'cleaning'     => ['ar' => 'تنظيف', 'en' => 'Cleaning'],
            'moving'       => ['ar' => 'نقل عفش', 'en' => 'Moving & Relocation'],
            'maintenance'  => ['ar' => 'صيانة وإصلاح', 'en' => 'Maintenance & Repair'],
            'education'    => ['ar' => 'تعليم وتدريب', 'en' => 'Education & Training'],
            'health'       => ['ar' => 'صحة وطب', 'en' => 'Health & Medicine'],
            'beauty'       => ['ar' => 'جمال وعناية', 'en' => 'Beauty & Care'],
            'it'           => ['ar' => 'تقنية معلومات', 'en' => 'Information Technology'],
            'legal'        => ['ar' => 'خدمات قانونية', 'en' => 'Legal Services'],
            'finance'      => ['ar' => 'استشارات مالية', 'en' => 'Financial Consulting'],
        ];

        foreach ($categories as $key => $name) {
            Category::create(['name' => $name]);
        }

        $subCategoriesData = [
            'construction' => [
                ['ar' => 'بناء تشطيب', 'en' => 'Finishing Construction'],
                ['ar' => 'ترميم', 'en' => 'Renovation'],
                ['ar' => 'هندسة ديكور', 'en' => 'Interior Design'],
            ],
            'cleaning' => [
                ['ar' => 'تنظيف منازل', 'en' => 'Home Cleaning'],
                ['ar' => 'تنظيف خزانات', 'en' => 'Water Tank Cleaning'],
                ['ar' => 'تعقيم', 'en' => 'Disinfection'],
            ],
            'moving' => [
                ['ar' => 'نقل داخل المدينة', 'en' => 'Local Moving'],
                ['ar' => 'نقل بين المدن', 'en' => 'Intercity Moving'],
            ],
            'maintenance' => [
                ['ar' => 'صيانة أجهزة كهربائية', 'en' => 'Electrical Appliances Repair'],
                ['ar' => 'صيانة مكيفات', 'en' => 'AC Maintenance'],
            ],
            'education' => [
                ['ar' => 'دورات أونلاين', 'en' => 'Online Courses'],
                ['ar' => 'تدريب مهني', 'en' => 'Vocational Training'],
            ],

            'health' => [
                ['ar' => 'استشارات طبية', 'en' => 'Medical Consultations'],
                ['ar' => 'علاج طبيعي', 'en' => 'Physiotherapy'],
            ],
            'beauty' => [
                ['ar' => 'صالون نسائي', 'en' => 'Women Salon'],
                ['ar' => 'عناية رجالية', 'en' => 'Men Grooming'],
            ],
            'it' => [
                ['ar' => 'تطوير تطبيقات', 'en' => 'App Development'],
                ['ar' => 'تصميم مواقع', 'en' => 'Web Design'],
            ],
            'legal' => [
                ['ar' => 'استشارات قانونية', 'en' => 'Legal Advice'],
                ['ar' => 'صياغة عقود', 'en' => 'Contract Drafting'],
            ],
            'finance' => [
                ['ar' => 'محاسبة', 'en' => 'Accounting'],
                ['ar' => 'تخطيط مالي', 'en' => 'Financial Planning'],
            ],
        ];

        $createdSubCategories = [];

        foreach ($subCategoriesData as $categoryKey => $subs) {
            $category = Category::where('name->en', $categories[$categoryKey]['en'])->first();
            if ($category) {
                foreach ($subs as $subName) {
                    $sub = SubCategory::create([
                        'category_id' => $category->id,
                        'name' => $subName,
                    ]);
                    $createdSubCategories[] = $sub;
                }
            }
        }

        $createField = function($owner, $nameAr, $nameEn, $type, $options = null, $isRequired = false) {
            $data = [
                'name' => ['ar' => $nameAr, 'en' => $nameEn],
                'type' => $type,
                'is_required' => $isRequired,
            ];
            if ($options) {
                $data['options'] = $options;
            }
            return $owner->dynamicFields()->create($data);
        };


        $constructionCat = Category::where('name->en', 'Construction & Building')->first();
        if ($constructionCat) {
            $createField($constructionCat, 'نوع المبنى', 'Building Type', 'select', [
                ['label' => ['ar' => 'سكني', 'en' => 'Residential']],
                ['label' => ['ar' => 'تجاري', 'en' => 'Commercial']],
                ['label' => ['ar' => 'صناعي', 'en' => 'Industrial']],
            ], true);
            $createField($constructionCat, 'المساحة (م²)', 'Area (sqm)', 'number', null, true);
        }

        $cleaningCat = Category::where('name->en', 'Cleaning')->first();
        if ($cleaningCat) {
            $createField($cleaningCat, 'نوع السطح', 'Surface Type', 'select', [
                ['label' => ['ar' => 'سيراميك', 'en' => 'Ceramic']],
                ['label' => ['ar' => 'باركيه', 'en' => 'Parquet']],
                ['label' => ['ar' => 'سجاد', 'en' => 'Carpet']],
            ], false);
        }

        $movingCat = Category::where('name->en', 'Moving & Relocation')->first();
        if ($movingCat) {
            $createField($movingCat, 'تفاصيل الأثاث', 'Furniture Details', 'textarea', null, false);
        }

        $maintenanceCat = Category::where('name->en', 'Maintenance & Repair')->first();
        if ($maintenanceCat) {
            $createField($maintenanceCat, 'نوع الجهاز', 'Device Type', 'select', [
                ['label' => ['ar' => 'ثلاجة', 'en' => 'Refrigerator']],
                ['label' => ['ar' => 'غسالة', 'en' => 'Washing Machine']],
                ['label' => ['ar' => 'مكيف', 'en' => 'Air Conditioner']],
                ['label' => ['ar' => 'فرن', 'en' => 'Oven']],
            ], true);
        }

        $educationCat = Category::where('name->en', 'Education & Training')->first();
        if ($educationCat) {
            $createField($educationCat, 'تاريخ البدء', 'Start Date', 'date', null, true);
        }

        $healthCat = Category::where('name->en', 'Health & Medicine')->first();
        if ($healthCat) {
            $createField($healthCat, 'التخصص الطبي', 'Medical Specialty', 'select', [
                ['label' => ['ar' => 'قلبية', 'en' => 'Cardiology']],
                ['label' => ['ar' => 'جلدية', 'en' => 'Dermatology']],
                ['label' => ['ar' => 'عظام', 'en' => 'Orthopedics']],
                ['label' => ['ar' => 'أطفال', 'en' => 'Pediatrics']],
            ], true);
        }

        $beautyCat = Category::where('name->en', 'Beauty & Care')->first();
        if ($beautyCat) {
            $createField($beautyCat, 'الخدمة المطلوبة', 'Service Needed', 'text', null, true);
        }

        $itCat = Category::where('name->en', 'Information Technology')->first();
        if ($itCat) {
            $createField($itCat, 'نوع المشروع', 'Project Type', 'select', [
                ['label' => ['ar' => 'موقع إلكتروني', 'en' => 'Website']],
                ['label' => ['ar' => 'تطبيق جوال', 'en' => 'Mobile App']],
                ['label' => ['ar' => 'برمجية مخصصة', 'en' => 'Custom Software']],
            ], true);
            $createField($itCat, 'الميزانية التقريبية ($)', 'Budget (USD)', 'number', null, false);
        }

        $legalCat = Category::where('name->en', 'Legal Services')->first();
        if ($legalCat) {
            $createField($legalCat, 'نوع الخدمة القانونية', 'Legal Service Type', 'select', [
                ['label' => ['ar' => 'استشارة', 'en' => 'Consultation']],
                ['label' => ['ar' => 'محاماة قضائية', 'en' => 'Litigation']],
                ['label' => ['ar' => 'صياغة عقود', 'en' => 'Contract Drafting']],
            ], true);
        }

        $financeCat = Category::where('name->en', 'Financial Consulting')->first();
        if ($financeCat) {
            $createField($financeCat, 'نوع الاستشارة', 'Consultation Type', 'select', [
                ['label' => ['ar' => 'ضريبي', 'en' => 'Tax']],
                ['label' => ['ar' => 'محاسبي', 'en' => 'Accounting']],
                ['label' => ['ar' => 'استثماري', 'en' => 'Investment']],
            ], true);
        }


        $finishingSub = SubCategory::where('name->en', 'Finishing Construction')->first();
        if ($finishingSub) {
            $createField($finishingSub, 'نوع التشطيب', 'Finishing Type', 'select', [
                ['label' => ['ar' => 'ديلوكس', 'en' => 'Deluxe']],
                ['label' => ['ar' => 'سوبر لوكس', 'en' => 'Super Lux']],
                ['label' => ['ar' => 'اقتصادي', 'en' => 'Economic']],
            ], true);
        }

        $tankCleaningSub = SubCategory::where('name->en', 'Water Tank Cleaning')->first();
        if ($tankCleaningSub) {
            $createField($tankCleaningSub, 'سعة الخزان (لتر)', 'Tank Capacity (Liters)', 'number', null, true);
            $createField($tankCleaningSub, 'هل يحتاج تعقيم؟', 'Need Disinfection?', 'select', [
                ['label' => ['ar' => 'نعم', 'en' => 'Yes']],
                ['label' => ['ar' => 'لا', 'en' => 'No']],
            ], false);
        }

        $localMovingSub = SubCategory::where('name->en', 'Local Moving')->first();
        if ($localMovingSub) {
            $createField($localMovingSub, 'عدد الغرف', 'Number of Rooms', 'number', null, true);
            $createField($localMovingSub, 'هل يوجد أثاث ثقيل؟', 'Heavy Furniture?', 'select', [
                ['label' => ['ar' => 'نعم', 'en' => 'Yes']],
                ['label' => ['ar' => 'لا', 'en' => 'No']],
            ], false);
        }

        $acMaintenanceSub = SubCategory::where('name->en', 'AC Maintenance')->first();
        if ($acMaintenanceSub) {
            $createField($acMaintenanceSub, 'نوع المكيف', 'AC Type', 'select', [
                ['label' => ['ar' => 'شباك', 'en' => 'Window']],
                ['label' => ['ar' => 'سبليت', 'en' => 'Split']],
                ['label' => ['ar' => 'مركزي', 'en' => 'Central']],
            ], true);
            $createField($acMaintenanceSub, 'الفحص المطلوب', 'Required Check', 'textarea', null, false);
        }

        $appDevSub = SubCategory::where('name->en', 'App Development')->first();
        if ($appDevSub) {
            $createField($appDevSub, 'نظام التشغيل', 'Operating System', 'select', [
                ['label' => ['ar' => 'iOS', 'en' => 'iOS']],
                ['label' => ['ar' => 'Android', 'en' => 'Android']],
                ['label' => ['ar' => 'كلا النظامين', 'en' => 'Both']],
            ], true);
        }

        $legalAdviceSub = SubCategory::where('name->en', 'Legal Advice')->first();
        if ($legalAdviceSub) {
            $createField($legalAdviceSub, 'المجال القانوني', 'Legal Field', 'select', [
                ['label' => ['ar' => 'عمالي', 'en' => 'Labor']],
                ['label' => ['ar' => 'أسري', 'en' => 'Family']],
                ['label' => ['ar' => 'جنائي', 'en' => 'Criminal']],
                ['label' => ['ar' => 'مدني', 'en' => 'Civil']],
            ], true);
        }

        $accountingSub = SubCategory::where('name->en', 'Accounting')->first();
        if ($accountingSub) {
            $createField($accountingSub, 'نوع الخدمة المحاسبية', 'Accounting Service Type', 'select', [
                ['label' => ['ar' => 'مسك دفاتر', 'en' => 'Bookkeeping']],
                ['label' => ['ar' => 'إقرارات ضريبية', 'en' => 'Tax Returns']],
                ['label' => ['ar' => 'مراجعة حسابات', 'en' => 'Auditing']],
            ], true);
            $createField($accountingSub, 'عدد المعاملات الشهرية', 'Monthly Transactions Count', 'number', null, false);
        }

        $webDesignSub = SubCategory::where('name->en', 'Web Design')->first();
        if ($webDesignSub) {
            $createField($webDesignSub, 'نوع الموقع', 'Website Type', 'select', [
                ['label' => ['ar' => 'شركة', 'en' => 'Corporate']],
                ['label' => ['ar' => 'متجر إلكتروني', 'en' => 'E-commerce']],
                ['label' => ['ar' => 'مدونة', 'en' => 'Blog']],
                ['label' => ['ar' => 'بوابة خدمية', 'en' => 'Service Portal']],
            ], true);
            $createField($webDesignSub, 'عدد الصفحات المتوقع', 'Expected Pages', 'number', null, true);
        }

        $this->command->info('تم إنشاء التصنيفات الرئيسية والفرعية والحقول الديناميكية بنجاح.');
    }
}
