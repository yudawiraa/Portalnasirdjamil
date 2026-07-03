<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\AspirasiCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AspirasiController extends Controller
{
    public function create(): View
    {
        return view('aspirasi.create', [
            'categories' => AspirasiCategory::query()->where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'nik' => ['nullable', 'digits:16'],
            'whatsapp' => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s()]{8,30}$/'],
            'email' => ['nullable', 'email', 'max:150'],
            'city' => ['required', 'string', 'max:100'],
            'district_village' => ['nullable', 'string', 'max:150'],
            'category_id' => ['required', Rule::exists('aspirasi_categories', 'id')->where('is_active', true)],
            'title' => ['required', 'string', 'max:200'],
            'body' => ['required', 'string', 'min:20'],
            'agreement' => ['accepted'],
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $validated['whatsapp'] = self::normalizeWhatsapp($validated['whatsapp']);

        $aspirasi = DB::transaction(function () use ($request, $validated): Aspirasi {
            $aspirasi = Aspirasi::create([
                'code' => $this->generateCode(),
                'name' => $validated['name'],
                'nik' => $validated['nik'] ?? null,
                'whatsapp' => $validated['whatsapp'],
                'email' => $validated['email'] ?? null,
                'city' => $validated['city'],
                'district_village' => $validated['district_village'] ?? null,
                'category_id' => $validated['category_id'],
                'title' => $validated['title'],
                'body' => $validated['body'],
                'status' => Aspirasi::STATUS_RECEIVED,
                'submitted_at' => now(),
            ]);

            foreach ($request->file('attachments', []) as $file) {
                $path = $file->store('aspirasi/'.$aspirasi->code);

                $aspirasi->attachments()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime_type' => $file->getMimeType() ?: 'application/octet-stream',
                    'size_bytes' => $file->getSize(),
                ]);
            }

            $aspirasi->histories()->create([
                'from_status' => null,
                'to_status' => Aspirasi::STATUS_RECEIVED,
                'note' => 'Aspirasi dikirim melalui form publik.',
                'created_at' => now(),
            ]);

            return $aspirasi;
        });

        return redirect()->route('aspirasi.success', $aspirasi->code);
    }

    public function success(string $code): View
    {
        $aspirasi = Aspirasi::query()->where('code', $code)->firstOrFail();

        return view('aspirasi.success', compact('aspirasi'));
    }

    public static function normalizeWhatsapp(string $value): string
    {
        $number = preg_replace('/\D+/', '', $value) ?: '';

        if (str_starts_with($number, '0')) {
            return '62'.substr($number, 1);
        }

        return $number;
    }

    private function generateCode(): string
    {
        do {
            $code = 'ASP-'.now()->format('Y').'-'.random_int(10000, 99999);
        } while (Aspirasi::query()->where('code', $code)->exists());

        return $code;
    }
}
