@extends('layouts.app')

@section('title', 'Data Penduduk Berdasarkan Umur - BPS Kota Semarang')
@section('page-title', 'Data Penduduk Berdasarkan Umur')
@section('page-subtitle', 'Statistik penduduk Kota Semarang berdasarkan kelompok umur')

@section('content')
<!-- Filter Tahun dan Umur -->
<div class="fade-in-up">
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('penduduk.umur') }}" class="row align-items-end">
                    <div class="col-md-3">
                        <label for="tahun" class="form-label">Pilih Tahun</label>
                        <select name="tahun" id="tahun" class="form-select">
                            @foreach($tahunList as $tahunOption)
                                <option value="{{ $tahunOption }}" {{ $tahun == $tahunOption ? 'selected' : '' }}>
                                    {{ $tahunOption }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                  
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter me-2"></i>Filter Data
                        </button>
                        <a href="{{ route('penduduk.umur') }}" class="btn btn-secondary">
                            <i class="fas fa-refresh me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-birthday-cake me-2"></i>Data Penduduk Berdasarkan Umur - Tahun {{ $tahun }}</h5>
                <div>
                   
                    <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modalTambahData">
                        <i class="fas fa-plus me-2"></i>Tambah Data
                    </button>
                    <!-- Modal Import Excel -->
<form action="{{ route('penduduk.umur.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-3">
            
        </div>
        <div class="col-md-5">
            <input type="file" name="file" class="form-control" accept=".xls,.xlsx" required>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Import</button>
        </div>
    </div>
</form>

           
    </div>
</div>

                    <a href="{{ route('penduduk') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(count($filterUmur) > 0)
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Filter Aktif:</strong> 
                        Tahun {{ $tahun }} | 
                        Umur: {{ implode(', ', $filterUmur) }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Kelompok Umur</th>
                                <th>Laki-laki</th>
                                <th>Perempuan</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($dataUmur) > 0)
                                @foreach($dataUmur as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $item['umur'] }}</strong></td>
                                    <td>{{ number_format($item['laki_laki']) }}</td>
                                    <td>{{ number_format($item['perempuan']) }}</td>
                                    <td><strong>{{ number_format($item['jumlah']) }}</strong></td>
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
                                        Belum ada data umur untuk tahun {{ $tahun }}. 
                                        Silakan tambah data menggunakan tombol "Tambah Data" di atas.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot class="table-dark">
                            @if(count($dataUmur) > 0)
                                <tr>
                                    <td colspan="2"><strong>TOTAL</strong></td>
                                    <td><strong>{{ number_format(collect($dataUmur)->sum('laki_laki')) }}</strong></td>
                                    <td><strong>{{ number_format(collect($dataUmur)->sum('perempuan')) }}</strong></td>
                                    <td><strong>{{ number_format(collect($dataUmur)->sum('total')) }}</strong></td>
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
                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Distribusi Penduduk Berdasarkan Umur - Tahun {{ $tahun }}</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="umurChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Perbandingan Gender per Kelompok Umur - Tahun {{ $tahun }}</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="genderUmurChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Analisis Piramida Penduduk - Tahun {{ $tahun }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <h6 class="text-primary">Kelompok Muda (0-14 tahun)</h6>
                            <h4 class="text-primary">{{ number_format(collect($dataUmur)->whereIn('umur', ['0-4 tahun', '5-9 tahun', '10-14 tahun'])->sum('jumlah')) }}</h4>
                            <small class="text-muted">Penduduk usia produktif muda</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <h6 class="text-success">Kelompok Produktif (15-64 tahun)</h6>
                            <h4 class="text-success">{{ number_format(collect($dataUmur)->whereNotIn('umur', ['0-4 tahun', '5-9 tahun', '10-14 tahun', '65+ tahun'])->sum('jumlah')) }}</h4>
                            <small class="text-muted">Penduduk usia produktif</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <h6 class="text-warning">Kelompok Lansia (65+ tahun)</h6>
                            <h4 class="text-warning">{{ number_format(collect($dataUmur)->where('umur', '65+ tahun')->sum('jumlah')) }}</h4>
                            <small class="text-muted">Penduduk usia lanjut</small>
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
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Tambah Data Umur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('penduduk.umur.tambah') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="tahun" value="{{ $tahun }}">
                    <div class="mb-3">
                        <label for="umur" class="form-label">Kelompok Umur</label>
                        <select name="umur" id="umur" class="form-select" required>
                            <option value="">Pilih Kelompok Umur</option>
                            @foreach($umurList as $umurValue => $umurLabel)
                                <option value="{{ $umurValue }}">{{ $umurLabel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="laki_laki" class="form-label">Jumlah Laki-laki</label>
                        <input type="number" class="form-control" id="laki_laki" name="laki_laki" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="perempuan" class="form-label">Jumlah Perempuan</label>
                        <input type="number" class="form-control" id="perempuan" name="perempuan" min="0" required>
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
@if(count($dataUmur) > 0)
    @foreach($dataUmur as $item)
    <div class="modal fade" id="modalEditData{{ $item['id'] }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Data Umur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('penduduk.umur.edit', $item['id']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="umur{{ $item['id'] }}" class="form-label">Kelompok Umur</label>
                            <select class="form-select" id="umur{{ $item['id'] }}" name="umur" required>
                                @foreach($umurList as $key => $value)
                                    <option value="{{ $key }}" {{ $item['umur'] == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
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
                    <p>Apakah Anda yakin ingin menghapus data umur <strong>{{ $item['umur'] }}</strong>?</p>
                    <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('penduduk.umur.hapus', $item['id']) }}" method="POST" class="d-inline">
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
const dataUmur = @json($dataUmur);
const labels = dataUmur.map(item => item.umur);
const totals = dataUmur.map(item => item.total);
const lakiLaki = dataUmur.map(item => item.laki_laki);
const perempuan = dataUmur.map(item => item.perempuan);

// Grafik distribusi umur
const umurCtx = document.getElementById('umurChart').getContext('2d');
const umurChart = new Chart(umurCtx, {
    type: 'doughnut',
    data: {
        labels: labels,
        datasets: [{
            data: totals,
            backgroundColor: [
                '#667eea', '#764ba2', '#f093fb', '#f5576c', '#4facfe',
                '#43e97b', '#38f9d7', '#fa709a', '#fee140', '#ff9a9e',
                '#a8edea', '#fed6e3', '#ffecd2'
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

// Grafik perbandingan gender per umur
const genderUmurCtx = document.getElementById('genderUmurChart').getContext('2d');
const genderUmurChart = new Chart(genderUmurCtx, {
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
</script>
@endpush 