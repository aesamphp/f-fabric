<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignAdditionalImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('design_additional_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('design_id')->unsigned();
            $table->string('path');

            $table->foreign('design_id')->references('id')->on('designs');

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
        Schema::drop('design_additional_images');
    }
}
