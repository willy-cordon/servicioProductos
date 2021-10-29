<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_service_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('external_order_id')->nullable();
            $table->bigInteger('external_seller_id')->nullable();
            $table->json('external_data')->nullable();
            $table->integer('status')->nullable();

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
        Schema::dropIfExists('account_service_orders');
    }
}
