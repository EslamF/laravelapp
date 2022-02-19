<?php

use Illuminate\Database\Seeder;
use App\Models\Organization\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Province::create(['name' => 'الإسكندرية']); //done
        Province::create(['name' => 'الإسماعيلية']); //done
        Province::create(['name' => 'أسوان']); //done
        Province::create(['name' => 'أسيوط']); //done
        Province::create(['name' => 'الأقصر']); //done
        Province::create(['name' => 'البحر الأحمر']); //done
        Province::create(['name' => 'البحيرة']);    //done
        Province::create(['name' => 'بني سويف']); //done
        Province::create(['name' => 'بورسعيد']); //done
        Province::create(['name' => 'جنوب سيناء']); //done
        Province::create(['name' => 'الجيزة']); //done
        Province::create(['name' => 'الدقهلية']); //done
        Province::create(['name' => 'دمياط']); //done
        Province::create(['name' => 'سوهاج']); //done
        Province::create(['name' => 'السويس']); //done
        Province::create(['name' => 'الشرقية']); //done
        Province::create(['name' => 'شمال سيناء']); //done
        Province::create(['name' => 'الغربية']); //done
        Province::create(['name' => 'الفيوم']); //done
        Province::create(['name' => 'القاهرة']); //done
        Province::create(['name' => 'القليوبية']); //done
        Province::create(['name' => 'قنا']); //done
        Province::create(['name' => 'كفر الشيخ']); //done
        Province::create(['name' => 'مطروح']); //done
        Province::create(['name' => 'المنوفية']); //done
        Province::create(['name' => 'المنيا']); //done
        Province::create(['name' => 'الوادي الجديد']); //done
    }
}
