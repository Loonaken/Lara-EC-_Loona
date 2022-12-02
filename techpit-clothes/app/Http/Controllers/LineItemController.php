<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\LineItem;
use App\Product;
use App\Cart;

class LineItemController extends Controller
{
    public function create(Request $request)
    {
        $cart_id = Session::get('cart');
        $line_item = LineItem::where('cart_id', $cart_id)
            ->where('product_id', $request->input('id'))
            ->first();
            // line_itemsテーブルからcart_id,product_idの絞り込みをしている
            // 2つ目->whereを使ってのAND絞り込みをしている
            // 第一引数はカラム名、第二引数は値を指定

        if ($line_item) {
            $line_item->quantity += $request->input('quantity');
            $line_item->save();
            // 先ほど入れたline_itemテーブルから探して$line_itemにデータリサーチの作業を行なっていたが、リサーチしたデータがあったら↓
            // $line_itemのデータの中にあるquantityの値に、product>index.bladeで↓
            // 「<input type="number" name="quantity" min="1" value="1" require/>」の中のquantity,value(POSTリクエストの顧客クリックによって->1~n)を追加する

        } else {
            LineItem::create([
                'cart_id' => $cart_id,
                'product_id' => $request->input('id'),
                'quantity' => $request->input('quantity')
            ]);
            // データリサーチの結果なければ、上記のデータを連想配列の形で保管する
            // requestはbladeから値の取得を行なってる
         }

         return redirect(route('cart.index'));
     }

     public function delete(Request $request)
     {
        LineItem::destroy($request->input('id'));

        return redirect(route('cart.index'));
     }
}
