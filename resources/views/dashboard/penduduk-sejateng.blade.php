@extends('layouts.app')

@section('title', 'Data Penduduk Jawa Tengah - BPS Kota Semarang')
@section('page-title', 'Data Penduduk Jawa Tengah')
@section('page-subtitle', 'Statistik penduduk kota/kabupaten di Jawa Tengah')

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

<!-- Filter Tahun dan Kota/Kabupaten -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Tahun dan Kota/Kabupaten</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('penduduk.sejateng') }}" class="row align-items-end">
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
                    <div class="col-md-6">
                        <label class="form-label"></label>
                        <div class="row">
                            @php
                                $kotaList = [
                                    
                                ];
                                $filterKota = request()->get('provinsi', []);
                            @endphp
                            @foreach($kotaList as $kotaValue => $kotaLabel)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="provinsi[]" 
                                               value="{{ $kotaValue }}" id="kota_{{ $loop->index }}"
                                               {{ in_array($kotaValue, $filterKota) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kota_{{ $loop->index }}">
                                            {{ $kotaLabel }}
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
                        <a href="{{ route('penduduk.sejateng') }}" class="btn btn-secondary">
                            <i class="fas fa-refresh me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Active Filter Info -->
@if(count($filterKota) > 0)
    <div class="alert alert-info mb-3">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Filter Aktif:</strong> 
        Tahun {{ $tahun }} | 
        Kota/Kabupaten: {{ implode(', ', $filterKota) }}
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-map me-2"></i>Data Penduduk Jawa Tengah - Tahun {{ $tahun }}</h5>
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
                                <th>Kota/Kabupaten</th>
                                <th>Laki-laki</th>
                                <th>Perempuan</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($dataSejateng) > 0)
                                @foreach($dataSejateng as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $item['provinsi'] }}</strong></td>
                                    <td>{{ number_format($item['pria']) }}</td>
                                    <td>{{ number_format($item['wanita']) }}</td>
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
                                        Belum ada data kota/kabupaten untuk tahun {{ $tahun }}. 
                                        Silakan tambah data menggunakan tombol "Tambah Data" di atas.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot class="table-dark">
                            @if(count($dataSejateng) > 0)
                                <tr>
                                    <td colspan="2"><strong>TOTAL</strong></td>
                                    <td><strong>{{ number_format(collect($dataSejateng)->sum('pria')) }}</strong></td>
                                    <td><strong>{{ number_format(collect($dataSejateng)->sum('wanita')) }}</strong></td>
                                    <td><strong>{{ number_format(collect($dataSejateng)->sum('total')) }}</strong></td>
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

@if(count($dataSejateng) > 0)
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Distribusi Penduduk Jawa Tengah - Tahun {{ $tahun }}</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="sejatengChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Perbandingan Gender Jawa Tengah - Tahun {{ $tahun }}</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="genderSejatengChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row mt-4">
    <div class="col-12">
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Tidak ada data untuk ditampilkan dalam grafik.</strong><br>
            Silakan tambah data menggunakan tombol "Tambah Data" di atas.
        </div>
    </div>
</div>
@endif

