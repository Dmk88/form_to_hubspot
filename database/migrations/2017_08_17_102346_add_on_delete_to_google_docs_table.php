<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOnDeleteToGoogleDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('google_docs', function (Blueprint $table) {
            $table->integer('hubspot_form_id')->unsigned()->nullable()->change();
            $table->dropForeign(['hubspot_form_id']);
            $table->foreign('hubspot_form_id')->references('id')->on('hubspot_forms')->onDelete('set null');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('google_docs', function (Blueprint $table) {
            $table->integer('hubspot_form_id')->unsigned()->change();
            $table->dropForeign(['hubspot_form_id']);
            $table->foreign('hubspot_form_id')->references('id')->on('hubspot_forms')->change();
        });
    }
}
