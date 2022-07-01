<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderBillingAddressesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('order_billing_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
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

            $table->foreign('order_id')->references('id')->on('orders');
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
        Schema::drop('order_billing_addresses');
    }

}
