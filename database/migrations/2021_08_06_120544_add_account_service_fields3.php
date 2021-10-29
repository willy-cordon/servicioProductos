<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountServiceFields3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_service', function (Blueprint $table) {
            $table->text('external_client_id')->nullable();
            $table->text('external_client_secret')->nullable();
            $table->text('external_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_service', function (Blueprint $table) {
            //
        });
    }
}
