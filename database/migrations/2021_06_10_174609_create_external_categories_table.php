<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_categories', function (Blueprint $table) {
            $table->id();
            $table->string('external_name')->nullable();
            $table->string('external_id')->nullable();
            $table->string('external_parent_id')->nullable();
            $table->integer('service_id')->nullable();
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
        Schema::dropIfExists('m_l_categories');
    }
}
