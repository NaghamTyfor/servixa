<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (City::count() === 0) {
            $this->call(CitySeeder::class);
        }

        $usersData = [
            ['first_name' => 'أحمد', 'last_name' => 'علي', 'phone' => '0912345678', 'city_name_ar' => 'دمشق'],
            ['first_name' => 'سارة', 'last_name' => 'حسن', 'phone' => '0912345679', 'city_name_ar' => 'دمشق'],
            ['first_name' => 'محمد', 'last_name' => 'خالد', 'phone' => '0923456780', 'city_name_ar' => 'حلب'],
            ['first_name' => 'نور', 'last_name' => 'حسين', 'phone' => '0923456781', 'city_name_ar' => 'حلب'],
            ['first_name' => 'عمر', 'last_name' => 'أحمد', 'phone' => '0934567890', 'city_name_ar' => 'حمص'],
            ['first_name' => 'لينا', 'last_name' => 'محمود', 'phone' => '0934567891', 'city_name_ar' => 'حمص'],
            ['first_name' => 'حسان', 'last_name' => 'ناصر', 'phone' => '0945678901', 'city_name_ar' => 'حماه'],
            ['first_name' => 'رنا', 'last_name' => 'عبد الله', 'phone' => '0945678902', 'city_name_ar' => 'حماه'],
            ['first_name' => 'باسل', 'last_name' => 'أيوب', 'phone' => '0956789012', 'city_name_ar' => 'اللاذقية'],
            ['first_name' => 'هدى', 'last_name' => 'رفاعي', 'phone' => '0956789013', 'city_name_ar' => 'اللاذقية'],
            ['first_name' => 'جورج', 'last_name' => 'ملحم', 'phone' => '0967890123', 'city_name_ar' => 'طرطوس'],
            ['first_name' => 'ماري', 'last_name' => 'عون', 'phone' => '0967890124', 'city_name_ar' => 'طرطوس'],
            ['first_name' => 'إبراهيم', 'last_name' => 'العبد', 'phone' => '0978901234', 'city_name_ar' => 'دير الزور'],
            ['first_name' => 'خالد', 'last_name' => 'الداود', 'phone' => '0989012345', 'city_name_ar' => 'الرقة'],
            ['first_name' => 'سمير', 'last_name' => 'عوني', 'phone' => '0990123456', 'city_name_ar' => 'الحسكة'],
            ['first_name' => 'ليلى', 'last_name' => 'مسلم', 'phone' => '0991234567', 'city_name_ar' => 'درعا'],
            ['first_name' => 'وسيم', 'last_name' => 'أبو راشد', 'phone' => '0992345678', 'city_name_ar' => 'السويداء'],
            ['first_name' => 'رامي', 'last_name' => 'الخطيب', 'phone' => '0993456789', 'city_name_ar' => 'القنيطرة'],
            ['first_name' => 'هيام', 'last_name' => 'شعبان', 'phone' => '0994567890', 'city_name_ar' => 'إدلب'],
            ['first_name' => 'نبيل', 'last_name' => 'صالح', 'phone' => '0995678901', 'city_name_ar' => 'جرمانا'],
        ];

        foreach ($usersData as $data) {
            $city = City::where('name->ar', $data['city_name_ar'])->first();

            if (!$city) {
                $this->command->warn("City '{$data['city_name_ar']}' not found. Skipping user {$data['first_name']} {$data['last_name']}");
                continue;
            }

            User::create([
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'phone'      => $data['phone'],
                'password'   => 'password', 
                'city_id'    => $city->id,
                'is_active'  => true,
            ]);
        }

        $this->command->info('20 active users created successfully.');
    }
}
