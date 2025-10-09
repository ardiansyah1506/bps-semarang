@extends('layouts.app')
@section('title', 'Menu Gini Rasio')
@section('page-title', 'Menu Gini Rasio')
@section('page-subtitle', 'Pilih data Gini Rasio yang ingin ditampilkan')
@section('content')
<div class="container mt-4">
    <div class="row g-4">
        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm rounded">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">IPM</h5>
                    <p class="card-text">Indeks Pembangunan Manusia Kota Semarang</p>
                    <a href="{{ route('ipmdata') }}" class="btn btn-primary">
                        <i class="bi bi-bar-chart-fill"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="col-md-4">
            <div class="card h-100  shadow-sm rounded">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">IPG</h5>
                    <p class="card-text">Indeks Pembangunan Gender Kota Semarang</p>
                    <a href="{{ route('ipgdata') }}" class="btn btn-success"></a>
                        <i class="bi bi-people-fill"></i> Lihat Data        
                    </a>
                </div>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm rounded">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">IDG</h5>
                    <p class="card-text">Indeks Pemberdayaan Gender Kota Semarang</p>
                   <a href="{{ route('nakerjateng') }}" class="btn btn-success"></a>
                        <i class="bi bi-graph-up"></i> Lihat Data   
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection