@extends('layouts.admin')

@section('title', 'Detail Aspirasi '.$aspirasi->code)

@section('content')
<section class="admin-hero">
    <div class="section-kop">Detail Aspirasi</div>
    <h1>{{ $aspirasi->code }}</h1>
    <p style="color:rgba(255,255,255,.65);margin-top:8px">{{ $aspirasi->title }}</p>
    <div class="admin-actions admin-no-print" style="margin-top:20px">
        <button type="button" class="btn btn-light" onclick="window.print()">Cetak Detail</button>
        <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-outline">Kembali</a>
    </div>
</section>

@if (session('status'))
    <div class="alert alert-sukses">{{ session('status') }}</div>
@endif

<div class="detail-grid">
    <section class="admin-card">
        <div class="section-kop">Data Aspirasi</div>
        <h2 style="font-family:'Playfair Display',serif;margin-bottom:20px">{{ $aspirasi->title }}</h2>
        <div class="grid-2">
            <div class="kv"><span>Nama</span><strong>{{ $aspirasi->name }}</strong></div>
            <div class="kv"><span>WhatsApp</span><strong>{{ $aspirasi->whatsapp }}</strong></div>
            <div class="kv"><span>Email</span><strong>{{ $aspirasi->email ?: '-' }}</strong></div>
            <div class="kv"><span>NIK</span><strong>{{ $aspirasi->nik ?: '-' }}</strong></div>
            <div class="kv"><span>Kota</span><strong>{{ $aspirasi->city }}</strong></div>
            <div class="kv"><span>Kecamatan / Desa</span><strong>{{ $aspirasi->district_village ?: '-' }}</strong></div>
            <div class="kv"><span>Kategori</span><strong>{{ $aspirasi->category->name }}</strong></div>
            <div class="kv"><span>Status</span><strong>{{ $aspirasi->statusLabelText() }}</strong></div>
            <div class="kv"><span>Prioritas</span><strong>{{ $aspirasi->priorityLabelText() }}</strong></div>
            <div class="kv"><span>Penanggung Jawab</span><strong>{{ $aspirasi->assigned_to ?: '-' }}</strong></div>
        </div>
        <div class="kv" style="margin-top:10px">
            <span>Uraian Aspirasi</span>
            <p style="white-space:pre-line;line-height:1.8">{{ $aspirasi->body }}</p>
        </div>

        <div class="section-kop" style="margin-top:28px">Hasil Verifikasi</div>
        <div class="admin-note-box">
            @if ($aspirasi->verification_result)
                <p>{{ $aspirasi->verification_result }}</p>
            @else
                <p class="muted">Belum ada hasil verifikasi data.</p>
            @endif
        </div>

        <div class="section-kop" style="margin-top:28px">Dokumen Pendukung</div>
        @forelse ($aspirasi->attachments as $attachment)
            <a class="btn btn-outline btn-sm" href="{{ route('admin.aspirasi.attachments.download', [$aspirasi, $attachment]) }}" style="margin:0 8px 8px 0">
                {{ $attachment->original_name }}
            </a>
        @empty
            <p class="muted">Tidak ada dokumen pendukung.</p>
        @endforelse

        <div class="section-kop" style="margin-top:28px">Riwayat Tindak Lanjut</div>
        <div class="timeline">
            @forelse ($aspirasi->histories as $history)
                <div class="timeline-item done">
                    <div class="timeline-dot">-</div>
                    <div>
                        <strong>{{ \App\Models\Aspirasi::statusLabel($history->to_status) }}</strong>
                        <p class="muted">{{ optional($history->created_at)->format('d M Y H:i') }}{{ $history->admin ? ' - '.$history->admin->name : '' }}</p>
                        @if ($history->note)
                            <p class="muted">{{ $history->note }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="muted">Belum ada riwayat.</p>
            @endforelse
        </div>
    </section>

    <aside class="admin-card admin-no-print">
        <div class="section-kop">Update Penanganan</div>
        <h2 style="font-family:'Playfair Display',serif;margin-bottom:18px">Status Admin</h2>
        <form method="POST" action="{{ route('admin.aspirasi.update', $aspirasi) }}">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control" required>
                    @foreach ($statuses as $key => $meta)
                        <option value="{{ $key }}" @selected(old('status', $aspirasi->status) === $key)>{{ $meta['label'] }}</option>
                    @endforeach
                </select>
                @error('status') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="priority">Prioritas Aspirasi</label>
                <select id="priority" name="priority" class="form-control" required>
                    @foreach ($priorities as $key => $label)
                        <option value="{{ $key }}" @selected(old('priority', $aspirasi->priority ?? \App\Models\Aspirasi::PRIORITY_NORMAL) === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('priority') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) old('category_id', $aspirasi->category_id) === (string) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="assigned_to">Penanggung Jawab</label>
                <input id="assigned_to" name="assigned_to" class="form-control" value="{{ old('assigned_to', $aspirasi->assigned_to) }}" placeholder="Contoh: Admin, TA, atau nama penanggung jawab">
                @error('assigned_to') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="verification_result">Hasil Verifikasi</label>
                <textarea id="verification_result" name="verification_result" class="form-control" placeholder="Ringkas hasil cek kelengkapan data, kategori, dan validitas aspirasi.">{{ old('verification_result', $aspirasi->verification_result) }}</textarea>
                @error('verification_result') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="history_note">Catatan Tindak Lanjut Baru</label>
                <textarea id="history_note" name="history_note" class="form-control">{{ old('history_note') }}</textarea>
                @error('history_note') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="public_response">Respons Publik</label>
                <textarea id="public_response" name="public_response" class="form-control">{{ old('public_response', $aspirasi->public_response) }}</textarea>
                @error('public_response') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="internal_note">Catatan Internal</label>
                <textarea id="internal_note" name="internal_note" class="form-control">{{ old('internal_note', $aspirasi->internal_note) }}</textarea>
                @error('internal_note') <span class="error">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn btn-merah" style="width:100%">Simpan Perubahan</button>
        </form>
        <button type="button" class="btn btn-outline" onclick="window.print()" style="width:100%;margin-top:12px">Cetak Detail</button>
        <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-outline" style="width:100%;margin-top:12px">Kembali</a>
    </aside>
</div>
@endsection
