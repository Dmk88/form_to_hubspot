<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use APP\FormData;

class CreateFormDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 200);
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('organization', 150);
            $table->string('product_file', 100);
            $table->string('file_type', 50);
            $table->string('release', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_data');
    }
}
