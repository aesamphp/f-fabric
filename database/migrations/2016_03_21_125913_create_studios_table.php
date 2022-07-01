<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudiosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('studios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('username')->unique()->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->text('about_me')->nullable();
            $table->string('city')->nullable();
            $table->string('postcode')->nullable();
            $table->string('country')->nullable();
            $table->string('image_path')->nullable();
            $table->string('header_image_path')->nullable();
            $table->string('store_link')->nullable();
            $table->string('blog_link')->nullable();
            $table->boolean('public')->default(1);
            $table->boolean('share_favourites')->default(0);
            $table->boolean('disabled')->default(0);
            
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::drop('studios');
    }

}
