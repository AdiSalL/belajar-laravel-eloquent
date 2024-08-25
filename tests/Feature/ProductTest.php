<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertNotNull;

class ProductTest extends TestCase
{
    public function testOneToMany() {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        
        $product = Product::find("1");
        self::assertNotNull($product);

        $category = $product->category;
        self::assertNotNull($category);
        self::assertEquals("FOOD", $category->id);
    }

    public function testHasOneOfMany() {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find("FOOD");
        self::assertNotNull($category);

        $cheapestProduct = $category->cheapestProducts;
        self::assertNotNull($cheapestProduct);
        self::assertEquals("Product 1", $cheapestProduct->name);

        
        $mostExpensiveProducts = $category->mostExpensiveProducts;
        self::assertNotNull($mostExpensiveProducts);
        self::assertEquals("Product 2", $mostExpensiveProducts->name);

    }
}
