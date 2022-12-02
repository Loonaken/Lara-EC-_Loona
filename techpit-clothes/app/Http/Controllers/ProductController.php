<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index')
            ->with('products', Product::get());
    }
    //**productテーブルの全データを取得してbladeで'products'という変数を使えるようにしてる
    //冒頭のApp\Product;はメソッド内でproductテーブルのデータが取得できるために「先に使うよ」と定義してる
    //**('product.index', ['products' => $products])でも可


    public function show($id){

        return view('product.show')
        ->with('product', Product::find($id));
    }
    //**productテーブルの中で特定の商品のみのデータを取り出すためにidを取り出してproductにあてはめてる
}
