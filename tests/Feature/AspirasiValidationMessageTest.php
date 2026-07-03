<?php

namespace Tests\Feature;

use App\Models\AspirasiCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AspirasiValidationMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_short_aspirasi_body_shows_clear_indonesian_message(): void
    {
        $this->withoutVite();
        $this->seed();

        $category = AspirasiCategory::query()->firstOrFail();

        $this->from(route('aspirasi.create'))->post(route('aspirasi.store'), [
            'name' => 'Pengirim Test',
            'whatsapp' => '081234567890',
            'city' => 'Bireuen',
            'category_id' => $category->id,
            'title' => 'Judul test',
            'body' => 'pendek',
            'agreement' => '1',
        ])
            ->assertRedirect(route('aspirasi.create'))
            ->assertSessionHasErrors([
                'body' => 'uraian lengkap aspirasi minimal 20 karakter.',
            ]);
    }
}
