<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('st_eur', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('tDate');
            $table->text('tPrice');
            $table->text('tVolume');
            $table->text('tDirection');
            $table->text('pAsk');
            $table->text('pBid');
            $table->text('nAsk');
            $table->text('nBid');
            $table->timestamps();
        });

        Schema::create('st_aud', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('tDate');
            $table->text('tPrice');
            $table->text('tVolume');
            $table->text('tDirection');
            $table->text('pAsk');
            $table->text('pBid');
            $table->text('nAsk');
            $table->text('nBid');
            $table->timestamps();
        });

        Schema::create('st_cad', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('tDate');
            $table->text('tPrice');
            $table->text('tVolume');
            $table->text('tDirection');
            $table->text('pAsk');
            $table->text('pBid');
            $table->text('nAsk');
            $table->text('nBid');
            $table->timestamps();
        });

        Schema::create('st_chf', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('tDate');
            $table->text('tPrice');
            $table->text('tVolume');
            $table->text('tDirection');
            $table->text('pAsk');
            $table->text('pBid');
            $table->text('nAsk');
            $table->text('nBid');
            $table->timestamps();
        });

        Schema::create('st_gbp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('tDate');
            $table->text('tPrice');
            $table->text('tVolume');
            $table->text('tDirection');
            $table->text('pAsk');
            $table->text('pBid');
            $table->text('nAsk');
            $table->text('nBid');
            $table->timestamps();
        });

        Schema::create('st_jpy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('tDate');
            $table->text('tPrice');
            $table->text('tVolume');
            $table->text('tDirection');
            $table->text('pAsk');
            $table->text('pBid');
            $table->text('nAsk');
            $table->text('nBid');
            $table->timestamps();
        });

        Schema::create('st_nzd', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('tDate');
            $table->text('tPrice');
            $table->text('tVolume');
            $table->text('tDirection');
            $table->text('pAsk');
            $table->text('pBid');
            $table->text('nAsk');
            $table->text('nBid');
            $table->timestamps();
        });

        Schema::create('st_gold', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('tDate');
            $table->text('tPrice');
            $table->text('tVolume');
            $table->text('tDirection');
            $table->text('pAsk');
            $table->text('pBid');
            $table->text('nAsk');
            $table->text('nBid');
            $table->timestamps();
        });

        Schema::create('st_silver', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('tDate');
            $table->text('tPrice');
            $table->text('tVolume');
            $table->text('tDirection');
            $table->text('pAsk');
            $table->text('pBid');
            $table->text('nAsk');
            $table->text('nBid');
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
        Schema::drop('st_eur');
        Schema::drop('st_aud');
        Schema::drop('st_cad');
        Schema::drop('st_chf');
        Schema::drop('st_gbp');
        Schema::drop('st_jpy');
        Schema::drop('st_nzd');
        Schema::drop('st_gold');
        Schema::drop('st_silver');
    }
}
