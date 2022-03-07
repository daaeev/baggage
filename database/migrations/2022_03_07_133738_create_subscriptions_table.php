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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bag_id');

            $table->foreign('user_id', 'fk-subscriptions-user_id')->references('id')->on('users');
            $table->foreign('bag_id', 'fk-subscriptions-bag_id')->references('id')->on('bags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign('fk-subscriptions-user_id');
            $table->dropForeign('fk-subscriptions-bag_id');
        });
        Schema::dropIfExists('subscriptions');
    }
};
