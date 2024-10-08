<?php

namespace Database\Seeders;

use App\Models\VirtualAccount;
use App\Models\Wallets;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VirtualAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $wallet = Wallets::where("customer_id", "EKO")->firstOrFail();
        $virtualAccount = new VirtualAccount();
        $virtualAccount->bank = "BCA";
        $virtualAccount->va_number = "12345678";
        $virtualAccount->wallet_id = $wallet->id;
        $virtualAccount->save();
    }
}
