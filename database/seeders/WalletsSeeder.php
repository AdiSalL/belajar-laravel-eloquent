<?php

namespace Database\Seeders;

use App\Models\Wallets;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $wallet = new Wallets();
        $wallet->amount = 1000000;
        $wallet->customer_id = "EKO";
        $wallet->save();
    }
}
