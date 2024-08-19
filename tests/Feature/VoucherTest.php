<?php

namespace Tests\Feature;

use App\Models\Voucher;
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
}
