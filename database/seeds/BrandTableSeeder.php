<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
  //       DB::table('brand')->insert([
		// 	'brand_name' => Str::random(10),
		// 	'brand_url' => Str::random(10).'@gmail.com',
		// 	'brand_logo' => 'http://img.2001.com/photo/IVKt5jqQKxU1x1NJsd8HpIsYjPMTbesZIgDTmM2o.jpeg',
		// 	'brand_desc' => Str::random(10),
		// 	'created_at' => date('Y-m-d H:i:s',time()),
		// 	'updated_at' => date('Y-m-d H:i:s',time())
		// ]);

    	factory(App\Models\Brand::class,10)->create();

    }
}
