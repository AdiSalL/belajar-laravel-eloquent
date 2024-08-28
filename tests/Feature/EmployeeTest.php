<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class EmployeeTest extends TestCase
{
    public function testFactory() {
        $employee1 = Employee::factory()->programmer()->create();
        $employee1->id = "1";
        $employee1->name = "Adi";
        $employee1->save();
        self::assertNotNull(Employee::where("id", "1")->first());
        // self::assertEquals(Employee::where("id", "1")->get(), $employee1->id);
        
        $employee2 = Employee::factory()->seniorProgrammer()->create([
            "id" => "2",
            "name" => "Adi",
        ]);
        $employee2->save();
        self::assertNotNull($employee2);
        self::assertNotNull(Employee::where("id", "2")->first());
    }
}
