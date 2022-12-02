<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
//**セッションファサードの使用
use App\Cart;

class Cartsession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Session::has('cart')) {
            //セッションにカートidが存在するかどうか
            //(!)は、なければ、という意味
            $cart = Cart::create();
            /**このcreateメソッドは$cartにid,タイムスタンプidを代入している
            *$cart変数は元々migrationファイルではcart_id, タイムスタンプidが備わっているため、ここでは空白でおっけ
            *新たに変数に値を代入したい場合は
            *Product::create(['name' => 'TShirt', `description` => `Tシャツです`]);とすることができる
            */

            Session::put('cart', $cart->id);
        }
        return $next($request);
    }
}

//**セッションに値を保存するため
//**第一引数=キー名、第二引数=値
