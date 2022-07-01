<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('design_id')->unsigned()->nullable();
            $table->integer('category_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('material_id')->unsigned()->nullable();
            $table->integer('repeat_type')->unsigned()->nullable();
            $table->float('dpi')->nullable();
            $table->integer('quantity')->unsigned();
            $table->float('unit_price');
            $table->float('product_weight');
            
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('design_id')->references('id')->on('designs');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('material_id')->references('id')->on('materials');
            $table->foreign('repeat_type')->references('id')->on('design_types');

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
        Schema::drop('order_items');
    }

}
