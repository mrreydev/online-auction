<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryLelangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_lelangs', function (Blueprint $table) {
            $table->increments('id_history');
            $table->integer('id_lelang')->unsigned();
            $table->integer('id_barang')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->integer('penawaran_harga')->unsigned();
            $table->foreign('id_barang')->references('id_barang')->on('barangs');
            $table->foreign('id_user')->references('id_user')->on('masyarakats');
            $table->foreign('id_lelang')->references('id_lelang')->on('lelangs');
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
        Schema::dropIfExists('history_lelangs');
    }
}
