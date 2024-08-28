<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Voucher;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\VoucherSeeder;
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

    public function testOneToOnePolyMorphicProduct() {
        $this->seed([CategorySeeder::class ,ProductSeeder::class , ImageSeeder::class]);

        $product = Product::find("1");
        self::assertNotNull($product);

        $image = $product->image;
        self::assertNotNull($image);

        self::assertEquals("https://robohash.org/2.png?size=200x200", $image->url);
    }

    public function testOneToManyPolymorphicComment() {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class ,CommentSeeder::class]);
        $product = Product::find("1");
        $voucher = Voucher::first();
        self::assertNotNull($voucher);
        self::assertNotNull($product);

        $comments = $product->comments;
        $voucherComments = $voucher->comments;
        self::assertNotNull($voucherComments);
        foreach($comments as $comment) {
            self::assertEquals("product", $comment->commentable_type);
            self::assertEquals($product->id, $comment->commentable_id);
        }
    }

    public function testOneOfManyPolymorphic() {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class]);
        $product = Product::find("1");
        self::assertNotNull($product);

        $comment = $product->latestComment;
        self::assertNotNull($comment);

        $comment = $product->oldestComment;
        self::assertNotNull($comment);
    }

    public function testManyToManyPolyMorphic() {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, TagSeeder::class ]);

        $product = Product::find("1");
        $tags = $product->tags;
        self::assertNotNull($tags);
        self::assertCount(1, $tags);

        foreach($tags as $tag) {
            self::assertNotNull($tag->id);
            self::assertNotNull($tag->name);
            $vouchers = $tag->vouchers;
            self::assertNotNull($vouchers);
            self::assertCount(1, $vouchers);
        }
    }

    public function testEloquentCollection() {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $products = Product::get();
        $products = $products->toQuery()->where("price", "=", 200)->get();
        self::assertCount(1, $products);
        self::assertEquals("2", $products[0]->id);
    }

}

