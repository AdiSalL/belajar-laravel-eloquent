<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Wallets;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testOneToOne() {
        $this->seed([CustomerSeeder::class, WalletsSeeder::class]);
        $customer = Customer::find("EKO");
        $this->assertNotNull($customer);

        // $wallet = Wallets::where("customer_id", $customer->id)->first();
        $wallet = $customer->wallet;
        self::assertNotNull($wallet);
        self::assertEquals(1000000, $wallet->amount);
    }

    public function testOneToOneQuery() {
        $customer = new Customer();
        $customer->id = "ADI";
        $customer->name = "Adi";
        $customer->email = "adi@adi.com";
        $customer->save();

        $wallet = new Wallets();
        $wallet->amount = 1000000;
        $customer->wallet()->save($wallet);
        

        self::assertNotNull($wallet->customer_id);

    }

    public function testHasOneThrough() {
        $this->seed([CustomerSeeder::class, WalletsSeeder::class, VirtualAccountSeeder::class]);
        $customer = Customer::find("EKO");
        self::assertNotNull($customer);

        $virtualAccount = $customer->virtualAccount;
        self::assertNotNull($virtualAccount);
        self::assertEquals("BCA", $virtualAccount->bank);
    }
}
