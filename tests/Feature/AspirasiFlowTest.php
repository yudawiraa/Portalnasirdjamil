<?php

namespace Tests\Feature;

use App\Models\Aspirasi;
use App\Models\AspirasiCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AspirasiFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_can_submit_aspirasi_with_attachment_and_track_it(): void
    {
        $this->withoutVite();
        $this->seed();

        $category = AspirasiCategory::query()->firstOrFail();

        $response = $this->post(route('aspirasi.store'), [
            'name' => 'Ahmad Fauzi',
            'nik' => '1101010101010001',
            'whatsapp' => '0812-3456-7890',
            'email' => 'ahmad@example.test',
            'city' => 'Bireuen',
            'district_village' => 'Kota Juang',
            'category_id' => $category->id,
            'title' => 'Permohonan bantuan penanganan kasus hukum',
            'body' => 'Saya membutuhkan bantuan untuk menindaklanjuti persoalan hukum yang sudah berjalan cukup lama.',
            'agreement' => '1',
            'attachments' => [
                UploadedFile::fake()->create('bukti.pdf', 128, 'application/pdf'),
            ],
        ]);

        $aspirasi = Aspirasi::query()->with(['attachments', 'histories'])->firstOrFail();

        $response->assertRedirect(route('aspirasi.success', $aspirasi->code));
        $this->get(route('aspirasi.success', $aspirasi->code))
            ->assertOk()
            ->assertSee($aspirasi->code)
            ->assertSee('Kode aspirasi bukan OTP WhatsApp')
            ->assertSee('Salin Kode Aspirasi');

        $this->assertSame('6281234567890', $aspirasi->whatsapp);
        $this->assertMatchesRegularExpression('/^ASP-\d{4}-\d{5}$/', $aspirasi->code);
        $this->assertCount(1, $aspirasi->attachments);
        $this->assertCount(1, $aspirasi->histories);
        $this->assertTrue($aspirasi->attachments->first()->hasDatabaseContent());

        $this->post(route('aspirasi.track.lookup'), [
            'code' => $aspirasi->code,
            'whatsapp' => '081234567890',
        ])
            ->assertOk()
            ->assertSee($aspirasi->title)
            ->assertSee('Diterima')
            ->assertDontSee($aspirasi->nik);
    }

    public function test_submit_aspirasi_rejects_invalid_required_data(): void
    {
        $this->withoutVite();
        $this->seed();

        $this->post(route('aspirasi.store'), [])
            ->assertSessionHasErrors(['name', 'whatsapp', 'city', 'category_id', 'title', 'body', 'agreement']);
    }

    public function test_tracking_requires_matching_whatsapp_number(): void
    {
        $this->withoutVite();
        $this->seed();

        $category = AspirasiCategory::query()->firstOrFail();
        $aspirasi = Aspirasi::create([
            'code' => 'ASP-2026-12345',
            'name' => 'Siti Aminah',
            'whatsapp' => '6281111111111',
            'city' => 'Langsa',
            'category_id' => $category->id,
            'title' => 'Aspirasi pelayanan publik',
            'body' => 'Mohon tindak lanjut terkait pelayanan publik di wilayah kami.',
            'status' => Aspirasi::STATUS_RECEIVED,
            'submitted_at' => now(),
        ]);

        $aspirasi->histories()->create([
            'to_status' => Aspirasi::STATUS_RECEIVED,
            'note' => 'Aspirasi masuk.',
            'created_at' => now(),
        ]);

        $this->post(route('aspirasi.track.lookup'), [
            'code' => 'ASP-2026-12345',
            'whatsapp' => '081999999999',
        ])
            ->assertOk()
            ->assertSee('tidak ditemukan')
            ->assertDontSee('Aspirasi pelayanan publik');
    }
}
