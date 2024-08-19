<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VoucherTest extends TestCase
{
    public function testCreateVoucher() {
        $voucher = new Voucher();
        $voucher->name = "Sample Voucher";
        $voucher->voucher_code  = "0000001";
        $voucher->save();

        $this->assertNotNull($voucher->id);
    }

    public function testCreateVoucherCode() {
        $voucher = new Voucher();
        $voucher->name = "Sample Voucher";
        $voucher->save();

        $this->assertNotNull($voucher->id);
        $this->assertNotNull($voucher->voucher_code);
        
    }

    public function testSoftDelete() {
        $this->seed(VoucherSeeder::class);
        $voucher = Voucher::where("name", "=", "Sample Voucher")->first();

        $voucher->delete();
        $this->assertNotNull($voucher);
        $voucher = Voucher::where("name", "=", "Sample Voucher")->first();

        $this->assertNull($voucher);
    }

    
    public function testTakeSoftDelete() {
        $this->seed(VoucherSeeder::class);
        $voucher = Voucher::where("name", "=", "Sample Voucher")->first();

        $voucher->delete();

        $voucher = Voucher::withTrashed()->where("name", "=", "Sample Voucher")->first();

        $this->assertNotNull($voucher);
    }


}
