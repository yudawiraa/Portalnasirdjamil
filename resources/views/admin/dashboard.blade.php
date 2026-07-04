@extends('layouts.admin')

@section('title', 'Dashboard Admin Aspirasi')

@section('content')
@php
    $cleanFilters = array_filter($filters, fn ($value) => filled($value));
    $maxStatus = max(1, $statusStats->max('total') ?? 0);
    $maxCategory = max(1, $categoryStats->max('total') ?? 0);
    $maxCity = max(1, $cityStats->max('total') ?? 0);
    $maxMonthly = max(1, $monthlyStats->max('total') ?? 0);
@endphp

<section class="admin-hero">
    <div class="section-kop">Dashboard</div>
    <h1>Management Aspirasi</h1>
    <p style="color:rgba(255,255,255,.65);margin-top:8px">Pantau kode aspirasi, verifikasi, tindak lanjut, dan laporan statistik dari satu tempat.</p>
</section>

<section class="admin-card admin-report-card">
    <div class="admin-report-head">
        <div>
            <div class="section-kop">Filter Laporan</div>
            <h2>Laporan Aspirasi</h2>
            <p class="muted">Filter ini memengaruhi angka ringkas, grafik, rekap bulanan, dan data export.</p>
        </div>
        <div class="admin-report-actions">
            <a href="{{ route('admin.aspirasi.export', array_merge(['format' => 'csv'], $cleanFilters)) }}" class="btn btn-outline">Export CSV</a>
            <a href="{{ route('admin.aspirasi.export', array_merge(['format' => 'xls'], $cleanFilters)) }}" class="btn btn-merah">Export Excel</a>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.dashboard') }}" class="admin-filters admin-dashboard-filters">
        <input class="form-control" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari kode, nama, WhatsApp, judul, kota">
        <select class="form-control" name="status">
            <option value="">Semua Status</option>
            @foreach ($statuses as $key => $meta)
                <option value="{{ $key }}" @selected(($filters['status'] ?? '') === $key)>{{ $meta['label'] }}</option>
            @endforeach
        </select>
        <select class="form-control" name="priority">
            <option value="">Semua Prioritas</option>
            @foreach ($priorities as $key => $label)
                <option value="{{ $key }}" @selected(($filters['priority'] ?? '') === $key)>{{ $label }}</option>
            @endforeach
        </select>
        <select class="form-control" name="category_id">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) ($filters['category_id'] ?? '') === (string) $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        <input class="form-control" name="city" value="{{ $filters['city'] ?? '' }}" placeholder="Wilayah/Kota">
        <input class="form-control" type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}">
        <input class="form-control" type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
        <button class="btn btn-merah" type="submit">Terapkan</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Reset</a>
    </form>
</section>

<section class="admin-grid">
    <div class="admin-card"><p class="muted">Total Database</p><div class="stat-number">{{ $total }}</div></div>
    <div class="admin-card"><p class="muted">Sesuai Filter</p><div class="stat-number">{{ $filteredTotal }}</div></div>
    <div class="admin-card"><p class="muted">Diterima</p><div class="stat-number">{{ $received }}</div></div>
    <div class="admin-card"><p class="muted">Diproses</p><div class="stat-number">{{ $processing }}</div></div>
    <div class="admin-card"><p class="muted">Selesai</p><div class="stat-number">{{ $completed }}</div></div>
    <div class="admin-card"><p class="muted">Perlu Perhatian</p><div class="stat-number">{{ $needsAttention }}</div></div>
</section>

<section class="admin-card">
    <div class="admin-report-head">
        <div>
            <div class="section-kop">Analitik Aspirasi</div>
            <h2>Grafik & Statistik</h2>
            <p class="muted">Ringkasan aspirasi berdasarkan status, kategori, wilayah, dan periode.</p>
        </div>
        <a href="{{ route('admin.aspirasi.index', $cleanFilters) }}" class="btn btn-outline">Lihat Data Detail</a>
    </div>

    <div class="analytics-grid">
        <div class="analytics-panel">
            <h3>Status Aspirasi</h3>
            <div class="chart-list">
                @foreach ($statusStats as $row)
                    <div class="chart-row">
                        <span>{{ $row['label'] }}</span>
                        <div class="chart-track"><i style="width:{{ ($row['total'] / $maxStatus) * 100 }}%"></i></div>
                        <strong>{{ $row['total'] }}</strong>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="analytics-panel">
            <h3>Kategori Aspirasi</h3>
            <div class="chart-list">
                @forelse ($categoryStats as $row)
                    <div class="chart-row">
                        <span>{{ $row['label'] }}</span>
                        <div class="chart-track"><i style="width:{{ ($row['total'] / $maxCategory) * 100 }}%"></i></div>
                        <strong>{{ $row['total'] }}</strong>
                    </div>
                @empty
                    <p class="muted">Belum ada data kategori pada filter ini.</p>
                @endforelse
            </div>
        </div>

        <div class="analytics-panel">
            <h3>Wilayah Pengirim</h3>
            <div class="chart-list">
                @forelse ($cityStats as $row)
                    <div class="chart-row">
                        <span>{{ $row['label'] }}</span>
                        <div class="chart-track"><i style="width:{{ ($row['total'] / $maxCity) * 100 }}%"></i></div>
                        <strong>{{ $row['total'] }}</strong>
                    </div>
                @empty
                    <p class="muted">Belum ada data wilayah pada filter ini.</p>
                @endforelse
            </div>
        </div>

        <div class="analytics-panel">
            <h3>Rekap Bulanan</h3>
            <div class="chart-list">
                @forelse ($monthlyStats as $row)
                    <div class="chart-row">
                        <span>{{ $row['label'] }}</span>
                        <div class="chart-track"><i style="width:{{ ($row['total'] / $maxMonthly) * 100 }}%"></i></div>
                        <strong>{{ $row['total'] }}</strong>
                    </div>
                @empty
                    <p class="muted">Belum ada data periode pada filter ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

<section class="admin-card">
    <div style="display:flex;justify-content:space-between;gap:16px;align-items:center;margin-bottom:18px;flex-wrap:wrap">
        <div>
            <div class="section-kop">Kode Aspirasi</div>
            <h2 style="font-family:'Playfair Display',serif">Aspirasi Masuk Terbaru</h2>
            <p class="muted">Kode ditampilkan agar admin bisa membantu masyarakat yang lupa kode aspirasi.</p>
        </div>
        <a href="{{ route('admin.aspirasi.index', $cleanFilters) }}" class="btn btn-merah">Kelola Aspirasi</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pengirim</th>
                    <th>WhatsApp</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($latest as $item)
                    <tr>
                        <td><strong class="code-chip">{{ $item->code }}</strong><br><span class="muted">{{ $item->title }}</span></td>
                        <td>{{ $item->name }}<br><span class="muted">{{ $item->city }}</span></td>
                        <td>{{ $item->whatsapp }}</td>
                        <td>{{ $item->category?->name ?: '-' }}</td>
                        <td><span class="badge badge-emas">{{ $item->statusLabelText() }}</span></td>
                        <td>{{ optional($item->submitted_at)->format('d M Y H:i') }}</td>
                        <td><a href="{{ route('admin.aspirasi.show', $item) }}" class="btn btn-outline btn-sm">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center;color:var(--teks-ringan)">Belum ada aspirasi masuk pada filter ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
