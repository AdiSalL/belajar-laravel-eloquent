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
        DB::table("products")->delete();
        DB::table("categories")->delete();
        DB::table("vouchers")->delete();
        DB::table("wallets")->delete();
        DB::table("customers")->delete();
   
        
    
        
        
        
    }
}
