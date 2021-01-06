<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->text('description');
            $table->text('mp3');
            $table->text('image');
            // 外部キー制約をつけたい場合、参照先のカラム型と合わせる
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->tinyInteger('status')->default(1)->comment('0=下書き、1=公開,2=削除');
            // timestampと書いてしまうと、レコード挿入時、更新時に値が入らないので、DB::rawで直接書いてます
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('musics');
    }
}