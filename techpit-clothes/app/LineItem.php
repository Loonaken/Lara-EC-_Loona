<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineItem extends Model
{
   protected $fillable = ['cart_id' , 'product_id' , 'quantity'];
   // Line_item-controllerでデータ保管、更新作業をしたため、モデル内で保管、更新許可を出す必要があり、$fillableで許可作業をしてる
}
