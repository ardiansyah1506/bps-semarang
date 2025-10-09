@extends('layouts.app')

@section('title', 'Menu Gini Rasio')
@section('page-title', 'Menu Gini Rasio')
@section('page-subtitle', 'Pilih data Gini Rasio yang ingin ditampilkan')

@section('content')
<style>
    .menu-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 1rem;
        overflow: hidden;
    }
    .menu-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }
    .menu-card .card-body {
        padding: 2rem 1rem;
    }
    .menu-card .card-title {
        font-size: 1.1rem;
        min-height: 50px;
        margin-bottom: 1rem;
    }
    .menu-card .btn {
        border-radius: 2rem;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .menu-card .btn:hover {
        transform: scale(1.05);
    }
</style>

<div class="container mt-4">
    <div class="row g-4">
        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card menu-card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Makanan, Minuman dan Tembakau</h5>
                    <a href="{{ route('inflasimakanan') }}" class="btn btn-primary">
                        <i class="bi bi-bar-chart-fill"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>


        <!-- Card 3 -->
        <div class="col-md-4">
            <div class="card menu-card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Pakaian dan Alas Kaki</h5>
                    <a href="{{route('PakaianInflasi')  }}" class="btn btn-success">
                        <i class="bi bi-graph-up"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-4">
            <div class="card menu-card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Perumahan, Air, Listrik, Bahan Bakar Rumah Tangga</h5>
                    <a href="{{ route('PPLInflasi') }}" class="btn btn-info">
                        <i class="bi bi-house-fill"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="col-md-4">
            <div class="card menu-card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Perlengkapan, Peralatan & Pemeliharaan Rumah Tangga</h5>
                    <a href="{{ route('PemeliharaRT') }}" class="btn btn-warning">
                        <i class="bi bi-tools"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="col-md-4">
            <div class="card menu-card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Kesehatan</h5>
                    <a href="{{ route('PerlengkapanSehat') }}" class="btn btn-danger">
                        <i class="bi bi-heart-fill"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 7 -->
        <div class="col-md-4">
            <div class="card menu-card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Transportasi</h5>
                    <a href="{{ route('inflasiSehatTrans') }}" class="btn btn-secondary">
                        <i class="bi bi-car-front-fill"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 8 -->
        <div class="col-md-4">
            <div class="card menu-card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Informasi, Komunikasi & Jasa Keuangan</h5>
                    <a href="{{ route('informasi') }}" class="btn btn-dark">
                        <i class="bi bi-phone-fill"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 9 -->
        <div class="col-md-4">
            <div class="card menu-card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Rekreasi, Olahraga & Budaya</h5>
                    <a href="{{ route('inflasirekreasi') }}" class="btn btn-light border">
                        <i class="bi bi-music-note-beamed"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 10 -->
        <div class="col-md-4">
            <div class="card menu-card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Pendidikan</h5>
                    <a href="#" class="btn btn-primary">
                        <i class="bi bi-book-fill"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 11 -->
        <div class="col-md-4">
            <div class="card menu-card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Penyediaan Makanan & Minuman / Restoran</h5>
                    <a href="#" class="btn btn-success">
                        <i class="bi bi-cup-straw"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 12 -->
        <div class="col-md-4">
            <div class="card menu-card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Perawatan Pribadi & Jasa Lainnya</h5>
                    <a href="#" class="btn btn-info">
                        <i class="bi bi-scissors"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