@if(count($dataSejateng) > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Ranking Jawa Tengah - Tahun {{ $tahun }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <h6 class="text-primary">Kota/Kabupaten Terpadat</h6>
                            @php $terpadat = collect($dataSejateng)->sortByDesc('total')->first(); @endphp
                            <h4 class="text-primary">{{ $terpadat['provinsi'] }}</h4>
                            <small class="text-muted">{{ number_format($terpadat['total']) }} penduduk</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <h6 class="text-success">Kota/Kabupaten Terendah</h6>
                            @php $terendah = collect($dataSejateng)->sortBy('total')->first(); @endphp
                            <h4 class="text-success">{{ $terendah['provinsi'] }}</h4>
                            <small class="text-muted">{{ number_format($terendah['total']) }} penduduk</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <h6 class="text-info">Rata-rata per Kota/Kabupaten</h6>
                            <h4 class="text-info">{{ number_format(collect($dataSejateng)->avg('total')) }}</h4>
                            <small class="text-muted">penduduk per kota/kabupaten</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if(count($dataSejateng) > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Jawa Tengah - Tahun {{ $tahun }}</h5>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <h6 class="text-info">Total Laki-laki</h6>
                            <h4 class="text-info">{{ number_format(collect($dataSejateng)->sum('pria')) }}</h4>
                            <small class="text-muted">Penduduk laki-laki</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <h6 class="text-warning">Total Perempuan</h6>
                            <h4 class="text-warning">{{ number_format(collect($dataSejateng)->sum('wanita')) }}</h4>
                            <small class="text-muted">Penduduk perempuan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal Tambah Data -->
<div class="modal fade" id="modalTambahData" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Tambah Data Kota/Kabupaten</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('penduduk.sejateng.tambah') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="provinsi" class="form-label">Nama Kota/Kabupaten</label>
                        <input type="text" class="form-control" id="provinsi" name="provinsi" required>
                    </div>
                    <div class="mb-3">
                        <label for="pria" class="form-label">Jumlah Laki-laki</label>
                        <input type="number" class="form-control" id="pria" name="pria" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="wanita" class="form-label">Jumlah Perempuan</label>
                        <input type="number" class="form-control" id="wanita" name="wanita" min="0" required>
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
@if(count($dataSejateng) > 0)
    @foreach($dataSejateng as $item)
    <div class="modal fade" id="modalEditData{{ $item['id'] }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Data Kota/Kabupaten</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('penduduk.sejateng.edit', $item['id']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="provinsi{{ $item['id'] }}" class="form-label">Nama Kota/Kabupaten</label>
                            <input type="text" class="form-control" id="provinsi{{ $item['id'] }}" name="provinsi" value="{{ $item['provinsi'] }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="pria{{ $item['id'] }}" class="form-label">Jumlah Laki-laki</label>
                            <input type="number" class="form-control" id="pria{{ $item['id'] }}" name="pria" value="{{ $item['pria'] }}" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="wanita{{ $item['id'] }}" class="form-label">Jumlah Perempuan</label>
                            <input type="number" class="form-control" id="wanita{{ $item['id'] }}" name="wanita" value="{{ $item['wanita'] }}" min="0" required>
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
                    <p>Apakah Anda yakin ingin menghapus data kota/kabupaten <strong>{{ $item['provinsi'] }}</strong>?</p>
                    <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('penduduk.sejateng.hapus', $item['id']) }}" method="POST" class="d-inline">
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
const dataSejateng = @json($dataSejateng);

// Hanya buat grafik jika ada data
if (dataSejateng && dataSejateng.length > 0) {
    const labels = dataSejateng.map(item => item.provinsi);
    const totals = dataSejateng.map(item => item.total);
    const lakiLaki = dataSejateng.map(item => item.pria);
    const perempuan = dataSejateng.map(item => item.wanita);

    // Grafik distribusi Jawa Tengah
    const sejatengCtx = document.getElementById('sejatengChart').getContext('2d');
    const sejatengChart = new Chart(sejatengCtx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: totals,
                backgroundColor: [
                    '#667eea', '#764ba2', '#f093fb', '#f5576c', '#4facfe',
                    '#43e97b', '#38f9d7', '#fa709a', '#fee140', '#ff9a9e'
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

    // Grafik perbandingan gender Jawa Tengah
    const genderSejatengCtx = document.getElementById('genderSejatengChart').getContext('2d');
    const genderSejatengChart = new Chart(genderSejatengCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'pria',
                data: lakiLaki,
                backgroundColor: '#667eea'
            }, {
                label: 'wanita',
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
} else {
    // Tampilkan pesan jika tidak ada data
    const sejatengCtx = document.getElementById('sejatengChart');
    const genderSejatengCtx = document.getElementById('genderSejatengChart');
    
    if (sejatengCtx) {
        sejatengCtx.style.display = 'none';
        sejatengCtx.parentElement.innerHTML = '<div class="text-center text-muted"><i class="fas fa-chart-pie me-2"></i>Tidak ada data untuk ditampilkan dalam grafik</div>';
    }
    
    if (genderSejatengCtx) {
        genderSejatengCtx.style.display = 'none';
        genderSejatengCtx.parentElement.innerHTML = '<div class="text-center text-muted"><i class="fas fa-chart-bar me-2"></i>Tidak ada data untuk ditampilkan dalam grafik</div>';
    }
}

// Auto-submit form when tahun changes
document.getElementById('tahun').addEventListener('change', function() {
    this.form.submit();
});
</script>
@endpush 