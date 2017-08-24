<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToExclusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exclusions', function (Blueprint $table) {
            $table->integer('exclusion_type_id')->unsigned();
            $table->foreign('exclusion_type_id')->references('id')->on('exclusion_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exclusions', function (Blueprint $table) {
            $table->dropIndex(['exclusion_type_id']);
            $table->dropColumn('exclusion_type_id');
        });
    }
}
