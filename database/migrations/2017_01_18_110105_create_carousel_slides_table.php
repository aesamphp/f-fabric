<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarouselSlidesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('carousel_slides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('carousel_id')->unsigned();
            $table->string('image_path');
            $table->text('content')->nullable();
            $table->integer('cta_type')->unsigned()->nullable();
            $table->string('cta_title')->nullable();
            $table->string('cta_href')->nullable();
            $table->integer('sort')->nullable();

            $table->foreign('carousel_id')->references('id')->on('carousels');

            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('carousel_slides');
    }

}
