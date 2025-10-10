@extends('layouts.app')

@section('title', 'Data Tenaga Kerja - BPS Kota Semarang')
@section('page-title', 'Data Tenaga Kerja')
@section('page-subtitle', 'Statistik tenaga kerja Kota Semarang per tahun')

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
                    <option value="">-- Pilih Tahun --</option>
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
                <h5 class="mb-0"><i class="fas fa-briefcase me-2"></i>Data Tenaga Kerja</h5>
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addTenagaKerjaModal">
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
                                <th>Bekerja (L)</th>
                                <th>Bekerja (P)</th>
                                <th>Pengangguran (L)</th>
                                <th>Pengangguran (P)</th>
                                <th>TPAK (%)</th>
                                <th>TPT (%)</th>
                                <th>TKK (%)</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $index => $item)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td><span class="badge bg-info">{{ $item->tahun }}</span></td>
                                <td>{{ number_format($item->bekerja_laki_laki) }}</td>
                                <td>{{ number_format($item->bekerja_perempuan) }}</td>
                                <td>{{ number_format($item->pengangguran_laki_laki ?? 0) }}</td>
                                <td>{{ number_format($item->pengangguran_perempuan ?? 0) }}</td>
                                <td>{{ number_format($item->tpak, 2) }}</td>
                                <td>{{ number_format($item->tpt, 2) }}</td>
                                <td>{{ number_format($item->tkk, 2) }}</td>
                                <td>{{ number_format($item->jumlah) }}</td>
                                <td>
                                    <form action="{{ route('penduduk.kerja.hapus', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">Tidak ada data tenaga kerja</td>
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
<!-- Modal Tambah Data -->
<div class="modal fade" id="addTenagaKerjaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('penduduk.kerja.tambah') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Data Tenaga Kerja</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="number" class="form-control" name="tahun" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bekerja Laki-Laki</label>
                            <input type="number" class="form-control" name="bekerja_laki_laki" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bekerja Perempuan</label>
                            <input type="number" class="form-control" name="bekerja_perempuan" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pengangguran Laki-Laki</label>
                            <input type="number" class="form-control" name="pengangguran_laki_laki" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pengangguran Perempuan</label>
                            <input type="number" class="form-control" name="pengangguran_perempuan" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">TPAK (%)</label>
                            <input type="number" step="0.01" class="form-control" name="tpak" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">TPT (%)</label>
                            <input type="number" step="0.01" class="form-control" name="tpt" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">TKK (%)</label>
                            <input type="number" step="0.01" class="form-control" name="tkk" required>
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
