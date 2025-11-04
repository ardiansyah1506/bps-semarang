@extends('layouts.app')

@section('title', 'Data IPG - BPS Kota Semarang')
@section('page-title', 'Data IPG')
@section('page-subtitle', 'Indeks Pembangunan Gender Kota Semarang per tahun')

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
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addIPGModal">
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
                                <th>UHH Pria</th>
                                <th>UHH Wanita</th>
                                <th>RLS Pria</th>
                                <th>RLS Wanita</th>
                                <th>HLS Pria</th>
                                <th>HLS Wanita</th>
                                <th>Pengeluaran Pria</th>
                                <th>Pengeluaran Wanita</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $index => $item)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td><span class="badge bg-info">{{ $item->tahun }}</span></td>
                                <td>{{ number_format($item->UHH_Pria) }}</td>
                                <td>{{ number_format($item->UHH_Wanita) }}</td>
                                <td>{{ number_format($item->RLS_Pria ?? 0) }}</td>
                                <td>{{ number_format($item->RLS_Wanita ?? 0) }}</td>
                                <td>{{ number_format($item->HLS_Pria, 2) }}</td>
                                <td>{{ number_format($item->HLS_Wanita, 2) }}</td>
                                <td>{{ number_format($item->Pengeluaran_Pria, 2) }}</td>
                                <td>{{ number_format($item->Pengeluaran_Wanita, 2) }}</td>
                                <td>{{ number_format($item->jumlah) }}</td>
                                <td class="d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-warning btn-sm editBtn" data-id="{{ $item->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ Route('ipg.delete', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> </button>
                                        
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
<div class="modal fade" id="addIPGModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('ipg.data.tahun') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Data Tenaga Kerja</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <select class="form-select" id="filter_tahun" name="tahun">
                            <option value="">-- Pilih Tahun --</option>
                            @for($tahun = 2020; $tahun <= 2024; $tahun++)
                                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">UHH Pria</label>
                            <input type="number" class="form-control" name="UHH_Pria" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">UHH Wanita</label>
                            <input type="number" class="form-control" name="UHH_Wanita" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">RLS Pria</label>
                            <input type="number" class="form-control" name="RLS_Pria" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">RLS Wanita</label>
                            <input type="number" class="form-control" name="RLS_Wanita" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">HLS Pria</label>
                            <input type="number" step="0.01" class="form-control" name="HLS_Pria" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">HLS Wanita</label>
                            <input type="number" step="0.01" class="form-control" name="HLS_Wanita" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pengeluaran Pria</label>
                            <input type="number" step="0.01" class="form-control" name="Pengeluaran_Pria" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pengeluaran Wanita</label>
                            <input type="number" step="0.01" class="form-control" name="Pengeluaran_Wanita" required>       

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

<!-- Modal Edit Data -->
<div class="modal fade" id="editIPGModal" tabindex="-1" aria-labelledby="editIPGModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editIPGForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Edit Data IPG</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="number" class="form-control" name="tahun" id="edit_tahun" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">UHH Pria</label>
                            <input type="number" class="form-control" name="UHH_Pria" id="edit_UHH_Pria" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">UHH Wanita</label>
                            <input type="number" class="form-control" name="UHH_Wanita" id="edit_UHH_Wanita" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">RLS Pria</label>
                            <input type="number" class="form-control" name="RLS_Pria" id="edit_RLS_Pria" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">RLS Wanita</label>
                            <input type="number" class="form-control" name="RLS_Wanita" id="edit_RLS_Wanita" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">HLS Pria</label>
                            <input type="number" step="0.01" class="form-control" name="HLS_Pria" id="edit_HLS_Pria" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">HLS Wanita</label>
                            <input type="number" step="0.01" class="form-control" name="HLS_Wanita" id="edit_HLS_Wanita" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pengeluaran Pria</label>
                            <input type="number" class="form-control" name="Pengeluaran_Pria" id="edit_Pengeluaran_Pria" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pengeluaran Wanita</label>
                            <input type="number" class="form-control" name="Pengeluaran_Wanita" id="edit_Pengeluaran_Wanita" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Perbarui Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.editBtn');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');

            fetch(`/ipg/edit/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_tahun').value = data.tahun;
                    document.getElementById('edit_UHH_Pria').value = data.UHH_Pria;
                    document.getElementById('edit_UHH_Wanita').value = data.UHH_Wanita;
                    document.getElementById('edit_RLS_Pria').value = data.RLS_Pria;
                    document.getElementById('edit_RLS_Wanita').value = data.RLS_Wanita;
                    document.getElementById('edit_HLS_Pria').value = data.HLS_Pria;
                    document.getElementById('edit_HLS_Wanita').value = data.HLS_Wanita;
                    document.getElementById('edit_Pengeluaran_Pria').value = data.Pengeluaran_Pria;
                    document.getElementById('edit_Pengeluaran_Wanita').value = data.Pengeluaran_Wanita;

                    const form = document.getElementById('editIPGForm');
                    form.setAttribute('action', `/ipg/update/${data.id}`);

                    const modal = new bootstrap.Modal(document.getElementById('editIPGModal'));
                    modal.show();
                })
                .catch(error => {
                    alert('Gagal memuat data untuk diedit!');
                    console.error(error);
                });
        });
    });
});
</script>
@endpush
