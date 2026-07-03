<?php

namespace Tests\Unit;

use App\Http\Controllers\AspirasiController;
use App\Models\Aspirasi;
use PHPUnit\Framework\TestCase;

class AspirasiStatusTest extends TestCase
{
    public function test_status_label_mapping_and_whatsapp_normalization(): void
    {
        $this->assertSame('Diterima', Aspirasi::statusLabel(Aspirasi::STATUS_RECEIVED));
        $this->assertSame('Tidak Diketahui', Aspirasi::statusLabel('unknown'));
        $this->assertSame('6281234567890', AspirasiController::normalizeWhatsapp('0812-3456-7890'));
        $this->assertSame('6281234567890', AspirasiController::normalizeWhatsapp('+62 812 3456 7890'));
    }
}
