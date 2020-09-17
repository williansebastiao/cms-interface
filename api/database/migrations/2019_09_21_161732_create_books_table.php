<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBooksTable.
 */
class CreateBooksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('books', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->text('description');
			$table->enum('book_type',['text', 'audio', 'video', 'mixed']);
			$table->enum('product_type',['paid', 'free']);
			$table->float('product_price')->default(0);
			$table->string('product_google_id')->nullable();
			$table->string('product_apple_id')->nullable();
			$table->float('time');
			$table->boolean('downloaded')->default(0);
			$table->boolean('locked')->default(0);
			$table->boolean('favorited')->default(0);
			$table->string('file_url')->nullable();
			$table->string('image_url')->nullable();
			$table->integer('likes')->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('books');
	}
}
