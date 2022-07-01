<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignTipsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('design_tips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->string('identifier')->unique();
            $table->string('title');
            $table->longText('content');
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            $table->foreign('category_id')->references('id')->on('design_tip_categories');

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
        Schema::drop('design_tips');
    }

}
