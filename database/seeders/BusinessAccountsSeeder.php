<?php

namespace Database\Seeders;

use App\Models\ActivityType;
use App\Models\BusinessAccount;
use App\Models\City;
use App\Models\User;
use Illuminate\Database\Seeder;

class BusinessAccountsSeeder extends Seeder
{
    public function run(): void
    {
        if (City::count() === 0) $this->call(CitySeeder::class);
        if (ActivityType::count() === 0) $this->call(ActivityTypeSeeder::class);
        if (User::count() === 0) $this->call(UsersSeeder::class);

        $accountsData = [
            [
                'user_first_name' => 'أحمد',
                'user_last_name' => 'علي',
                'activity_name_ar' => 'مقاولات عامة',
                'city_name_ar' => 'دمشق',
                'business_name_ar' => 'مؤسسة أحمد علي للمقاولات العامة',
                'business_name_en' => 'Ahmed Ali General Contracting',
                'license_number' => '12345/دمشق',
                'lat' => '33.5138',
                'lng' => '36.2765',
                'activities' => 'نقدم خدمات المقاولات العامة من بناء وتشطيب وترميم للمنشآت السكنية والتجارية.',
                'details' => 'خبرة أكثر من 15 عاماً في مجال البناء. نعمل ضمن دمشق وريفها. فريق مهندسين وفنيين محترفين.',
            ],
            [
                'user_first_name' => 'سارة',
                'user_last_name' => 'حسن',
                'activity_name_ar' => 'تصميم داخلي',
                'city_name_ar' => 'دمشق',
                'business_name_ar' => 'استديو سارة للديكور والتصميم',
                'business_name_en' => 'Sara Hassan Interior Design Studio',
                'license_number' => '78901/دمشق',
                'lat' => '33.5120',
                'lng' => '36.2900',
                'activities' => 'تصميم داخلي للمنازل والمكاتب والمحلات التجارية. تقديم حلول ديكور عصرية.',
                'details' => 'نستخدم أحدث البرامج التصميمية. نوفر خدمات التنفيذ بالإشراف على المقاولين.',
            ],
            [
                'user_first_name' => 'محمد',
                'user_last_name' => 'خالد',
                'activity_name_ar' => 'مقاولات بناء',
                'city_name_ar' => 'حلب',
                'business_name_ar' => 'شركة الشام للبناء والتشييد',
                'business_name_en' => 'Al-Sham Construction Company',
                'license_number' => '56789/حلب',
                'lat' => '36.2025',
                'lng' => '37.1343',
                'activities' => 'تشييد الأبنية السكنية والتجارية والمنشآت الخدمية.',
                'details' => 'فريق هندسي متكامل. نلتزم بمواعيد التسليم وأعلى معايير الجودة.',
            ],
            [
                'user_first_name' => 'نور',
                'user_last_name' => 'حسين',
                'activity_name_ar' => 'توريد مواد بناء',
                'city_name_ar' => 'حلب',
                'business_name_ar' => 'مؤسسة نور لمواد البناء',
                'business_name_en' => 'Nour Building Materials Supply',
                'license_number' => '45678/حلب',
                'lat' => '36.2100',
                'lng' => '37.1450',
                'activities' => 'توريد جميع أنواع مواد البناء: إسمنت، حديد، طوب، رمل، كسارات.',
                'details' => 'أسعار تنافسية وتوصيل سريع إلى كافة مناطق حلب وريفها.',
            ],
            [
                'user_first_name' => 'عمر',
                'user_last_name' => 'أحمد',
                'activity_name_ar' => 'صيانة عامة',
                'city_name_ar' => 'حمص',
                'business_name_ar' => 'ورشة عمر للصيانة الشاملة',
                'business_name_en' => 'Omar Comprehensive Maintenance Workshop',
                'license_number' => '98765/حمص',
                'lat' => '34.7328',
                'lng' => '36.7150',
                'activities' => 'صيانة كهرباء، سباكة، تكييف، أجهزة منزلية.',
                'details' => 'خدمة منزلية 24 ساعة. فنيون مدربون وضمان على القطع.',
            ],
            [
                'user_first_name' => 'لينا',
                'user_last_name' => 'محمود',
                'activity_name_ar' => 'تنظيف منازل',
                'city_name_ar' => 'حمص',
                'business_name_ar' => 'شركة لينا للنظافة العامة',
                'business_name_en' => 'Lina General Cleaning Company',
                'license_number' => '32145/حمص',
                'lat' => '34.7250',
                'lng' => '36.7100',
                'activities' => 'تنظيف المنازل والفلل والمكاتب بعد البناء وأثناء الاستخدام.',
                'details' => 'نستخدم معدات حديثة ومواد صديقة للبيئة. فريق مدرب ومؤمن.',
            ],
            [
                'user_first_name' => 'حسان',
                'user_last_name' => 'ناصر',
                'activity_name_ar' => 'مقاولات كهرباء',
                'city_name_ar' => 'حماه',
                'business_name_ar' => 'مؤسسة حسان للكهرباء',
                'business_name_en' => 'Hassan Electrical Contracting',
                'license_number' => '11223/حماه',
                'lat' => '35.1318',
                'lng' => '36.7531',
                'activities' => 'تنفيذ الشبكات الكهربائية للمباني والمنشآت. لوحات توزيع وتأريض.',
                'details' => 'مهندسون متخصصون. نعتمد على كابلات ومعدات أصلية.',
            ],
            [
                'user_first_name' => 'رنا',
                'user_last_name' => 'عبد الله',
                'activity_name_ar' => 'توريد أدوات صحية',
                'city_name_ar' => 'حماه',
                'business_name_ar' => 'شركة رنا للأدوات الصحية',
                'business_name_en' => 'Rana Sanitaryware Supply',
                'license_number' => '33445/حماه',
                'lat' => '35.1350',
                'lng' => '36.7500',
                'activities' => 'توريد جميع أنواع الأدوات الصحية: حمامات، خلاطات، سخانات.',
                'details' => 'نوفر ماركات عالمية ومحلية بضمان سنة. خدمة ما بعد البيع.',
            ],
            [
                'user_first_name' => 'باسل',
                'user_last_name' => 'أيوب',
                'activity_name_ar' => 'مقاولات تشطيبات',
                'city_name_ar' => 'اللاذقية',
                'business_name_ar' => 'مؤسسة باسل للتشطيبات والديكور',
                'business_name_en' => 'Basel Finishing & Decoration',
                'license_number' => '55466/اللاذقية',
                'lat' => '35.5231',
                'lng' => '35.7895',
                'activities' => 'تشطيبات داخلية وخارجية: دهانات، جبس، سيراميك، باركيه.',
                'details' => 'نستخدم مواد عالية الجودة. إشراف هندسي كامل.',
            ],
            [
                'user_first_name' => 'هدى',
                'user_last_name' => 'رفاعي',
                'activity_name_ar' => 'تصميم داخلي',
                'city_name_ar' => 'اللاذقية',
                'business_name_ar' => 'استديو هدى للتصميم الداخلي',
                'business_name_en' => 'Huda Interior Design Studio',
                'license_number' => '77889/اللاذقية',
                'lat' => '35.5280',
                'lng' => '35.7820',
                'activities' => 'تصميم وتنفيذ الديكورات للمنازل والمحلات والمكاتب.',
                'details' => 'خبرة 10 سنوات. نقدم تصاميم عصرية وكلاسيكية تناسب كل الأذواق.',
            ],
            [
                'user_first_name' => 'جورج',
                'user_last_name' => 'ملحم',
                'activity_name_ar' => 'صيانة تكييف وتبريد',
                'city_name_ar' => 'طرطوس',
                'business_name_ar' => 'مركز جورج لصيانة التكييف',
                'business_name_en' => 'George AC Maintenance Center',
                'license_number' => '99100/طرطوس',
                'lat' => '34.8867',
                'lng' => '35.8867',
                'activities' => 'صيانة وتركيب أجهزة التكييف والتبريد. تنظيف وتعبئة غاز.',
                'details' => 'نقدم كفالة 6 أشهر على الصيانة. خدمة سريعة ومنزلية.',
            ],
            [
                'user_first_name' => 'ماري',
                'user_last_name' => 'عون',
                'activity_name_ar' => 'تنظيف واجهات',
                'city_name_ar' => 'طرطوس',
                'business_name_ar' => 'شركة ماري لتنظيف الواجهات',
                'business_name_en' => 'Mary Facade Cleaning Company',
                'license_number' => '22134/طرطوس',
                'lat' => '34.8800',
                'lng' => '35.8900',
                'activities' => 'تنظيف واجهات المباني الزجاجية والحجرية باستخدام تقنيات التسلق والرافعات.',
                'details' => 'فريق مدرب على السلامة. نستخدم مواد لا تترك أثراً.',
            ],
            [
                'user_first_name' => 'إبراهيم',
                'user_last_name' => 'العبد',
                'activity_name_ar' => 'توريد أثاث',
                'city_name_ar' => 'دير الزور',
                'business_name_ar' => 'معرض إبراهيم للأثاث',
                'business_name_en' => 'Ibrahim Furniture Showroom',
                'license_number' => '44355/ديرالزور',
                'lat' => '35.3363',
                'lng' => '40.1395',
                'activities' => 'توريد أثاث منزلي ومكتبي (غرف نوم، صالونات، مكاتب).',
                'details' => 'نوفر أثاث بأسعار منافسة مع إمكانية التقسيط. توصيل وتركيب مجاني.',
            ],
            [
                'user_first_name' => 'خالد',
                'user_last_name' => 'الداوود',
                'activity_name_ar' => 'مقاولات سباكة',
                'city_name_ar' => 'الرقة',
                'business_name_ar' => 'مؤسسة خالد للسباكة والتدفئة',
                'business_name_en' => 'Khaled Plumbing & Heating',
                'license_number' => '66788/الرقة',
                'lat' => '35.9528',
                'lng' => '39.0297',
                'activities' => 'تركيب وصيانة شبكات المياه والصرف الصحي والتدفئة المركزية.',
                'details' => 'نستخدم مواد أصلية وضمان 5 سنوات على التركيبات.',
            ],
            [
                'user_first_name' => 'سمير',
                'user_last_name' => 'عوني',
                'activity_name_ar' => 'مقاولات عزل',
                'city_name_ar' => 'الحسكة',
                'business_name_ar' => 'شركة سمير للعزل الحراري والمائي',
                'business_name_en' => 'Samir Thermal & Waterproofing',
                'license_number' => '88990/الحسكة',
                'lat' => '36.4835',
                'lng' => '40.7500',
                'activities' => 'عزل الأسطح والحوائط والخزانات ضد المياه والحرارة.',
                'details' => 'نستخدم مواد عالية الجودة وضمان 10 سنوات. لدينا مهندسون متخصصون.',
            ],
            [
                'user_first_name' => 'ليلى',
                'user_last_name' => 'مسلم',
                'activity_name_ar' => 'تنسيق حدائق',
                'city_name_ar' => 'درعا',
                'business_name_ar' => 'مشاتل ليلى للزينة والحدائق',
                'business_name_en' => 'Layla Gardens & Landscaping',
                'license_number' => '11122/درعا',
                'lat' => '32.6240',
                'lng' => '36.1021',
                'activities' => 'تصميم وتنفيذ الحدائق المنزلية والمسطحات الخضراء. بيع النباتات والزينة.',
                'details' => 'طاقم زراعي متخصص. نقدم خدمات الري والقص والتسميد.',
            ],
            [
                'user_first_name' => 'وسيم',
                'user_last_name' => 'أبو راشد',
                'activity_name_ar' => 'مساحة',
                'city_name_ar' => 'السويداء',
                'business_name_ar' => 'مكتب وسيم للمساحة والخرائط',
                'business_name_en' => 'Waseem Surveying Office',
                'license_number' => '33344/السويداء',
                'lat' => '32.7089',
                'lng' => '36.5653',
                'activities' => 'رفع مساحي للأراضي والمباني، تقسيم الأراضي، إعداد خرائط تنظيمية.',
                'details' => 'نستخدم أحدث أجهزة GPS والميزان. تقارير معتمدة من النقابة.',
            ],
            [
                'user_first_name' => 'رامي',
                'user_last_name' => 'الخطيب',
                'activity_name_ar' => 'تقييم عقاري',
                'city_name_ar' => 'القنيطرة',
                'business_name_ar' => 'مكتب رامي للتقييم العقاري',
                'business_name_en' => 'Rami Real Estate Valuation',
                'license_number' => '55667/القنيطرة',
                'lat' => '33.1231',
                'lng' => '35.8187',
                'activities' => 'تقييم الأراضي والعقارات للأفراد والشركات والجهات المصرفية.',
                'details' => 'تقرير مفصل حسب معايير الاتحاد الدولي للتقييم. خبرة 8 سنوات.',
            ],
            [
                'user_first_name' => 'هيام',
                'user_last_name' => 'شعبان',
                'activity_name_ar' => 'وساطة عقارية',
                'city_name_ar' => 'إدلب',
                'business_name_ar' => 'مكتب هيام للوساطة العقارية',
                'business_name_en' => 'Hiam Real Estate Brokerage',
                'license_number' => '77888/إدلب',
                'lat' => '35.9333',
                'lng' => '36.6333',
                'activities' => 'بيع وشراء وتأجير العقارات. استشارات عقارية وتسويق.',
                'details' => 'نساعد العملاء في إيجاد العقار المناسب بأفضل سعر. توثيق العقود.',
            ],
            [
                'user_first_name' => 'نبيل',
                'user_last_name' => 'صالح',
                'activity_name_ar' => 'تسويق عقاري',
                'city_name_ar' => 'جرمانا',
                'business_name_ar' => 'شركة نبيل للتسويق العقاري',
                'business_name_en' => 'Nabeel Real Estate Marketing',
                'license_number' => '99000/ريف دمشق',
                'lat' => '33.4840',
                'lng' => '36.3510',
                'activities' => 'تسويق المشاريع العقارية الجديدة، حملات إعلانية رقمية، دراسات سوق.',
                'details' => 'نمتلك قاعدة بيانات واسعة من المشترين والمستثمرين. نضمن سرية المعلومات.',
            ],
        ];

        $adminId = 1;

        foreach ($accountsData as $data) {
            $user = User::where('first_name', $data['user_first_name'])
                        ->where('last_name', $data['user_last_name'])
                        ->first();

            if (!$user) {
                $this->command->warn("User {$data['user_first_name']} {$data['user_last_name']} not found. Skipping.");
                continue;
            }

            $activityType = ActivityType::where('name->ar', $data['activity_name_ar'])->first();
            if (!$activityType) {
                $this->command->warn("Activity type '{$data['activity_name_ar']}' not found. Skipping.");
                continue;
            }

            $city = City::where('name->ar', $data['city_name_ar'])->first();
            if (!$city) {
                $this->command->warn("City '{$data['city_name_ar']}' not found. Skipping.");
                continue;
            }

            BusinessAccount::create([
                'user_id'          => $user->id,
                'activity_type_id' => $activityType->id,
                'city_id'          => $city->id,
                'business_name'    => [
                    'ar' => $data['business_name_ar'],
                    'en' => $data['business_name_en'],
                ],
                'license_number'   => $data['license_number'],
                'lat'              => $data['lat'],
                'lng'              => $data['lng'],
                'activities'       => $data['activities'],
                'details'          => $data['details'],
                'status'           => 'approved',
                'submitted_at'     => now()->subDays(rand(5, 20)),
                'reviewed_at'      => now()->subDays(rand(1, 5)),
                'reviewed_by'      => $adminId,
            ]);
        }

        $this->command->info('20 real business accounts created successfully (approved status).');
    }
}
