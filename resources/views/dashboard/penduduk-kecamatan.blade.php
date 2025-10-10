@extends('layouts.app')

@section('title', 'Data Penduduk per Kecamatan - BPS Kota Semarang')
@section('page-title', 'Data Penduduk per Kecamatan')
@section('page-subtitle', 'Statistik penduduk Kota Semarang per kecamatan')

@section('content')
<div class="fade-in-up">
<!-- Alert Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filter Tahun dan Kecamatan -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Tahun dan Kecamatan</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('penduduk.kecamatan.index') }}" class="row align-items-end">
                    <div class="col-md-3">
                        <label for="tahun" class="form-label">Pilih Tahun</label>
                        <select name="tahun" id="tahun" class="form-select">
                            <option value="">-- Pilih Tahun --</option>
                            @foreach($tahunList as $tahunOption)
                            <option value="{{ $tahunOption }}" {{ $tahun == $tahunOption ? 'selected' : '' }}>
                                    {{ $tahunOption }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"></label>
                        <div class="row">
                            @php
                                $kecamatanList = [
                                   
                                ];
                                $filterKecamatan = request()->get('kecamatan', []);
                            @endphp
                            @foreach($kecamatanList as $kecamatanValue => $kecamatanLabel)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kecamatan[]" 
                                               value="{{ $kecamatanValue }}" id="kecamatan_{{ $loop->index }}"
                                               {{ in_array($kecamatanValue, $filterKecamatan) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kecamatan_{{ $loop->index }}">
                                            {{ $kecamatanLabel }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter me-2"></i>Filter Data
                        </button>
                        <a href="{{ route('penduduk.kecamatan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-refresh me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Active Filter Info -->
@if(count($filterKecamatan) > 0)
    <div class="alert alert-info mb-3">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Filter Aktif:</strong> 
        Tahun {{ $tahun }} | 
        Kecamatan: {{ implode(', ', $filterKecamatan) }}
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Data Penduduk per Kecamatan - Tahun {{ $tahun }}</h5>
                <div>
                    <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modalTambahData">
                        <i class="fas fa-plus me-2"></i>Tambah Data
                    </button>
                    <a href="{{ route('penduduk') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Kecamatan</th>
                                <th>Laki-laki</th>
                                <th>Perempuan</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($dataKecamatan) > 0)
                                @foreach($dataKecamatan as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $item['kecamatan'] }}</strong></td>
                                    <td>{{ number_format($item['laki_laki']) }}</td>
                                    <td>{{ number_format($item['perempuan']) }}</td>
                                    <td><strong>{{ number_format($item['total']) }}</strong></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm me-1" 
                                                data-bs-toggle="modal" data-bs-target="#modalEditData{{ $item['id'] }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" 
                                                data-bs-toggle="modal" data-bs-target="#modalHapusData{{ $item['id'] }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Belum ada data kecamatan untuk tahun {{ $tahun }}. 
                                        Silakan tambah data menggunakan tombol "Tambah Data" di atas.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot class="table-dark">
                            @if(count($dataKecamatan) > 0)
                                <tr>
                                    <td colspan="2"><strong>TOTAL</strong></td>
                                    <td><strong>{{ number_format(collect($dataKecamatan)->sum('laki_laki')) }}</strong></td>
                                    <td><strong>{{ number_format(collect($dataKecamatan)->sum('perempuan')) }}</strong></td>
                                    <td><strong>{{ number_format(collect($dataKecamatan)->sum('total')) }}</strong></td>
                                    <td></td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <strong>Tidak ada data untuk ditampilkan</strong>
                                    </td>
                                </tr>
                            @endif
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Distribusi Penduduk per Kecamatan - Tahun {{ $tahun }}</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="kecamatanChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Perbandingan Gender per Kecamatan - Tahun {{ $tahun }}</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="genderKecamatanChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Ranking Kecamatan - Tahun {{ $tahun }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <h6 class="text-primary">Kecamatan Terpadat</h6>
                            @if(count($dataKecamatan) > 0)
                                @php
                                    $terpadat = collect($dataKecamatan)->sortByDesc('total')->first();
                                @endphp
                                <h4 class="text-primary">{{ $terpadat['kecamatan'] }}</h4>
                                <small class="text-muted">{{ number_format($terpadat['total']) }} penduduk</small>
                            @else
                                <h4 class="text-primary">-</h4>
                                <small class="text-muted">Tidak ada data</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <h6 class="text-success">Kecamatan Terendah</h6>
                            @if(count($dataKecamatan) > 0)
                                @php
                                    $terendah = collect($dataKecamatan)->sortBy('total')->first();
                                @endphp
                                <h4 class="text-success">{{ $terendah['kecamatan'] }}</h4>
                                <small class="text-muted">{{ number_format($terendah['total']) }} penduduk</small>
                            @else
                                <h4 class="text-success">-</h4>
                                <small class="text-muted">Tidak ada data</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <h6 class="text-info">Rata-rata per Kecamatan</h6>
                            @if(count($dataKecamatan) > 0)
                                <h4 class="text-info">{{ number_format(collect($dataKecamatan)->avg('total')) }}</h4>
                                <small class="text-muted">penduduk per kecamatan</small>
                            @else
                                <h4 class="text-info">-</h4>
                                <small class="text-muted">Tidak ada data</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="modalTambahData" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Tambah Data Kecamatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('penduduk.kecamatan.tambah') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kecamatan" class="form-label">Nama Kecamatan</label>
                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="laki_laki" class="form-label">Jumlah Laki-laki</label>
                        <input type="number" class="form-control" id="laki_laki" name="laki_laki" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="perempuan" class="form-label">Jumlah Perempuan</label>
                        <input type="number" class="form-control" id="perempuan" name="perempuan" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <select class="form-select" id="tahun" name="tahun" required>
                            @foreach($tahunList as $tahunOption)
                                <option value="{{ $tahunOption }}" {{ $tahun == $tahunOption ? 'selected' : '' }}>
                                    {{ $tahunOption }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
@if(count($dataKecamatan) > 0)
    @foreach($dataKecamatan as $item)
    <div class="modal fade" id="modalEditData{{ $item['id'] }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Data Kecamatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('penduduk.kecamatan.edit', $item['id']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kecamatan{{ $item['id'] }}" class="form-label">Nama Kecamatan</label>
                            <input type="text" class="form-control" id="kecamatan{{ $item['id'] }}" name="kecamatan" value="{{ $item['kecamatan'] }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="laki_laki{{ $item['id'] }}" class="form-label">Jumlah Laki-laki</label>
                            <input type="number" class="form-control" id="laki_laki{{ $item['id'] }}" name="laki_laki" value="{{ $item['laki_laki'] }}" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="perempuan{{ $item['id'] }}" class="form-label">Jumlah Perempuan</label>
                            <input type="number" class="form-control" id="perempuan{{ $item['id'] }}" name="perempuan" value="{{ $item['perempuan'] }}" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="tahun{{ $item['id'] }}" class="form-label">Tahun</label>
                            <select class="form-select" id="tahun{{ $item['id'] }}" name="tahun" required>
                                @foreach($tahunList as $tahunOption)
                                    <option value="{{ $tahunOption }}" {{ $tahun == $tahunOption ? 'selected' : '' }}>
                                        {{ $tahunOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Data -->
    <div class="modal fade" id="modalHapusData{{ $item['id'] }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-trash me-2"></i>Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data kecamatan <strong>{{ $item['kecamatan'] }}</strong>?</p>
                    <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('penduduk.kecamatan.hapus', $item['id']) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Data untuk grafik
const dataKecamatan = @json($dataKecamatan);
const labels = dataKecamatan.length > 0 ? dataKecamatan.map(item => item.kecamatan) : [];
const totals = dataKecamatan.length > 0 ? dataKecamatan.map(item => item.total) : [];
const lakiLaki = dataKecamatan.length > 0 ? dataKecamatan.map(item => item.laki_laki) : [];
const perempuan = dataKecamatan.length > 0 ? dataKecamatan.map(item => item.perempuan) : [];

// Grafik distribusi kecamatan
const kecamatanCtx = document.getElementById('kecamatanChart').getContext('2d');
const kecamatanChart = new Chart(kecamatanCtx, {
    type: 'doughnut',
    data: {
        labels: labels,
        datasets: [{
            data: totals,
            backgroundColor: [
                '#667eea', '#764ba2', '#f093fb', '#f5576c', '#4facfe',
                '#43e97b', '#38f9d7', '#fa709a', '#fee140', '#ff9a9e',
                '#a8edea', '#fed6e3', '#ffecd2', '#ff9a9e', '#fecfef',
                '#fecfef'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Grafik perbandingan gender per kecamatan
const genderKecamatanCtx = document.getElementById('genderKecamatanChart').getContext('2d');
const genderKecamatanChart = new Chart(genderKecamatanCtx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Laki-laki',
            data: lakiLaki,
            backgroundColor: '#667eea'
        }, {
            label: 'Perempuan',
            data: perempuan,
            backgroundColor: '#f093fb'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Auto-submit form when tahun changes
document.getElementById('tahun').addEventListener('change', function() {
    this.form.submit();
});
</script>
@endpush 