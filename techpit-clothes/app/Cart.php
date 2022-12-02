<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'line_items',
        )->withPivot(['id','quantity']);
    }
}
/**cartモデル内でproductsとの関係を表したいため、リレーションメソッド名はproductsとしている
*Cart<->Product＝多対多＝belongsToManyと定義
*第一引数=リレーションの相手(ここではproduct)
*第二引数=中間テーブル名(ここではline_items)
*withPivotは中間テーブルの情報をアクセスするために使う（id,quantity情報）（色々な場面で*$product->pivot->quantityのように使えるよう）
*/
