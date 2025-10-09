@extends('layouts.app')

@section('title', 'Data Gini Rasio - BPS Kota Semarang')
@section('page-title', 'Data Gini Rasio')
@section('page-subtitle', 'Statistik ketimpangan pendapatan Kota Semarang per kecamatan')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
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
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Data Kemiskinan dan Gini Rasio Kota Semarang</h5>
                <div>
                    <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#importGiniRasioModal">
                        <i class="fas fa-file-import me-2"></i>Import Excel/CSV
                    </button>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addGiniRasioModal">
                        <i class="fas fa-plus me-2"></i>Tambah Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Jumlah Penduduk Miskin</th>
                                <th>Penduduk Miskin (%)</th>
                                <th>Garis Kemiskinan</th>
                                <th>Gini Rasio</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->tahun }}</td>
                                <td>{{ number_format($item->penduduk_miskin) }}</td>
                                <td>{{ number_format($item->penduduk_miskin_persen, 2) }}%</td>
                                <td>Rp {{ number_format($item->garis_kemiskinan) }}</td>
                                <td>{{ number_format($item->gini_rasio, 3) }}</td>
                                <td>{{ number_format($item->jumlah) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('ginirasio.hapus', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data gini rasio</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Gini Rasio -->
<div class="modal fade" id="addGiniRasioModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('ginirasio.mis.tambah') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Data Gini Rasio dan Kemiskinan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="number" class="form-control" name="tahun" id="tahun" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Penduduk Miskin</label>
                        <input type="number" class="form-control" name="penduduk_miskin" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penduduk Miskin Dalam Persen</label>
                        <input type="number" step="0.01" class="form-control" name="penduduk_miskin_persen" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Garis Kemiskinan</label>
                        <input type="number" class="form-control" name="garis_kemiskinan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gini Rasio</label>
                        <input type="number" step="0.001" class="form-control" name="gini_rasio" required>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import Excel/CSV -->
<div class="modal fade" id="importGiniRasioModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('gini-rasio.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Import Data Gini Rasio dari Excel/CSV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label class="form-label">Pilih File Excel/CSV</label>
                        <input type="file" class="form-control" name="file" accept=".xlsx,.xls,.csv" required>
                        <div class="form-text">Format kolom: tahun, penduduk_miskin, penduduk_miskin_persen, garis_kemiskinan, gini_rasio</div>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
