<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\AspirasiCategory;
use App\Models\AspirationAttachment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AspirasiAdminController extends Controller
{
    public function index(Request $request): View
    {
        $query = $this->filteredQuery($request)->with('category');

        return view('admin.aspirasi.index', [
            'aspirations' => $query->latest('submitted_at')->paginate(12)->withQueryString(),
            'categories' => AspirasiCategory::query()->orderBy('name')->get(),
            'statuses' => Aspirasi::statuses(),
            'priorities' => Aspirasi::priorities(),
            'filters' => $request->only(['q', 'status', 'priority', 'category_id', 'city', 'date_from', 'date_to']),
        ]);
    }

    public function export(Request $request, string $format): StreamedResponse|Response
    {
        $rows = $this->filteredQuery($request)
            ->with('category')
            ->latest('submitted_at')
            ->get();

        $filename = 'laporan-aspirasi-'.now()->format('Ymd-His').'.'.$format;

        if ($format === 'csv') {
            return response()->streamDownload(function () use ($rows): void {
                $output = fopen('php://output', 'w');
                fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
                fputcsv($output, $this->exportHeadings());

                foreach ($rows as $aspirasi) {
                    fputcsv($output, $this->exportRow($aspirasi));
                }

                fclose($output);
            }, $filename, [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ]);
        }

        return response()
            ->view('admin.aspirasi.export-xls', [
                'rows' => $rows,
                'headings' => $this->exportHeadings(),
            ])
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    public function show(Aspirasi $aspirasi): View
    {
        $aspirasi->load(['category', 'attachments', 'histories.admin']);

        return view('admin.aspirasi.show', [
            'aspirasi' => $aspirasi,
            'categories' => AspirasiCategory::query()->orderBy('name')->get(),
            'statuses' => Aspirasi::statuses(),
            'priorities' => Aspirasi::priorities(),
        ]);
    }

    public function update(Request $request, Aspirasi $aspirasi): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(Aspirasi::statusKeys())],
            'priority' => ['required', Rule::in(Aspirasi::priorityKeys())],
            'category_id' => ['required', Rule::exists('aspirasi_categories', 'id')],
            'assigned_to' => ['nullable', 'string', 'max:150'],
            'verification_result' => ['nullable', 'string'],
            'public_response' => ['nullable', 'string'],
            'internal_note' => ['nullable', 'string'],
            'history_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $oldStatus = $aspirasi->status;
        $newStatus = $validated['status'];

        $aspirasi->fill([
            'status' => $newStatus,
            'priority' => $validated['priority'],
            'category_id' => $validated['category_id'],
            'assigned_to' => $validated['assigned_to'] ?? null,
            'verification_result' => $validated['verification_result'] ?? null,
            'public_response' => $validated['public_response'] ?? null,
            'internal_note' => $validated['internal_note'] ?? null,
        ]);

        if ($newStatus === Aspirasi::STATUS_VERIFIED && ! $aspirasi->verified_at) {
            $aspirasi->verified_at = now();
        }

        if ($newStatus === Aspirasi::STATUS_COMPLETED && ! $aspirasi->completed_at) {
            $aspirasi->completed_at = now();
        }

        $aspirasi->save();

        if ($oldStatus !== $newStatus || filled($validated['history_note'] ?? null)) {
            $aspirasi->histories()->create([
                'from_status' => $oldStatus,
                'to_status' => $newStatus,
                'note' => $validated['history_note'] ?: 'Status diperbarui admin.',
                'changed_by' => $request->user()->id,
                'created_at' => now(),
            ]);
        }

        return back()->with('status', 'Aspirasi berhasil diperbarui.');
    }

    public function download(Aspirasi $aspirasi, AspirationAttachment $attachment): StreamedResponse
    {
        abort_unless((int) $attachment->aspiration_id === (int) $aspirasi->id, 404);

        if ($attachment->hasDatabaseContent()) {
            return response()->streamDownload(
                fn () => print $attachment->contentBytes(),
                $attachment->original_name,
                ['Content-Type' => $attachment->mime_type ?: 'application/octet-stream'],
            );
        }

        abort_unless(Storage::exists($attachment->path), 404);

        return Storage::download($attachment->path, $attachment->original_name);
    }

    private function filteredQuery(Request $request): Builder
    {
        return Aspirasi::query()
            ->search($request->string('q')->toString())
            ->when($request->filled('status'), fn (Builder $query) => $query->where('status', $request->status))
            ->when($request->filled('priority'), fn (Builder $query) => $query->where('priority', $request->priority))
            ->when($request->filled('category_id'), fn (Builder $query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('city'), fn (Builder $query) => $query->where('city', 'like', '%'.$request->city.'%'))
            ->when($request->filled('date_from'), fn (Builder $query) => $query->whereDate('submitted_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn (Builder $query) => $query->whereDate('submitted_at', '<=', $request->date_to));
    }

    private function exportHeadings(): array
    {
        return [
            'Kode Aspirasi',
            'Tanggal Masuk',
            'Nama',
            'WhatsApp',
            'Email',
            'Kabupaten/Kota',
            'Kecamatan/Desa',
            'Kategori',
            'Judul',
            'Uraian Aspirasi',
            'Status',
            'Prioritas',
            'Penanggung Jawab',
            'Hasil Verifikasi',
            'Respons Publik',
            'Catatan Internal',
        ];
    }

    private function exportRow(Aspirasi $aspirasi): array
    {
        return [
            $aspirasi->code,
            optional($aspirasi->submitted_at)->format('Y-m-d H:i:s'),
            $aspirasi->name,
            $aspirasi->whatsapp,
            $aspirasi->email,
            $aspirasi->city,
            $aspirasi->district_village,
            $aspirasi->category?->name,
            $aspirasi->title,
            $aspirasi->body,
            $aspirasi->statusLabelText(),
            $aspirasi->priorityLabelText(),
            $aspirasi->assigned_to,
            $aspirasi->verification_result,
            $aspirasi->public_response,
            $aspirasi->internal_note,
        ];
    }
}
