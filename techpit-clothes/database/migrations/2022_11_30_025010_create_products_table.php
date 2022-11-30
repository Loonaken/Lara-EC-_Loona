<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            //^^ 商品のid
            $table->string('name');
            //^^ 商品の名前＋比較的に字数が少ない場合にstring
            $table->text('description');
            //^^ 商品の説明＋長文のためにtext
            $table->string('image');
            //^^ 商品の画像＋pathで渡すためstring
            $table->bigInteger('price');
            //^^ 商品の値段＋数字なのでIntegerでも良いが、所感でbitInteger
            $table->timestamps();
            //^^ 商品の更新日時、表示日時
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
