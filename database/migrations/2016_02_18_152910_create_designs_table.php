<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('designs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->string('friendly_id')->unique()->nullable();
            $table->string('identifier')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('additional_details')->nullable();
            $table->float('dpi');
            $table->integer('weekly_contest_id')->unsigned()->nullable();
            $table->boolean('swatch_purchased')->default(0);
            $table->boolean('private')->default(1);
            $table->boolean('public')->default(0);
            $table->boolean('approved')->default(1);
            $table->boolean('dispatch_approved')->default(0);
            $table->integer('thumbnail_size')->unsigned()->nullable();
            $table->boolean('disabled')->default(0);
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_id')->references('id')->on('design_types');
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
        Schema::drop('designs');
    }

}
