<?php

namespace Tests\Feature;

use App\Models\Aspirasi;
use App\Models\AspirasiCategory;
use App\Models\AspirationAttachment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminAspirasiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_routes_require_login(): void
    {
        $this->withoutVite();

        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_login_and_update_aspirasi_status(): void
    {
        $this->withoutVite();
        $this->seed();

        $admin = User::query()->firstOrFail();
        $category = AspirasiCategory::query()->firstOrFail();
        $aspirasi = Aspirasi::create([
            'code' => 'ASP-2026-22222',
            'name' => 'Rahmat',
            'whatsapp' => '6281212121212',
            'city' => 'Pidie',
            'category_id' => $category->id,
            'title' => 'Aspirasi penegakan hukum',
            'body' => 'Mohon perhatian terhadap proses penegakan hukum di daerah.',
            'status' => Aspirasi::STATUS_RECEIVED,
            'submitted_at' => now(),
        ]);

        $this->post(route('admin.login.submit'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->get(route('admin.aspirasi.show', $aspirasi))
            ->assertOk()
            ->assertSee('Prioritas Aspirasi')
            ->assertSee('Penanggung Jawab')
            ->assertSee('Hasil Verifikasi')
            ->assertSee('Riwayat Tindak Lanjut')
            ->assertSee('Cetak Detail');

        $this->patch(route('admin.aspirasi.update', $aspirasi), [
            'status' => Aspirasi::STATUS_IN_REVIEW,
            'priority' => Aspirasi::PRIORITY_HIGH,
            'category_id' => $category->id,
            'assigned_to' => 'Tenaga Ahli Komisi III',
            'verification_result' => 'Data pengirim dan kategori aspirasi sudah diverifikasi.',
            'public_response' => 'Sedang ditelaah oleh tim.',
            'internal_note' => 'Prioritas normal.',
            'history_note' => 'Masuk tahap telaah.',
        ])->assertRedirect();

        $this->assertDatabaseHas('aspirations', [
            'id' => $aspirasi->id,
            'status' => Aspirasi::STATUS_IN_REVIEW,
            'priority' => Aspirasi::PRIORITY_HIGH,
            'assigned_to' => 'Tenaga Ahli Komisi III',
            'verification_result' => 'Data pengirim dan kategori aspirasi sudah diverifikasi.',
            'public_response' => 'Sedang ditelaah oleh tim.',
        ]);

        $this->assertDatabaseHas('aspiration_status_histories', [
            'aspiration_id' => $aspirasi->id,
            'from_status' => Aspirasi::STATUS_RECEIVED,
            'to_status' => Aspirasi::STATUS_IN_REVIEW,
            'changed_by' => $admin->id,
        ]);
    }

    public function test_admin_dashboard_shows_code_and_analytics(): void
    {
        $this->withoutVite();
        $this->seed();

        $admin = User::query()->firstOrFail();
        $category = AspirasiCategory::query()->firstOrFail();

        Aspirasi::create([
            'code' => 'ASP-2026-55555',
            'name' => 'Masyarakat Aceh',
            'whatsapp' => '6281515151515',
            'city' => 'Aceh Barat',
            'category_id' => $category->id,
            'title' => 'Aspirasi layanan hukum',
            'body' => 'Mohon tindak lanjut terkait akses layanan hukum di daerah.',
            'status' => Aspirasi::STATUS_RECEIVED,
            'submitted_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Analitik Aspirasi')
            ->assertSee('Rekap Bulanan')
            ->assertSee('Wilayah Pengirim')
            ->assertSee('ASP-2026-55555')
            ->assertSee('Export CSV')
            ->assertSee('Export Excel');
    }

    public function test_admin_can_export_filtered_aspirasi_reports(): void
    {
        $this->withoutVite();
        $this->seed();

        $admin = User::query()->firstOrFail();
        $category = AspirasiCategory::query()->firstOrFail();

        Aspirasi::create([
            'code' => 'ASP-2026-66666',
            'name' => 'Pemohon Export',
            'whatsapp' => '6281616161616',
            'city' => 'Langsa',
            'category_id' => $category->id,
            'title' => 'Aspirasi untuk laporan',
            'body' => 'Data ini digunakan untuk memastikan laporan dapat diexport.',
            'status' => Aspirasi::STATUS_COMPLETED,
            'priority' => Aspirasi::PRIORITY_HIGH,
            'assigned_to' => 'Admin Aspirasi',
            'verification_result' => 'Data valid.',
            'submitted_at' => now(),
        ]);

        $csvResponse = $this->actingAs($admin)
            ->get(route('admin.aspirasi.export', ['format' => 'csv', 'city' => 'Langsa']))
            ->assertOk();

        $csvContent = $csvResponse->streamedContent();

        $this->assertStringContainsString('ASP-2026-66666', $csvContent);
        $this->assertStringContainsString('Pemohon Export', $csvContent);

        $this->actingAs($admin)
            ->get(route('admin.aspirasi.export', ['format' => 'xls', 'city' => 'Langsa']))
            ->assertOk()
            ->assertSee('Kode Aspirasi')
            ->assertSee('ASP-2026-66666');
    }

    public function test_attachment_download_is_admin_only(): void
    {
        $this->withoutVite();
        $this->seed();
        Storage::fake('local');

        $admin = User::query()->firstOrFail();
        $category = AspirasiCategory::query()->firstOrFail();
        $aspirasi = Aspirasi::create([
            'code' => 'ASP-2026-33333',
            'name' => 'Masyarakat',
            'whatsapp' => '6281313131313',
            'city' => 'Bener Meriah',
            'category_id' => $category->id,
            'title' => 'Aspirasi dokumen',
            'body' => 'Aspirasi dengan dokumen pendukung untuk diuji.',
            'status' => Aspirasi::STATUS_RECEIVED,
            'submitted_at' => now(),
        ]);

        Storage::disk('local')->put('aspirasi/ASP-2026-33333/bukti.pdf', 'dummy');

        $attachment = AspirationAttachment::create([
            'aspiration_id' => $aspirasi->id,
            'original_name' => 'bukti.pdf',
            'path' => 'aspirasi/ASP-2026-33333/bukti.pdf',
            'mime_type' => 'application/pdf',
            'size_bytes' => 5,
        ]);

        $url = route('admin.aspirasi.attachments.download', [$aspirasi, $attachment]);

        $this->get($url)->assertRedirect(route('admin.login'));
        $this->actingAs($admin)->get($url)->assertOk();
    }

    public function test_database_attachment_download_is_admin_only(): void
    {
        $this->withoutVite();
        $this->seed();

        $admin = User::query()->firstOrFail();
        $category = AspirasiCategory::query()->firstOrFail();
        $aspirasi = Aspirasi::create([
            'code' => 'ASP-2026-44444',
            'name' => 'Masyarakat',
            'whatsapp' => '6281414141414',
            'city' => 'Aceh Tengah',
            'category_id' => $category->id,
            'title' => 'Aspirasi dokumen database',
            'body' => 'Aspirasi dengan dokumen pendukung yang disimpan di database.',
            'status' => Aspirasi::STATUS_RECEIVED,
            'submitted_at' => now(),
        ]);

        $attachment = AspirationAttachment::create([
            'aspiration_id' => $aspirasi->id,
            'original_name' => 'bukti-db.pdf',
            'path' => 'database:aspirasi/ASP-2026-44444/bukti-db.pdf',
            'mime_type' => 'application/pdf',
            'size_bytes' => 5,
            'content' => base64_encode('dummy'),
        ]);

        $url = route('admin.aspirasi.attachments.download', [$aspirasi, $attachment]);

        $this->get($url)->assertRedirect(route('admin.login'));
        $this->actingAs($admin)->get($url)
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }
}
