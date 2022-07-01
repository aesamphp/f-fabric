<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountCodesGroupTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_code_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('prefix')->unique();
            $table->integer('use_limit_id')->unsigned();
            $table->integer('use_limit')->unsigned()->nullable();
            $table->integer('date_limit_id')->unsigned();
            $table->integer('value_type_id')->unsigned();
            $table->float('value');
            $table->float('min_value')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('used')->nullable();
            $table->timestamp('from_date')->nullable();
            $table->timestamp('to_date')->nullable();

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
    public function down()
    {
        Schema::drop('discount_code_groups');
    }

}
