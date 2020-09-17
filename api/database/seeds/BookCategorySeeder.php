<?php

use Faker\Factory as Faker;
use App\Entities\BookCategory;
use Illuminate\Database\Seeder;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	foreach (range(1,40) as $index) {
	        BookCategory::create([
                'book_id' => rand(1,20),
                'category_id' => rand(1,10)
	        ]);
	    }
    }
}
