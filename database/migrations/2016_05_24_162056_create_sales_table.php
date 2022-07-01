<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Sale;

class CreateSalesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('order_item_id')->unsigned();
            $table->integer('type_id')->unsigned()->default(Sale::TYPE_SALE);
            $table->float('amount');
            $table->float('tax');
            $table->boolean('paid')->default(0);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('order_item_id')->references('id')->on('order_items');

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
        Schema::drop('sales');
    }

}
