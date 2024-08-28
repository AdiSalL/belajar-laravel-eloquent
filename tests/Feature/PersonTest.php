<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonTest extends TestCase
{
    public function testPerson() {
        $person = new Person();
        $person->first_name = "ADI";
        $person->last_name = "Salafudin";
        $person->save();
        
        self::assertEquals("ADI Salafudin", $person->full_name);
        $person->full_name = "JOKO Morro";
        $person->save();
        self::assertEquals("JOKO", $person->first_name);
        self::assertEquals("Morro", $person->last_name);
        
    }

    public function testAttributeCasting() {
        $person = new Person();
        $person->first_name = "ADI";
        $person->last_name = "Salafudin";
        $person->save();
        
        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);
        
    }

    public function testCustomCasts() {
        $person = new Person();
        $person->first_name = "ADI";
        $person->last_name = "Salafudin";
        $person->address = new Address("JL. Gatak", "Jakarta",  "Indonesia", "1111");
        $person->save();
        
        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);
        self::assertEquals("JL. Gatak", $person->address->street);
        self::assertEquals("Jakarta", $person->address->city);
        self::assertEquals("Indonesia", $person->address->country);
        self::assertEquals("1111", $person->address->postal_code);
        
        
    }

}
