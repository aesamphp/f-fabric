<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('menu_id')->unsigned();
            $table->integer('menu_section_id')->unsigned()->nullable();
            $table->string('route');
            $table->integer('sort_order')->default(99);
            $table->boolean('active')->default(1);

            $table->foreign('menu_id')->references('id')->on('menus');
            $table->foreign('menu_section_id')->references('id')->on('menu_sections');
            
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
        Schema::dropIfExists('menu_items');
    }
}
