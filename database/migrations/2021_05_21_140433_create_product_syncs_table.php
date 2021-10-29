<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSyncsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_syncs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('status')->nullable();
            $table->bigInteger('action')->nullable();
            //TODO: verificar si se va crear una nueva base de datos o crear un add para esta tabla
            $table->bigInteger('external_id')->nullable();
            $table->bigInteger('product_id')->unsigned()->index()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->bigInteger('account_service_id')->unsigned()->index()->nullable();
            $table->foreign('account_service_id')->references('id')->on('account_service')->onDelete('cascade');
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
        Schema::dropIfExists('product_syncs');
    }
}
