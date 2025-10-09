@extends('layouts.app')

@section('title', 'Data IPM - BPS Kota Semarang')
@section('page-title', 'Data IPM')
@section('page-subtitle', 'Indeks Pembangunan Manusia Kota Semarang per tahun')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row mb-3">
    <div class="col-md-4">
        <form method="GET">
            <div class="input-group">
                <label class="input-group-text" for="filter_tahun">Filter Tahun</label>
                <select class="form-select" id="filter_tahun" name="tahun" onchange="this.form.submit()">
                    <option value="">Semua Tahun</option>
                    @for($tahun = 2020; $tahun <= 2024; $tahun++)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endfor
                </select>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-heart me-2"></i>Data IPM Kota Semarang</h5>
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addIPMModal">
                    <i class="fas fa-plus me-2"></i>Tambah Data
                </button>
            </div>

            <div class="card-body bg-light">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Tahun</th>
                                <th>UHH</th>
                                <th>RLS</th>
                                <th>HLS</th>
                                <th>Pengeluaran</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="badge bg-info">{{ $item->tahun }}</span></td>
                                <td>{{ number_format($item->UHH) }}</td>
                                <td>{{ number_format($item->RLS) }}</td>
                                <td>{{ number_format($item->HLS) }}</td>
                                <td>{{ number_format($item->Pengeluaran) }}</td>
                                <td>{{ number_format($item->jumlah) }}</td>
                                <td>
                                    <form action="#" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Tidak ada data tersedia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data IPM -->
<div class="modal fade" id="addIPMModal" tabindex="-1" aria-labelledby="addIPMModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('ipm.data.tahun') }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="addIPMModalLabel">Tambah Data IPM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun</label>
                            <input type="number" class="form-control" name="tahun" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">UHH</label>
                            <input type="text" step="0.01" class="form-control" name="UHH" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">RLS</label>
                            <input type="number" step="0.01" class="form-control" name="RLS" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">HLS</label>
                            <input type="number" step="0.01" class="form-control" name="HLS" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pengeluaran</label>
                            <input type="number" class="form-control" name="Pengeluaran" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
