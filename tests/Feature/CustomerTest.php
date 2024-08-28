<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Image;
use App\Models\Wallets;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
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

    public function testManyToMany() {
        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]);

        $customer = Customer::find("EKO");
        self::assertNotNull($customer);

        $customer->likeProducts()->attach("1");

        $product = $customer->likeProducts;
        self::assertCount(1, $product);
        self::assertEquals("1", $product[0]->id);
    }

    public function testRemoveToManyDetach() {
        $this->testManyToMany();

        $customer = Customer::find("EKO");
        $customer->likeProducts()->detach("1");

        $product = $customer->likeProducts;
        self::assertCount(0, $product);
    }

    public function testPivotAttribute() {
        $this->testManyToMany();

        $customer = Customer::find("EKO");
        $products = $customer->likeProducts;

        foreach($products as $product){
            $pivot = $product->pivot;
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
            
        }
    }

    public function testPivotAttributeCondition() {
        $this->testManyToMany();

        $customer = Customer::find("EKO");
        $products = $customer->likeProductsLastWeek;

        foreach($products as $product){
            $pivot = $product->pivot;
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
            
        }
    }

    public function testPivotModel() {
        $this->testManyToMany();

        $customer = Customer::find("EKO");
        $products = $customer->likeProducts;

        foreach($products as $product){
            $pivot = $product->pivot;
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
            self::assertNotNull($pivot->product);
            self::assertNotNull($pivot->customer);
            
        }
    }

    public function testOneToOnePolyMorphic() {
        $this->seed([CustomerSeeder::class, ImageSeeder::class]);

        $customer = Customer::find("EKO");
        self::assertNotNull($customer);

        $image = $customer->image;
        self::assertNotNull($image);

        self::assertEquals("https://robohash.org/1.png?size=200x200", $image->url);
    }

    public function testEager() {
        $this->seed([CustomerSeeder::class, WalletsSeeder::class, ImageSeeder::class]);

        $customer = Customer::with(["wallet", "image"])->find("EKO");
        self::assertNotNull($customer);
    }

    public function testEagerModel() {
        $this->seed([CustomerSeeder::class, WalletsSeeder::class, ImageSeeder::class]);
        $customer = Customer::find("EKO");
        self::assertNotNull($customer);
    }

    
}
