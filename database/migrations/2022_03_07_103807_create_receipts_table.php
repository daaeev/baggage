<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bag_id');
            $table->string('name', 30)->nullable();
            $table->string('tel_number', 30);
            $table->string('order_number', 10);
            $table->timestamps();

            $table->foreign('user_id', 'fk-receipts-user_id')->references('id')->on('users');
            $table->foreign('bag_id', 'fk-receipts-bag_id')->references('id')->on('bags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropForeign('fk-receipts-user_id');
            $table->dropForeign('fk-receipts-bag_id');
        });

        Schema::dropIfExists('receipts');
    }
};
