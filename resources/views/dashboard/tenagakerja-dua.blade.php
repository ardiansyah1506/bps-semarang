@extends('layouts.app')

@section('title', 'Data Tenaga Kerja Dua - BPS Kota Semarang')
@section('page-title', 'Data Tenaga Kerja Dua')
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
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addTenagaKerjaDuaModal">
                    <i class="fas fa-plus me-2"></i>Tambah Data
                </button>
            </div>

            <div class="card-body bg-light">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th rowspan="2" class="align-middle">No</th>
                                <th rowspan="2" class="align-middle">Tahun</th>
                                <th colspan="2">Bekerja</th>
                                <th colspan="2">Pengangguran</th>
                                <th colspan="2">Sekolah</th>
                                <th colspan="2">Rumah Tangga</th>
                                <th colspan="2">Lainnya</th>
                                <th rowspan="2" class="align-middle">Jumlah</th>
                                <th rowspan="2" class="align-middle">Aksi</th>
                            </tr>
                            <tr class="table-secondary">
                                <th>L</th>
                                <th>P</th>
                                <th>L</th>
                                <th>P</th>
                                <th>L</th>
                                <th>P</th>
                                <th>L</th>
                                <th>P</th>
                                <th>L</th>
                                <th>P</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><span class="badge bg-info">{{ $item->tahun }}</span></td>

                                    <td>{{ number_format($item->bekerja_pria) }}</td>
                                    <td>{{ number_format($item->bekerja_wanita) }}</td>

                                    <td>{{ number_format($item->pengangguran_pria) }}</td>
                                    <td>{{ number_format($item->pengangguran_wanita) }}</td>

                                    <td>{{ number_format($item->sekolah_pria) }}</td>
                                    <td>{{ number_format($item->sekolah_wanita) }}</td>

                                    <td>{{ number_format($item->rt_pria) }}</td>
                                    <td>{{ number_format($item->rt_wanita) }}</td>

                                    <td>{{ number_format($item->lainnya_pria) }}</td>
                                    <td>{{ number_format($item->lainnya_wanita) }}</td>

                                    <td><span class="fw-bold">{{ number_format($item->jumlah) }}</span></td>

                                    <td class="text-nowrap">
                                        <button type="button"
                                            class="btn btn-warning btn-sm btn-edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editTenagaKerjaDuaModal"
                                            data-update-url="{{ route('penduduk.kerja.updatedua', $item->id) }}"
                                            data-tahun="{{ $item->tahun }}"
                                            data-bekerja-pria="{{ $item->bekerja_pria }}"
                                            data-bekerja-wanita="{{ $item->bekerja_wanita }}"
                                            data-pengangguran-pria="{{ $item->pengangguran_pria }}"
                                            data-pengangguran-wanita="{{ $item->pengangguran_wanita }}"
                                            data-sekolah-pria="{{ $item->sekolah_pria }}"
                                            data-sekolah-wanita="{{ $item->sekolah_wanita }}"
                                            data-rt-pria="{{ $item->rt_pria }}"
                                            data-rt-wanita="{{ $item->rt_wanita }}"
                                            data-lainnya-pria="{{ $item->lainnya_pria }}"
                                            data-lainnya-wanita="{{ $item->lainnya_wanita }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <form action={{ Route('penduduk.kerjadua.hapus', $item->id) }}" method="POST" class="d-inline">
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
                                    <td colspan="14" class="text-center text-muted">Tidak ada data tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Data --}}
<div class="modal fade" id="editTenagaKerjaDuaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="#" method="POST" id="formEditTenagaKerjaDua">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title text-white">Edit Tenaga Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label for="edit_tahun" class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="edit_tahun" name="tahun" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bekerja (L)</label>
                            <input type="number" class="form-control" id="edit_bekerja_pria" name="bekerja_pria" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bekerja (P)</label>
                            <input type="number" class="form-control" id="edit_bekerja_wanita" name="bekerja_wanita" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pengangguran (L)</label>
                            <input type="number" class="form-control" id="edit_pengangguran_pria" name="pengangguran_pria" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pengangguran (P)</label>
                            <input type="number" class="form-control" id="edit_pengangguran_wanita" name="pengangguran_wanita" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sekolah (L)</label>
                            <input type="number" class="form-control" id="edit_sekolah_pria" name="sekolah_pria" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sekolah (P)</label>
                            <input type="number" class="form-control" id="edit_sekolah_wanita" name="sekolah_wanita" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rumah Tangga (L)</label>
                            <input type="number" class="form-control" id="edit_rt_pria" name="rt_pria" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rumah Tangga (P)</label>
                            <input type="number" class="form-control" id="edit_rt_wanita" name="rt_wanita" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lainnya (L)</label>
                            <input type="number" class="form-control" id="edit_lainnya_pria" name="lainnya_pria" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lainnya (P)</label>
                            <input type="number" class="form-control" id="edit_lainnya_wanita" name="lainnya_wanita" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning text-white">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Tambah Data --}}
<div class="modal fade" id="addTenagaKerjaDuaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('penduduk.kerja.tambahdua') }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Tambah Data Tenaga Kerja Dua</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Bekerja (L)</label>
                            <input type="number" class="form-control"  name="bekerja_pria" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Bekerja (P)</label>
                            <input type="number" class="form-control" name="bekerja_wanita" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Pengangguran (L)</label>
                            <input type="number" class="form-control" name="pengangguran_pria" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Pengangguran (P)</label>
                            <input type="number" class="form-control" name="pengangguran_wanita" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Sekolah (L)</label>
                            <input type="number" class="form-control"  name="sekolah_pria" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sekolah (P)</label>
                            <input type="number" class="form-control"  name="sekolah_wanita" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Rumah Tangga (L)</label>
                            <input type="number" class="form-control"  name="rt_pria" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Rumah Tangga (P)</label>
                            <input type="number" class="form-control" name="rt_wanita" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lainnya (L)</label>
                            <input type="number" class="form-control"  name="lainnya_pria" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Lainnya (P)</label>
                            <input type="number" class="form-control"  name="lainnya_wanita" required>
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

{{-- Script untuk isi modal edit + set action --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.btn-edit');
    const editModal = document.getElementById('editTenagaKerjaDuaModal');
    const form = document.getElementById('formEditTenagaKerjaDua');

    editButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            // Set action URL update
            form.action = this.getAttribute('data-update-url');

            // Set field values
            const get = (attr) => this.getAttribute(attr) || '';

            editModal.querySelector('#edit_tahun').value = get('data-tahun');
            editModal.querySelector('#edit_bekerja_pria').value = get('data-bekerja-pria');
            editModal.querySelector('#edit_bekerja_wanita').value = get('data-bekerja-wanita');
            editModal.querySelector('#edit_pengangguran_pria').value = get('data-pengangguran-pria');
            editModal.querySelector('#edit_pengangguran_wanita').value = get('data-pengangguran-wanita');
            editModal.querySelector('#edit_sekolah_pria').value = get('data-sekolah-pria');
            editModal.querySelector('#edit_sekolah_wanita').value = get('data-sekolah-wanita');
            editModal.querySelector('#edit_rt_pria').value = get('data-rt-pria');
            editModal.querySelector('#edit_rt_wanita').value = get('data-rt-wanita');
            editModal.querySelector('#edit_lainnya_pria').value = get('data-lainnya-pria');
            editModal.querySelector('#edit_lainnya_wanita').value = get('data-lainnya-wanita');
        });
    });
});
</script>
@endsection
