@extends('layouts.admin')

@section('title', 'Dashboard Admin Aspirasi')

@section('content')
<section class="admin-hero">
    <div class="section-kop">Dashboard</div>
    <h1>Management Aspirasi</h1>
    <p style="color:rgba(255,255,255,.65);margin-top:8px">Pantau aspirasi masuk, proses verifikasi, dan tindak lanjut dari satu tempat.</p>
</section>

<section class="admin-grid">
    <div class="admin-card"><p class="muted">Total Aspirasi</p><div class="stat-number">{{ $total }}</div></div>
    <div class="admin-card"><p class="muted">Diterima</p><div class="stat-number">{{ $received }}</div></div>
    <div class="admin-card"><p class="muted">Diproses</p><div class="stat-number">{{ $processing }}</div></div>
    <div class="admin-card"><p class="muted">Selesai</p><div class="stat-number">{{ $completed }}</div></div>
</section>

<section class="admin-card">
    <div style="display:flex;justify-content:space-between;gap:16px;align-items:center;margin-bottom:18px;flex-wrap:wrap">
        <div>
            <div class="section-kop">Terbaru</div>
            <h2 style="font-family:'Playfair Display',serif">Aspirasi Masuk</h2>
        </div>
        <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-merah">Kelola Aspirasi</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pengirim</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($latest as $item)
                    <tr>
                        <td><strong>{{ $item->code }}</strong></td>
                        <td>{{ $item->name }}<br><span class="muted">{{ $item->city }}</span></td>
                        <td>{{ $item->category->name }}</td>
                        <td><span class="badge badge-emas">{{ $item->statusLabelText() }}</span></td>
                        <td>{{ optional($item->submitted_at)->format('d M Y H:i') }}</td>
                        <td><a href="{{ route('admin.aspirasi.show', $item) }}" class="btn btn-outline btn-sm">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;color:var(--teks-ringan)">Belum ada aspirasi masuk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
