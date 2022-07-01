<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('friendly_id')->unique()->nullable();
            $table->string('vendorTxCode')->unique();
            $table->string('txType');
            $table->float('actual_amount');
            $table->float('amount');
            $table->string('currency');
            $table->boolean('applyAVSCV2')->default(0);
            $table->boolean('apply3DSecure')->default(0);
            $table->boolean('allowGiftAid')->default(0);
            $table->longText('basketXML');
            $table->text('surchargeXML');
            $table->string('cardType');
            $table->string('accountType');
            $table->string('status');
            $table->string('statusDetail');
            $table->string('vPSTxId');
            $table->string('securityKey');
            $table->integer('txAuthNo')->unsigned();
            $table->string('aVSCV2')->nullable();
            $table->string('addressResult')->nullable();
            $table->string('postCodeResult')->nullable();
            $table->string('cV2Result')->nullable();
            $table->string('3DSecureStatus')->nullable();
            $table->string('declineCode')->nullable();
            $table->string('bankAuthCode')->nullable();
            $table->float('vat');
            $table->float('surcharge');
            $table->boolean('dispatched')->default(0);
            $table->string('tracking_number')->nullable();
            $table->boolean('disabled')->default(0);
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('currency')->references('code')->on('currencies');

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
        Schema::drop('orders');
    }

}
