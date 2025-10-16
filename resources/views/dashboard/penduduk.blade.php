@extends('layouts.app')

@section('title', 'Data Penduduk - BPS Kota Semarang')
@section('page-title', 'Data Penduduk')
@section('page-subtitle', 'Statistik penduduk Kota Semarang')

@section('content')
<div class="row fade-in-up">
    <!-- Card Umur -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 shadow-sm" style="transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-birthday-cake fa-3x text-primary"></i>
                </div>
                <h5 class="card-title">Data Penduduk Berdasarkan Umur</h5>
                <p class="card-text text-muted">Statistik penduduk Kota Semarang berdasarkan kelompok umur</p>
                <a href="{{ route('penduduk.umur.index') }}" class="btn btn-primary">
                    <i class="fas fa-chart-pie me-2"></i>Lihat Data
                </a>
            </div>
        </div>
    </div>

    <!-- Card Kecamatan -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 shadow-sm" style="transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-map-marker-alt fa-3x text-success"></i>
                </div>
                <h5 class="card-title">Data Penduduk per Kecamatan</h5>
                <p class="card-text text-muted">Statistik penduduk Kota Semarang per kecamatan</p>
                <a href="{{ route('penduduk.kecamatan.index') }}" class="btn btn-success">
                    <i class="fas fa-chart-bar me-2"></i>Lihat Data
                </a>
            </div>
        </div>
    </div>

    <!-- Card Sejateng -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 shadow-sm" style="transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-map fa-3x text-warning"></i>
                </div>
                <h5 class="card-title">Data Penduduk Jawa Tengah</h5>
                <p class="card-text text-muted">Statistik penduduk kota/kabupaten di Jawa Tengah</p>
                <a href="{{ route('penduduk.sejateng.index') }}" class="btn btn-warning">
                    <i class="fas fa-chart-line me-2"></i>Lihat Data
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Ringkasan -->
<div class="row mt-4 fade-in-up">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-area me-2"></i>Ringkasan Statistik Penduduk Kota Semarang</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center mb-3">
                        <div class="border rounded p-3">
                            <i class="fas fa-users fa-2x text-primary mb-2"></i>
                            <h4 class="text-primary">{{ number_format($totalPenduduk) }}</h4>
                            <p class="mb-0 text-muted">Total Penduduk</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center mb-3">
                        <div class="border rounded p-3">
                            <i class="fas fa-male fa-2x text-info mb-2"></i>
                            <h4 class="text-info">{{ number_format($totalLaki) }}</h4>
                            <p class="mb-0 text-muted">Laki-laki</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center mb-3">
                        <div class="border rounded p-3">
                            <i class="fas fa-female fa-2x text-danger mb-2"></i>
                            <h4 class="text-danger">{{ number_format($totalPerempuan) }}</h4>
                            <p class="mb-0 text-muted">Perempuan</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center mb-3">
                        <div class="border rounded p-3">
                            <i class="fas fa-map-marker-alt fa-2x text-success mb-2"></i>
                            <h4 class="text-success">{{ $totalKecamatan }}</h4>
                            <p class="mb-0 text-muted">Kecamatan</p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>


@endsection 