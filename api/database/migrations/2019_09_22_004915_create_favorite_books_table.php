<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFavoriteBooksTable.
 */
class CreateFavoriteBooksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('favorite_books', function(Blueprint $table) {
            $table->increments('id');
			$table->string('device_id');
			$table->integer('book_id')->unsigned();
			$table->timestamps();
			$table->foreign('device_id')->references('id')->on('devices');
			$table->foreign('book_id')->references('id')->on('books');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('favorite_books');
	}
}
