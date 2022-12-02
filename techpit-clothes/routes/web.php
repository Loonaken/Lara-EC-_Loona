<?php

Route::name('product.')->group(function () {
    Route::get('/', 'ProductController@index')->name('index');
    //**ルートの名前の冒頭をproduct.で統一しているので、indexルート、showルートも名前はproduct.index, product.showになる
    //ProductController@indexではコントローラーに記載されてるindexメソッドが実行される
    //**一番最初の表層

    Route::get('/product/{id}','ProductController@show')->name('show');
});
    //**showメソッドに誘導するためにmigrationファイルで商品にidタグが付けられているが、一つ一つの商品の詳細を確認するためにルートurlの枝葉にidがついている

Route::name('line_item.')->group(function(){
    Route::post('/line_item/create','LineItemController@create')->name('create');
    Route::post('/line_item/delete','LineItemController@delete')->name('delete');
});

    //**ルートのファサードにおいて、postではhttpリクエストをおこなっているため、postにしている
    //**カートの購入において、登録(create)・取消(delete)

Route::name('cart.')->group(function(){
    Route::get('/cart', 'CartController@index')->name('index');
    Route::get('/cart/checkout', 'CartController@checkout')->name('checkout');
    Route::get('/cart/success', 'CartController@success')->name('success');
});

    //**カートの購入確認の表示でindex
    //**カートの購入手続き処理でcheckout
    //**stripeにて購入完了の際の処理でsuccess
