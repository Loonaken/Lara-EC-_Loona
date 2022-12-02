<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProductSeeder::class);
        //**ProductSeederで商品のデータを記入したのでこの記載によって、ProductSeederを活用してphpmyadminに登録する->php artisan db:seedでシード化
    }
}
