<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModForeignKeyToExclusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exclusions', function (Blueprint $table) {
            $table->dropForeign(['exc_google_doc_id']);
            $table->foreign('exc_google_doc_id')->references('id')->on('google_docs')->onDelete('cascade');
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
            $table->dropForeign(['exc_google_doc_id']);
            $table->foreign('exc_google_doc_id')->references('id')->on('google_docs');
        });
    }
}
