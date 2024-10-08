<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Scopes\IsActiveScope;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ReviewSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertTrue;

class CategoryTest extends TestCase
{
    public function testInsert() {
        $category = new Category();
        
        $category->id = "GADGET";
        $category->name = "Gadget";
        $result = $category->save();
        
        self::assertTrue($result);
    }

    public function testInsertMany() {
        $categories = [];
        for($i = 0; $i < 10; $i++) {
            $categories[] = [
                "id" => "ID $i",
                "name" => "Name $i",
                "is_active" => true
            ];
        }
        

        $result = Category::query()->insert($categories);

        $total = Category::count();
        $this->assertEquals($total, 10);
        $this->assertTrue($result);
    }

    public function testFind() {
        $this->seed(CategorySeeder::class);

        $category = Category::find("FOOD");
        
        $this->assertNotNull($category);
        $this->assertEquals("FOOD", $category->id);
        $this->assertEquals("Food", $category->name);
        $this->assertEquals("Food Category", $category->description);
        
    }

    public function testUpdate() {
        $this->seed(CategorySeeder::class);

        $category = Category::find("FOOD");
        $category->name = "Food Updated";

        $result = $category->update();
        self::assertTrue($result);
    }

    public function testSelect() {
        for($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->id = "ID $i";
            $category->name = "Name $i";
            $category->is_active = true;
            $category->save();
        }

        $categories = Category::query()->whereNull("description")->get();
        self::assertEquals(5, $categories->count());
        $categories->each(function ($category) {
            self::assertNull($category->description);
            Log::info(json_encode($category));
        });
    }

    
    public function testSelectUpdate() {
        for($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->id = "ID $i";
            $category->name = "Name $i";
            $category->is_active = true;
            $category->save();
        }

        $categories = Category::query()->whereNull("description")->get();
        self::assertEquals(5, $categories->count());
        $categories->each(function ($category) {
            $category->description = "Updated";
            $category->update();
            self::assertNotNull($category->description);
            Log::info(json_encode($category));
        });
    }

    public function testUpdateMany() {
        $categories = [];
        for($i = 0; $i < 10; $i++) {
            $categories[] = [
                "id" => "ID $i",
                "name" => "Name $i",
                "is_active" => true
            ];
        }
        $result = Category::insert($categories);
        $this->assertTrue($result);

        Category::whereNull("description")->update([
            "description" => "Updated"
        ]);

        $total = Category::where("description", "=", "Updated")->count();
        $result = Category::where("description", "=", "Updated")->get();
        $result->each(function ($item) {
            Log::info(json_encode($item));
        });
        $this->assertEquals(10, $total);
    }

    public function testDelete() {
        $this->seed(CategorySeeder::class);

        $category = Category::query()->find("FOOD");
        $result = $category->delete();
        self::assertTrue($result);

        $total = Category::count();
        self::assertEquals(0, $total);
    }

    public function testDeleteMany() {
        $categories = [];
        for($i = 0; $i < 10; $i++) {
            $categories[] = [
                "id" => "ID $i",
                "name" => "Name $i",
                "is_active" => true
            ];
        }
        $result = Category::insert($categories);
        $this->assertTrue($result);

        $total = Category::count();
        assertEquals(10, $total);

        $result = Category::whereNull("description")->delete();
        $result = Category::count();
        assertEquals(0, $result);
    }

    public function testCreate() {
        $request = [
            "id" => 'FOOD',
            "name" => "Food",
            "description" => "Food Category Description"
        ];
        $category = new Category($request);
        $category->save();

        self::assertNotNull($category->id);
    }

    public function testCreateMethod() {
        $request = [
            "id" => 'FOOD',
            "name" => "Food",
            "description" => "Food Category Description"
        ];

        $category = Category::create($request);
        self::assertNotNull($category->id);
    }

    public function testUpdateMass() {
        $this->seed(CategorySeeder::class);

        $request = [
            "name" => "Food Updated",
            "desription" => 'Food Category Updated'
        ];
        $category = Category::find("FOOD");
        $category->fill($request);
        $category->save();

        self::assertNotNull($category->id);
    }

    public function testRemoveGlobalScope() {
        $category = new Category();
        $category->id = "FOOD";
        $category->name = "Food";
        $category->description = "Food Category";
        $category->is_active = false;
        $category->save();

        $category = Category::query()->find("FOOD");
        self::assertNull($category);
        
        $category = Category::withoutGlobalScopes([IsActiveScope::class])->find("FOOD");
        $this->assertNotNull($category);
    }

    public function testOneToMany() {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $category = Category::find("FOOD");
        self::assertNotNull($category);
        $products = $category->products;

        self::assertNotNull($products);
        self::assertCount(2, $products);
    }

    
    public function testOneToManyQuery() {
        $category = new Category();
        $category->id = "FOOD";
        $category->name = "Food";
        $category->description = "Food Category";
        $category->is_active = true;
        $category->save();
        
        $product = new Product();
        $product->id = 1;
        $product->name = "Product 1";
        $product->description = "Description 1";
        $category->products()->save($product);
        self::assertNotNull($product->category_id);
    }

    public function testRelationshipQuery() {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find("FOOD");
        $products = $category->products;
        self::assertCount(2, $products);

        $outOfStockProducts = $category->products()->where("stock", "<=", 0)->get();
        self::assertCount(2, $outOfStockProducts);
    }

    public function testHasManyThrough() {
        $this->seed([CategorySeeder::class, ProductSeeder::class, CustomerSeeder::class, ReviewSeeder::class]);
        $category = Category::find("FOOD");
        self::assertNotNull($category);

        $reviews = $category->reviews;
        self::assertNotNull($reviews);
        self::assertCount(2, $reviews);
    }

    public function testQueryingRelations() {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find("FOOD");
        $product = $category->products()->where("price", "=", 200)->get();
        self::assertNotNull($product);
        self::assertEquals("Product 2" ,$product[0]->name);
    }

    public function testAggregatingRelations() {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find("FOOD");
        $total = $category->products()->count();
        self::assertEquals(2, $total);

        $total = $category->products()->where("price", "=", 200)->count();
        self::assertEquals(1, $total);

    }

}
