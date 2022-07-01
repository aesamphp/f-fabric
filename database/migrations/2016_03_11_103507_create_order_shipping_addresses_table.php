<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderShippingAddressesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('order_shipping_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('weight_branding_id')->unsigned();
            $table->string('title');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('city');
            $table->string('postcode');
            $table->string('state')->nullable();
            $table->string('phone')->nullable();
            $table->string('country');
            $table->float('price');

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('weight_branding_id')->references('id')->on('shipping_weight_brandings');
            $table->foreign('state')->references('code')->on('us_states');
            $table->foreign('country')->references('code')->on('countries');

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
        Schema::drop('order_shipping_addresses');
    }

}
