@extends('layouts.admin')

@section('title', 'Daftar Aspirasi')

@section('content')
<section class="admin-hero">
    <div class="section-kop">Management</div>
    <h1>Daftar Aspirasi</h1>
    <p style="color:rgba(255,255,255,.65);margin-top:8px">Cari, filter, dan buka detail aspirasi masyarakat.</p>
</section>

<section class="admin-card" style="margin-bottom:24px">
    <form method="GET" action="{{ route('admin.aspirasi.index') }}" class="admin-filters">
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
        <input class="form-control" name="city" value="{{ $filters['city'] ?? '' }}" placeholder="Kota">
        <input class="form-control" type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}">
        <input class="form-control" type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
        <button class="btn btn-merah" type="submit">Filter</button>
    </form>
</section>

<section class="admin-card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>WhatsApp</th>
                    <th>Kota</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Prioritas</th>
                    <th>PIC</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($aspirations as $item)
                    <tr>
                        <td><strong>{{ $item->code }}</strong><br><span class="muted">{{ $item->title }}</span></td>
                        <td>{{ optional($item->submitted_at)->format('d M Y H:i') }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->whatsapp }}</td>
                        <td>{{ $item->city }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td><span class="badge badge-emas">{{ $item->statusLabelText() }}</span></td>
                        <td><span class="badge badge-abu">{{ $item->priorityLabelText() }}</span></td>
                        <td>{{ $item->assigned_to ?: '-' }}</td>
                        <td><a href="{{ route('admin.aspirasi.show', $item) }}" class="btn btn-outline btn-sm">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="10" style="text-align:center;color:var(--teks-ringan)">Data aspirasi tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $aspirations->links() }}</div>
</section>
@endsection
