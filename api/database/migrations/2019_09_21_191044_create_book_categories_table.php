<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBookCategoriesTable.
 */
class CreateBookCategoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('book_categories', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('book_id')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->timestamps();
			$table->foreign('book_id')->references('id')->on('books');
			$table->foreign('category_id')->references('id')->on('categories');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('book_categories');
	}
}
