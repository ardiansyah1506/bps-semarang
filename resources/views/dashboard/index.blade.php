@extends('layouts.app')

@section('title', 'Dashboard - BPS Kota Semarang')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data statistik Kota Semarang')

@section('content')
<div class="row">
    <!-- Statistik Cards -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="number">{{ number_format($totalPenduduk) }}</div>
                    <div class="label">Total Penduduk</div>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="number">{{ number_format($totalTenagaKerja) }}</div>
                    <div class="label">Angkatan Kerja</div>
                </div>
                <div class="icon">
                    <i class="fas fa-briefcase"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="number">{{ number_format($totalPendudukMiskin) }}</div>
                    <div class="label">Penduduk Miskin</div>
                </div>
                <div class="icon">
                    <i class="fas fa-heart"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="number">{{ number_format($rataGiniRasio, 3) }}</div>
                    <div class="label">Rata-rata Gini Rasio</div>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Grafik dan Informasi -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Trend Statistik Kota Semarang</h5>
            </div>
            <div class="card-body">
                <canvas id="statisticsChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi BPS</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6><i class="fas fa-map-marker-alt text-primary me-2"></i>Lokasi</h6>
                    <p class="mb-0">Jl. Dr. Wahidin No.1, Semarang Tengah, Kota Semarang</p>
                </div>
                <div class="mb-3">
                    <h6><i class="fas fa-phone text-primary me-2"></i>Kontak</h6>
                    <p class="mb-0">(024) 351-1234</p>
                </div>
                <div class="mb-3">
                    <h6><i class="fas fa-envelope text-primary me-2"></i>Email</h6>
                    <p class="mb-0">bps3374@bps.go.id</p>
                </div>
                <div>
                    <h6><i class="fas fa-globe text-primary me-2"></i>Website</h6>
                    <p class="mb-0">semarangkota.bps.go.id</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Menu Cepat -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Akses Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('penduduk') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-users me-2"></i>Data Penduduk
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('tenaga-kerja') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-briefcase me-2"></i>Tenaga Kerja
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('kemiskinan') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-heart me-2"></i>Data Kemiskinan
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('gini-rasio') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-chart-line me-2"></i>Gini Rasio dan Kemiskinan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
// Data dari controller (Blade -> JS)
const labelsPenduduk = @json($labelsPenduduk);
const dataPenduduk = @json($jumlahPenduduk);

const labelsKemiskinan = @json($labelsKemiskinan);
const dataJumlahMiskin = @json($dataJumlahMiskin);
const dataPersentaseMiskin = @json($dataPersentaseMiskin);

// Satukan label tahun dari kedua sumber dan urutkan
const labels = Array.from(new Set([...labelsPenduduk, ...labelsKemiskinan]))
  .sort((a, b) => Number(a) - Number(b));

// Helper untuk memetakan data ke label gabungan
function mapToLabels(srcLabels, srcData, targetLabels) {
  const map = new Map(srcLabels.map((l, i) => [String(l), srcData[i]]));
  return targetLabels.map(l => map.has(String(l)) ? map.get(String(l)) : null);
}

const pendudukAligned = mapToLabels(labelsPenduduk, dataPenduduk, labels);
const miskinAligned = mapToLabels(labelsKemiskinan, dataJumlahMiskin, labels);
const persentaseAligned = mapToLabels(labelsKemiskinan, dataPersentaseMiskin, labels);

const ctx = document.getElementById('statisticsChart').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels,
    datasets: [
      {
        label: 'Penduduk',
        data: pendudukAligned,
        borderColor: '#667eea',
        backgroundColor: 'rgba(102, 126, 234, 0.1)',
        tension: 0.4,
        yAxisID: 'y'
      },
      {
        label: 'Penduduk Miskin',
        data: miskinAligned,
        borderColor: '#f093fb',
        backgroundColor: 'rgba(240, 147, 251, 0.1)',
        tension: 0.4,
        yAxisID: 'y'
      },
      {
        label: 'Persentase Kemiskinan (%)',
        data: persentaseAligned,
        borderColor: '#764ba2',
        backgroundColor: 'rgba(118, 75, 162, 0.1)',
        tension: 0.4,
        yAxisID: 'y1'
      }
    ]
  },
  options: {
    responsive: true,
    interaction: { mode: 'index', intersect: false },
    plugins: {
      legend: { position: 'top' },
      title: {
        display: true,
        text: 'Trend Statistik Kota Semarang'
      },
      tooltip: {
        callbacks: {
          label: (ctx) => {
            const dsLabel = ctx.dataset.label || '';
            const val = ctx.parsed.y;
            if (dsLabel.includes('%')) return `${dsLabel}: ${val ?? '-'}%`;
            return `${dsLabel}: ${val?.toLocaleString() ?? '-'}`;
          }
        }
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        title: { display: true, text: 'Jumlah (orang)' }
      },
      y1: {
        beginAtZero: true,
        position: 'right',
        grid: { drawOnChartArea: false },
        title: { display: true, text: 'Persentase (%)' }
      }
    }
  }
});
</script>
@endpush