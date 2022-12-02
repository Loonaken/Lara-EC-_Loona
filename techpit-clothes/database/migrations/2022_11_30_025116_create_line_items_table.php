<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineItemsTable extends Migration
{
    /
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('cart_id')
                ->references('id')
                ->on('carts');
            //cartテーブルから情報を紐付け
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
        });
        //productテーブルから情報を紐付け
    }
    //このline_items_tableの目的はproductとcartの関係は多対多であるが、直接関係は結べないので中間テーブルを作成している
    //$table->foreign('外部キー')
    //->references('外部キーに対応する親テーブルの主キー')
    //->on('親テーブル名');

    // 
    //  * Reverse the migrations.
    //  *
    //  * @return void
    //  */
    public function down()
    {
        Schema::dropIfExists('line_items');
    }
}
