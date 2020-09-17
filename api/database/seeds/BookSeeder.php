<?php

use App\Entities\Book;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookTypes = ['audio', 'video', 'mixed', 'text'];
        $productTypes = ['paid', 'free'];
        $faker = Faker::create();
    	foreach (range(1,10) as $index) {
	        Book::create([
                'title' => $faker->name,
                'description' => $faker->text,
                'book_type' => $bookTypes[rand(0,3)],
                'product_type' => $productTypes[rand(0,1)],
                'product_price' => rand(2,15),
                'time' => rand(2,9),
                'downloaded' => rand(0,1),
                'locked' => rand(0,1),
                'favorited' => rand(0,1),
                'image_url' => $faker->image,
                'locked' => rand(0,1),
                'favorited' => rand(0,1)
	        ]);
	    }
    }
}
