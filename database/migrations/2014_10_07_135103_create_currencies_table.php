<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('currencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('code')->unique();
            $table->string('symbol');
            $table->float('exchange_rate')->nullable();
            $table->boolean('default')->default(0);

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
        Schema::drop('currencies');
    }

}
