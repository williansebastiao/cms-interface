<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	foreach (range(1,10) as $index) {
	        DB::table('categories')->insert([
	            'name' => $faker->name,
	            'description' => $faker->text,
	            'image_url' => $faker->image
	        ]);
	    }
    }
}
