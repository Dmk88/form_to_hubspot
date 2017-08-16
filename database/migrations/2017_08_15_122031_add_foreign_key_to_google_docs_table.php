<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToGoogleDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('google_docs', function (Blueprint $table) {
            $table->dropUnique(['doc_id']);
            $table->integer('hubspot_form_id')->unsigned();
            $table->foreign('hubspot_form_id')->references('id')->on('hubspot_forms');
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
            $table->string('doc_id', 50)->unique()->change();
            $table->dropIndex(['hubspot_form_id']);
            $table->dropColumn('hubspot_form_id');
        });
    }
}
