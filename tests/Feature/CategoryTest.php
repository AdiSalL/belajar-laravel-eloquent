<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

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
                "name" => "Name $i"
            ];
        }
        

        $result = Category::query()->insert($categories);

        $total = Category::count();
        $this->assertEquals($total, 10);
        $this->assertTrue($result);
    }
}
