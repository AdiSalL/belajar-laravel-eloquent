<?php

namespace Tests\Feature;

use App\Models\Person;
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
}
