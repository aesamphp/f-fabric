<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('bank_name')->nullable();
            $table->string('bucksnet_id')->unique()->nullable();
            $table->string('paypal_email')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('country');
            $table->boolean('vat_registered')->default(0);

            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('payment_details');
    }

}
