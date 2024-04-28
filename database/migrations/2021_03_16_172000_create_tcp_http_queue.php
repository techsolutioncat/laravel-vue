<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcpHttpQueue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcp_queue', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('key');
            $table->string('payload');
            $table->unsignedTinyInteger('type')->comment("0:任意のコマンド,1:設定取得コマンド(G),2:設定コマンド(A),3:メッセージ");
            $table->unsignedTinyInteger('attempts');
            $table->dateTime('created_at');
        });

//        Schema::create('tcp_failed_queue', function (Blueprint $table) {
//            $table->bigIncrements('id');
//            $table->string('key');
//            $table->string('payload');
//            $table->unsignedTinyInteger('type');
//            $table->dateTime('created_at');
//        });

        Schema::create('http_queue', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('data_id');
            $table->string('payload');
            $table->unsignedTinyInteger('attempts');
            $table->dateTime('created_at');
        });

//        Schema::create('http_failed_queue', function (Blueprint $table) {
//            $table->bigIncrements('id');
//            $table->uuid('data_id');
//            $table->string('payload');
//            $table->dateTime('created_at');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcp_queue');
        Schema::dropIfExists('tcp_failed_queue');
        Schema::dropIfExists('http_queue');
        Schema::dropIfExists('http_failed_queue');
    }
}
