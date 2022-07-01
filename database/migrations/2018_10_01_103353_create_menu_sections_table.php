<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_sections', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('menu_id')->unsigned();
            $table->boolean('active')->default(1);

            $table->foreign('menu_id')->references('id')->on('menus');

            $table->timestamps();
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
        Schema::dropIfExists('menu_sections');
    }
}
