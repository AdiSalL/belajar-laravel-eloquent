<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        
        $customer = new Customer();
        $customer->id = "EKO";
        $customer->name = "Eko";
        $customer->email = "adiefsal@gmail.com";
        $customer->save();
    }
}
