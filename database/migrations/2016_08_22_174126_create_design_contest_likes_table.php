<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignContestLikesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('design_contest_likes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('design_id')->unsigned();
            $table->integer('weekly_contest_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('design_id')->references('id')->on('designs');
            $table->foreign('weekly_contest_id')->references('id')->on('weekly_contests');

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
        Schema::drop('design_contest_likes');
    }

}
