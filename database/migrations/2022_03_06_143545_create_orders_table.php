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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bag_id');
            $table->string('name', 30);
            $table->string('number', 30);
            $table->timestamps();

            $table->foreign('user_id', 'fk-orders-user_id')->references('id')->on('users');
            $table->foreign('bag_id', 'fk-orders-bag_id')->references('id')->on('bags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign('fk-orders-user_id');
            $table->dropForeign('fk-orders-bag_id');
        });

        Schema::dropIfExists('orders');
    }
};
