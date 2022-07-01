<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRowDesignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('row_design', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('row_id')->unsigned();
            $table->integer('design_id')->unsigned();

            $table->foreign('row_id')
                ->references('id')
                ->on('rows')
                ->onDelete('cascade');

            $table->foreign('design_id')
                ->references('id')
                ->on('designs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('row_design');
    }
}
