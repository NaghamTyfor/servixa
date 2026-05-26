<?php

namespace Database\Seeders;

use App\Models\BusinessAccount;
use App\Models\Category;
use App\Models\DynamicField;
use App\Models\Service;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        if (BusinessAccount::count() === 0) {
            $this->call(BusinessAccountsSeeder::class);
        }

        $servicesData = [
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('أحمد', 'علي'),
                'category_name_ar' => 'مقاولات وبناء',
                'sub_category_name_ar' => 'بناء تشطيب',
                'title_ar' => 'تشطيب شقة 150 متر في دمشق',
                'title_en' => 'Finishing 150 sqm Apartment in Damascus',
                'description_ar' => 'نقوم بتشطيب الشقق السكنية بأعلى جودة. شامل الدهانات، السيراميك، السباكة، الكهرباء.',
                'description_en' => 'High-quality apartment finishing. Includes painting, tiling, plumbing, electricity.',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 250000000,
                'price_usd' => null,
                'lat' => '33.5138',
                'lng' => '36.2765',
                'dynamic_fields' => [
                    'نوع المبنى' => 'سكني',
                    'المساحة (م²)' => '150',
                ],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('سارة', 'حسن'),
                'category_name_ar' => 'مقاولات وبناء',
                'sub_category_name_ar' => null,
                'title_ar' => 'تصميم داخلي لفيلا في دمشق',
                'title_en' => 'Interior Design for a Villa in Damascus',
                'description_ar' => 'تصميم داخلي حديث مع تقديم خرائط تنفيذية وجداول أثاث.',
                'description_en' => 'Modern interior design with execution plans and furniture schedules.',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 15000000,
                'price_usd' => 500,
                'lat' => '33.5120',
                'lng' => '36.2900',
                'dynamic_fields' => [],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('محمد', 'خالد'),
                'category_name_ar' => 'مقاولات وبناء',
                'sub_category_name_ar' => 'بناء تشطيب',
                'title_ar' => 'بناء فيلا في حلب مساحة 300 متر',
                'title_en' => 'Villa Construction in Aleppo 300 sqm',
                'description_ar' => 'بناء فيلا سكنية بتصميم عصري، مع التشطيبات اللازمة.',
                'description_en' => 'Modern villa construction with finishing.',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 450000000,
                'price_usd' => null,
                'lat' => '36.2025',
                'lng' => '37.1343',
                'dynamic_fields' => [
                    'نوع المبنى' => 'سكني',
                    'المساحة (م²)' => '300',
                ],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('نور', 'حسين'),
                'category_name_ar' => 'مقاولات وبناء',
                'sub_category_name_ar' => null,
                'title_ar' => 'توريد حديد تسليح بكميات كبيرة',
                'title_en' => 'Supply of large quantities of rebar',
                'description_ar' => 'توريد حديد تسليح بأقطار مختلفة (8-32 مم) بأسعار تنافسية.',
                'description_en' => 'Supply of rebar diameters 8-32 mm at competitive prices.',
                'quantity' => 100,
                'service_type' => 'sale',
                'price_syp' => 50000000,
                'price_usd' => null,
                'lat' => '36.2100',
                'lng' => '37.1450',
                'dynamic_fields' => [],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('عمر', 'أحمد'),
                'category_name_ar' => 'صيانة وإصلاح',
                'sub_category_name_ar' => 'صيانة أجهزة كهربائية',
                'title_ar' => 'صيانة غسالات في حمص',
                'title_en' => 'Washing Machine Repair in Homs',
                'description_ar' => 'إصلاح جميع أنواع الغسالات الأوتوماتيكية والنصف أوتوماتيك.',
                'description_en' => 'Repair all types of automatic and semi-automatic washing machines.',
                'quantity' => 10,
                'service_type' => 'sale',
                'price_syp' => 500000,
                'price_usd' => null,
                'lat' => '34.7328',
                'lng' => '36.7150',
                'dynamic_fields' => [
                    'نوع الجهاز' => 'غسالة',
                ],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('لينا', 'محمود'),
                'category_name_ar' => 'تنظيف',
                'sub_category_name_ar' => 'تنظيف منازل',
                'title_ar' => 'تنظيف شامل لفيلا في حمص',
                'title_en' => 'Comprehensive Villa Cleaning in Homs',
                'description_ar' => 'تنظيف شامل للفيلا (غسيل سجاد، تنظيف واجهات، تعقيم).',
                'description_en' => 'Complete villa cleaning (carpet washing, facade cleaning, disinfection).',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 300000,
                'price_usd' => 10,
                'lat' => '34.7250',
                'lng' => '36.7100',
                'dynamic_fields' => [
                    'نوع السطح' => 'سيراميك',
                ],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('حسان', 'ناصر'),
                'category_name_ar' => 'صيانة وإصلاح',
                'sub_category_name_ar' => 'صيانة أجهزة كهربائية',
                'title_ar' => 'تركيب شبكة كهربائية لمنزل بحماه',
                'title_en' => 'Electrical Network Installation for a House in Hama',
                'description_ar' => 'تركيب كامل للشبكة الكهربائية مع لوحات توزيع وتأريض.',
                'description_en' => 'Complete electrical network installation with distribution panels and grounding.',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 2000000,
                'price_usd' => 70,
                'lat' => '35.1318',
                'lng' => '36.7531',
                'dynamic_fields' => [
                    'نوع الجهاز' => 'ثلاجة',
                ],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('رنا', 'عبد الله'),
                'category_name_ar' => 'مقاولات وبناء',
                'sub_category_name_ar' => null,
                'title_ar' => 'توريد خلاطات وأدوات صحية ماركة عالمية',
                'title_en' => 'Supply of international brand mixers and sanitaryware',
                'description_ar' => 'توريد خلاطات مياه، أحواض، مراحيض، مع ضمان سنتين.',
                'description_en' => 'Supply of water mixers, sinks, toilets with 2-year warranty.',
                'quantity' => 50,
                'service_type' => 'sale',
                'price_syp' => 15000000,
                'price_usd' => null,
                'lat' => '35.1350',
                'lng' => '36.7500',
                'dynamic_fields' => [],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('باسل', 'أيوب'),
                'category_name_ar' => 'مقاولات وبناء',
                'sub_category_name_ar' => 'بناء تشطيب',
                'title_ar' => 'تشطيب فاخر لشقة في اللاذقية',
                'title_en' => 'Luxury Finishing for an Apartment in Latakia',
                'description_ar' => 'استخدام أفضل المواد في التشطيبات (رخام، باركيه، دهانات عالية الجودة).',
                'description_en' => 'Using best finishing materials (marble, parquet, high-quality paints).',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 350000000,
                'price_usd' => null,
                'lat' => '35.5231',
                'lng' => '35.7895',
                'dynamic_fields' => [
                    'نوع المبنى' => 'سكني',
                    'المساحة (م²)' => '180',
                ],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('هدى', 'رفاعي'),
                'category_name_ar' => 'مقاولات وبناء',
                'sub_category_name_ar' => null,
                'title_ar' => 'تصميم داخلي لمكتب في اللاذقية',
                'title_en' => 'Office Interior Design in Latakia',
                'description_ar' => 'تصميم عصري لمكاتب الشركات مع تنفيذ كامل.',
                'description_en' => 'Modern office design for companies with full execution.',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 20000000,
                'price_usd' => 700,
                'lat' => '35.5280',
                'lng' => '35.7820',
                'dynamic_fields' => [],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('جورج', 'ملحم'),
                'category_name_ar' => 'صيانة وإصلاح',
                'sub_category_name_ar' => 'صيانة مكيفات',
                'title_ar' => 'صيانة مكيف سبليت في طرطوس',
                'title_en' => 'Split AC Maintenance in Tartus',
                'description_ar' => 'تنظيف وتعبئة غاز وصيانة دورية للمكيفات.',
                'description_en' => 'Cleaning, gas refilling, and periodic AC maintenance.',
                'quantity' => 5,
                'service_type' => 'sale',
                'price_syp' => 300000,
                'price_usd' => null,
                'lat' => '34.8867',
                'lng' => '35.8867',
                'dynamic_fields' => [
                    'نوع المكيف' => 'سبليت',
                    'الفحص المطلوب' => 'تنظيف شامل وفحص كمبروسر',
                ],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('ماري', 'عون'),
                'category_name_ar' => 'تنظيف',
                'sub_category_name_ar' => null,
                'title_ar' => 'تنظيف واجهات زجاجية لمبنى في طرطوس',
                'title_en' => 'Glass Facade Cleaning for a Building in Tartus',
                'description_ar' => 'استخدام تقنيات التسلق والرافعات لتنظيف الواجهات الزجاجية.',
                'description_en' => 'Using climbing techniques and lifts to clean glass facades.',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 1000000,
                'price_usd' => 35,
                'lat' => '34.8800',
                'lng' => '35.8900',
                'dynamic_fields' => [
                    'نوع السطح' => 'زجاج',
                ],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('إبراهيم', 'العبد'),
                'category_name_ar' => 'مقاولات وبناء',
                'sub_category_name_ar' => null,
                'title_ar' => 'توريد أثاث منزلي كامل لدير الزور',
                'title_en' => 'Supply of Complete Home Furniture in Deir ez-Zor',
                'description_ar' => 'غرف نوم، صالونات، مطابخ، بأسعار منافسة.',
                'description_en' => 'Bedrooms, living rooms, kitchens at competitive prices.',
                'quantity' => 10,
                'service_type' => 'sale',
                'price_syp' => 50000000,
                'price_usd' => null,
                'lat' => '35.3363',
                'lng' => '40.1395',
                'dynamic_fields' => [],
            ],
            // 14: خالد الداوود (مقاولات سباكة) -> لا يوجد تصنيف فرعي للسباكة في سيدر التصنيفات، نستخدم التصنيف الرئيسي "صيانة وإصلاح"
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('خالد', 'الداوود'),
                'category_name_ar' => 'صيانة وإصلاح',
                'sub_category_name_ar' => null,
                'title_ar' => 'تركيب شبكة سباكة لمنزل بالرقة',
                'title_en' => 'Plumbing Network Installation for a House in Raqqa',
                'description_ar' => 'تركيب شبكة مياه وصرف صحي مع تدفئة مركزية.',
                'description_en' => 'Installation of water and sewage network with central heating.',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 3000000,
                'price_usd' => 100,
                'lat' => '35.9528',
                'lng' => '39.0297',
                'dynamic_fields' => [],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('سمير', 'عوني'),
                'category_name_ar' => 'مقاولات وبناء',
                'sub_category_name_ar' => null,
                'title_ar' => 'عزل أسطح خزانات في الحسكة',
                'title_en' => 'Roof and Tank Waterproofing in Hasakah',
                'description_ar' => 'عزل مائي وحراري باستخدام مواد عالية الجودة.',
                'description_en' => 'Water and thermal insulation using high-quality materials.',
                'quantity' => 500,
                'service_type' => 'sale',
                'price_syp' => 25000000,
                'price_usd' => null,
                'lat' => '36.4835',
                'lng' => '40.7500',
                'dynamic_fields' => [
                    'نوع المبنى' => 'سكني',
                    'المساحة (م²)' => '500',
                ],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('ليلى', 'مسلم'),
                'category_name_ar' => 'مقاولات وبناء',
                'sub_category_name_ar' => null,
                'title_ar' => 'تنسيق حديقة منزلية في درعا',
                'title_en' => 'Home Garden Landscaping in Daraa',
                'description_ar' => 'تصميم وتنفيذ حديقة مع نباتات وأشجار ونظام ري.',
                'description_en' => 'Design and implementation of garden with plants, trees, and irrigation system.',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 5000000,
                'price_usd' => 170,
                'lat' => '32.6240',
                'lng' => '36.1021',
                'dynamic_fields' => [],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('وسيم', 'أبو راشد'),
                'category_name_ar' => 'مقاولات وبناء',
                'sub_category_name_ar' => null,
                'title_ar' => 'رفع مساحي لأرض في السويداء',
                'title_en' => 'Land Surveying in Suwayda',
                'description_ar' => 'رفع مساحي دقيق باستخدام GPS وإعداد خرائط.',
                'description_en' => 'Accurate land surveying using GPS and map preparation.',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 2000000,
                'price_usd' => null,
                'lat' => '32.7089',
                'lng' => '36.5653',
                'dynamic_fields' => [],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('رامي', 'الخطيب'),
                'category_name_ar' => 'مقاولات وبناء',
                'sub_category_name_ar' => null,
                'title_ar' => 'تقييم عقار في القنيطرة',
                'title_en' => 'Property Valuation in Quneitra',
                'description_ar' => 'تقرير تقييم مفصل للأراضي والعقارات وفق المعايير الدولية.',
                'description_en' => 'Detailed valuation report for lands and properties according to international standards.',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 1500000,
                'price_usd' => 50,
                'lat' => '33.1231',
                'lng' => '35.8187',
                'dynamic_fields' => [],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('هيام', 'شعبان'),
                'category_name_ar' => 'مقاولات وبناء',
                'sub_category_name_ar' => null,
                'title_ar' => 'وساطة لبيع منزل في إدلب',
                'title_en' => 'Brokerage for House Sale in Idlib',
                'description_ar' => 'مساعدة في بيع منزل مساحة 200 متر في حي الزيتونة.',
                'description_en' => 'Assistance in selling a 200 sqm house in Al-Zaytouna neighborhood.',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 50000000,
                'price_usd' => null,
                'lat' => '35.9333',
                'lng' => '36.6333',
                'dynamic_fields' => [],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('نبيل', 'صالح'),
                'category_name_ar' => 'مقاولات وبناء',
                'sub_category_name_ar' => null,
                'title_ar' => 'حملة تسويق عقاري لمشروع في جرمانا',
                'title_en' => 'Real Estate Marketing Campaign for a Project in Jaramana',
                'description_ar' => 'إعلانات رقمية، تصوير جوي، ونشر على منصات العقارات.',
                'description_en' => 'Digital ads, aerial photography, and listing on real estate platforms.',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 10000000,
                'price_usd' => 340,
                'lat' => '33.4840',
                'lng' => '36.3510',
                'dynamic_fields' => [],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('أحمد', 'علي'),
                'category_name_ar' => 'مقاولات وبناء',
                'sub_category_name_ar' => 'ترميم',
                'title_ar' => 'ترميم منزل قديم في دمشق القديمة',
                'title_en' => 'Renovation of Old House in Old Damascus',
                'description_ar' => 'ترميم القبو، الجدران الحجرية، والأسقف الخشبية حسب الأصول.',
                'description_en' => 'Restoration of basement, stone walls, and wooden ceilings according to heritage standards.',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 80000000,
                'price_usd' => null,
                'lat' => '33.5093',
                'lng' => '36.3138',
                'dynamic_fields' => [
                    'نوع المبنى' => 'سكني',
                    'المساحة (م²)' => '250',
                ],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('سارة', 'حسن'),
                'category_name_ar' => 'جمال وعناية',
                'sub_category_name_ar' => 'صالون نسائي',
                'title_ar' => 'جلسة عناية كاملة في صالون سارة',
                'title_en' => 'Full Care Session at Sara Salon',
                'description_ar' => 'حمام مغربي، مساج، تنظيف بشرة، تسريحة ومكياج.',
                'description_en' => 'Moroccan bath, massage, facial, hairstyle and makeup.',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 600000,
                'price_usd' => 20,
                'lat' => '33.5120',
                'lng' => '36.2900',
                'dynamic_fields' => [
                    'الخدمة المطلوبة' => 'عناية كاملة',
                ],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('محمد', 'خالد'),
                'category_name_ar' => 'صحة وطب',
                'sub_category_name_ar' => 'استشارات طبية',
                'title_ar' => 'استشارة قلبية عن بعد',
                'title_en' => 'Remote Cardiology Consultation',
                'description_ar' => 'استشارة مع طبيب قلب مختص عبر الفيديو. تحليل الأعراض ووصف العلاج.',
                'description_en' => 'Consultation with a cardiologist via video. Symptom analysis and prescription.',
                'quantity' => 10,
                'service_type' => 'sale',
                'price_syp' => 250000,
                'price_usd' => null,
                'lat' => '36.2025',
                'lng' => '37.1343',
                'dynamic_fields' => [
                    'التخصص الطبي' => 'قلبية',
                ],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('عمر', 'أحمد'),
                'category_name_ar' => 'صيانة وإصلاح',
                'sub_category_name_ar' => 'صيانة مكيفات',
                'title_ar' => 'فحص مكيف مركزي في حمص',
                'title_en' => 'Central AC Inspection in Homs',
                'description_ar' => 'فحص شامل لوحدة التكييف المركزية و تنظيف القنوات.',
                'description_en' => 'Comprehensive inspection of central AC unit and duct cleaning.',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 800000,
                'price_usd' => 28,
                'lat' => '34.7328',
                'lng' => '36.7150',
                'dynamic_fields' => [
                    'نوع المكيف' => 'مركزي',
                    'الفحص المطلوب' => 'فحص و تنظيف',
                ],
            ],
            [
                'business_account_id' => $this->getBusinessAccountIdByUser('لينا', 'محمود'),
                'category_name_ar' => 'تنظيف',
                'sub_category_name_ar' => 'تنظيف خزانات',
                'title_ar' => 'تنظيف خزان ماء في حمص',
                'title_en' => 'Water Tank Cleaning in Homs',
                'description_ar' => 'تنظيف وتعقيم خزان ماء سعة 5000 لتر.',
                'description_en' => 'Cleaning and disinfection of a 5000-liter water tank.',
                'quantity' => 1,
                'service_type' => 'sale',
                'price_syp' => 250000,
                'price_usd' => null,
                'lat' => '34.7250',
                'lng' => '36.7100',
                'dynamic_fields' => [
                    'سعة الخزان (لتر)' => '5000',
                    'هل يحتاج تعقيم؟' => 'نعم',
                ],
            ],
        ];

        foreach ($servicesData as $data) {
            $businessAccount = BusinessAccount::find($data['business_account_id']);
            if (!$businessAccount) {
                $this->command->warn("Business account ID {$data['business_account_id']} not found. Skipping.");
                continue;
            }

            $category = Category::where('name->ar', $data['category_name_ar'])->first();
            if (!$category) {
                $this->command->warn("Category '{$data['category_name_ar']}' not found. Skipping.");
                continue;
            }

            $subCategory = null;
            if ($data['sub_category_name_ar']) {
                $subCategory = SubCategory::where('name->ar', $data['sub_category_name_ar'])
                    ->where('category_id', $category->id)
                    ->first();
                if (!$subCategory) {
                    $this->command->warn("SubCategory '{$data['sub_category_name_ar']}' under category '{$data['category_name_ar']}' not found. Proceeding without subcategory.");
                }
            }

            $service = Service::create([
                'business_account_id' => $businessAccount->id,
                'category_id' => $category->id,
                'sub_category_id' => $subCategory?->id,
                'title' => ['ar' => $data['title_ar'], 'en' => $data['title_en']],
                'description' => ['ar' => $data['description_ar'], 'en' => $data['description_en']],
                'quantity' => $data['quantity'],
                'service_type' => $data['service_type'],
                'price_syp' => $data['price_syp'],
                'price_usd' => $data['price_usd'],
                'lat' => $data['lat'],
                'lng' => $data['lng'],
                'status' => 'approved',
                'submitted_at' => now()->subDays(rand(2, 10)),
                'reviewed_at' => now()->subDays(rand(0, 2)),
                'reviewed_by' => null,
            ]);

            if (!empty($data['dynamic_fields'])) {
                foreach ($data['dynamic_fields'] as $fieldName => $value) {
                    $dynamicField = null;
                    if ($subCategory) {
                        $dynamicField = DynamicField::where('dynamic_fieldable_type', SubCategory::class)
                            ->where('dynamic_fieldable_id', $subCategory->id)
                            ->where('name->ar', $fieldName)
                            ->orWhere('name->en', $fieldName)
                            ->first();
                    }
                    if (!$dynamicField) {
                        $dynamicField = DynamicField::where('dynamic_fieldable_type', Category::class)
                            ->where('dynamic_fieldable_id', $category->id)
                            ->where('name->ar', $fieldName)
                            ->orWhere('name->en', $fieldName)
                            ->first();
                    }
                    if ($dynamicField) {
                        $service->dynamicFieldValues()->updateOrCreate(
                            ['dynamic_field_id' => $dynamicField->id],
                            ['value' => $value]
                        );
                    } else {
                        $this->command->warn("Dynamic field '{$fieldName}' not found for service ID {$service->id}.");
                    }
                }
            }

            $this->command->info("Created service: {$data['title_ar']} (ID: {$service->id})");
        }

        $this->command->info("Total " . Service::count() . " services created (all approved).");
    }

    private function getBusinessAccountIdByUser(string $firstName, string $lastName): ?int
    {
        $user = \App\Models\User::where('first_name', $firstName)
            ->where('last_name', $lastName)
            ->first();

        if (!$user) {
            return null;
        }

        $businessAccount = $user->businessAccounts()->first();
        return $businessAccount?->id;
    }
}
