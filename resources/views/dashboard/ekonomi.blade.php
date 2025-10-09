@extends('layouts.app')

@section('title', 'Menu Ekonomi')
@section('page-title', 'Menu Ekonomi')
@section('page-subtitle', 'Pilih data Ekonomi yang ingin ditampilkan')

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

        {{-- Card 1 --}}
        <div class="col-md-4">
            <div class="card menu-card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title fw-bold">
                        Pertumbuhan Ekonomi Triwulan Menurut Lapangan Usaha
                    </h5>
                    <a href="{{ route('ekonomi.satu') }}" class="btn btn-primary">
                        <i class="bi bi-bar-chart-fill"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="col-md-4">
            <div class="card menu-card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title fw-bold">
                        Pertumbuhan Ekonomi Triwulanan Menurut Pengeluaran
                    </h5>
                    <a href="{{ route('ekonomi.tambah.se') }}" class="btn btn-success">
                        <i class="bi bi-graph-up"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
