<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutUsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('about_us', function (Blueprint $table) {
			$table->increments('id');
			$table->string('header_title');
			$table->longText('header_content');
			$table->string('header_image');
			$table->string('section_1_title');
			$table->longText('section_1_content');
			$table->string('section_2_title');
			$table->string('section_2_text');
			$table->longText('section_2_content');
			$table->string('section_2_image');
			$table->boolean('section_2_button_display')->default(0);
			$table->string('section_2_button_title');
			$table->string('section_2_button_url');
			$table->string('section_3_title');
			$table->string('section_3_text');
			$table->longText('section_3_content');
			$table->string('section_3_image');
			$table->boolean('section_3_button_display')->default(0);
			$table->string('section_3_button_title');
			$table->string('section_3_button_url');
			$table->string('section_4_title');
			$table->string('section_4_video');

			$table->nullableTimestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('about_us');
	}

}