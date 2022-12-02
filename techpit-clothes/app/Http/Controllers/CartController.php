<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Cart;
use App\LineItem;


class CartController extends Controller
{
    public function index()
    {
        $cart_id = Session::get('cart');
        //**セキュリティ上の観点から、middleware（auth）を設定していないので、120分のセッションでカート全体のデータの受け渡しを行う機能でsessionを使っている
        //**cartのデータをセッションを通して取得する説明
        $cart = Cart::find($cart_id);
        //**カートモデル（テーブル？）の中から$cart_idを探して$cartに値を当てはめている
        // いろんな人が各々カートに商品を入れているため、カートIDを特定する必要がある。
        // そのカートIDを用いて↓のメソッドで購入する商品のデータを取り出している

        $total_price=0;
        foreach($cart->products as $product){
            $total_price += $product->price * $product->pivot->quantity;
        }
        //**先に$total_priceの定義
        //**cartの中にあるproducts情報を一つずつproductとして取り出すforeach
        //**productから価格の値と品数を取り出し、積で合計金額を求めてる

        return view('cart.index')
        ->with('line_items', $cart->products)
        ->with('total_price', $total_price);
    }
        //**カート購入確認画面に戻る
        //**その画面に中間テーブルのline_itemsの中から cartに入ってる商品の情報を取り出して表層挿入
        //**合計金額の情報も取り出して表層挿入

    public function checkout()
    {
        $cart_id = Session::get('cart');
        $cart = Cart::find($cart_id);
        //**決済メソッドにて
        //**セッション概念においては前述部分と等しい

        if(count($cart->products) <=0){
            return redirect(route('product.index'));
        }
        //**cartの中の商品個数をcount()メソッドで数えている
        //**その個数が0の場合、決済実行画面には進めず、トップページに遷移する


        $line_items =[];
        foreach($cart->products as $product){
            $line_item = [
                'price_data'=>[
                    'currency' => 'jpy',
                    'unit_amount'=>$product->price,
                    'product_data'=>[
                        'name'=>$product->name,
                        'description'=>$product->description,
                    ],
                ],
                'quantity' => $product->pivot->quantity,
            ];
            array_push($line_items, $line_item);
        }
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [$line_items],
            'success_url'        =>  route('cart.success'),
            'cancel_url'           => route('cart.index'),
            'mode'                   => 'payment',
        ]);

        return view ('cart.checkout',[
            'session'=>$session,
            'publicKey'=>env('STRIPE_PUBLIC_KEY')
        ]);
    }

    public function success()
    {
        $cart_id = Session::get('cart');
        LineItem::where('cart_id', $cart_id)->delete();
        // 決済が終了したのちにセッションからカートIDを取得する
        // そしてline_itemモデルからcart_idのデータを探し、それを削除してcart情報を空にしている

        return redirect(route('product.index'));
    }
}
