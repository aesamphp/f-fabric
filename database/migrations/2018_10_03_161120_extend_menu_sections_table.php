<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendMenuSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_sections', function(Blueprint $table) {
            $table->string('url')->nullable();
            $table->text('excerpt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_sections', function(Blueprint $table) {
            $table->dropColumn('url');
            $table->dropColumn('excerpt');
        });
    }
}
