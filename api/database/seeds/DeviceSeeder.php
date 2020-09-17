<?php

use App\Entities\Device;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
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
	        Device::create([
	            'id' => $faker->uuid
	        ]);
	    }
    }
}
