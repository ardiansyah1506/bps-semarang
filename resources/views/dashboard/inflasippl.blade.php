@extends('layouts.app')

@section('title', 'Data Inflasi Perumahan, Air, Listrik dan Bahan Bakar Rumah Tangga - BPS Kota Semarang')
@section('page-title', 'Data Inflasi Perumahan, Air, Listrik dan Bahan Bakar Rumah Tangga')
@section('page-subtitle', 'Inflasi Perumahan, Air, dan Bahan Bakar Rumah Tangga Kota Semarang per tahun dan bulan')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@php
    $bulanList = [
        'Januari', 'Februari', 'Maret',
        'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September',
        'Oktober', 'November', 'Desember'
    ];
@endphp

<div class="row mb-3">
    <div class="col-md-4">
        <form method="GET">
            <div class="input-group mb-2">
                <label class="input-group-text" for="filter_tahun">Filter Tahun</label>
                <select class="form-select" id="filter_tahun" name="tahun" onchange="this.form.submit()">
                    <option value="">Semua Tahun</option>
                    @for($tahun = 2020; $tahun <= 2024; $tahun++)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endfor
                </select>
            </div>
            <div class="input-group">
                <label class="input-group-text" for="filter_bulan">Filter Bulan</label>
                <select class="form-select" id="filter_bulan" name="bulan" onchange="this.form.submit()">
                    <option value="">Semua Bulan</option>
                    @foreach($bulanList as $nama)
                        <option value="{{ $nama }}" {{ request('bulan') == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-briefcase me-2"></i>Data Inflasi Makanan</h5>
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addInflasiPPL">
                    <i class="fas fa-plus me-2"></i>Tambah Data
                </button>
            </div>
            <div class="card-body bg-light">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Bulan</th>
                                <th>IHK</th>
                                <th>Inflasi</th>
                                <th>Andil</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $index => $item)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td><span class="badge bg-info">{{ $item->tahun }}</span></td>
                                <td><span class="badge bg-secondary">{{ $item->bulan ?? '-' }}</span></td>
                                <td>{{ number_format($item->ihk_ppl ?? 0) }}</td>
                                <td>{{ number_format($item->inflasi_ppl ?? 0) }}</td>
                                <td>{{ number_format($item->andil_ppl ?? 0 ) }}</td>
                                <td>{{ number_format($item->jumlah ?? 0) }}
</td>
                                <td>
                                    <form action="#" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada data inflasi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="addInflasiPPL" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('inflasippl.tambah') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Data Inflasi Makanan, Minuman dan Tembakau</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="number" class="form-control" name="tahun" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bulan</label>
                        <select class="form-select" name="bulan" required>
                            @foreach($bulanList as $nama)
                                <option value="{{ $nama }}">{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">IHK</label>
                            <input type="number" class="form-control" name="ihk_ppl" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Inflasi</label>
                            <input type="number" class="form-control" name="inflasi_ppl" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Andil</label>
                            <input type="number" class="form-control" name="andil_ppl" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
