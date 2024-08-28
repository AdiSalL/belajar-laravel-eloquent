<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table("person")->delete();
        DB::table("reviews")->delete();
        DB::table("images")->delete();
        DB::table("customers_likes_products")->delete();
        DB::table("tags")->delete();
        DB::table("taggables")->delete();
        DB::table("products")->delete();
        DB::table("categories")->delete();
        DB::table("vouchers")->delete();
        DB::table("virtual_accounts")->delete();
        DB::table("wallets")->delete();
        DB::table("customers")->delete();
    }
}
