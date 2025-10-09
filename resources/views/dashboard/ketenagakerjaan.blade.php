@extends('layouts.app')

@section('title', 'Data Ketenagakerjaan')
@section('page-title', 'Menu Data Ketenagakerjaan')
@section('page-subtitle', 'Pilih data ketenagakerjaan yang ingin ditampilkan')

@section('content')
<div class="container mt-4">
    <div class="row g-4">
        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm rounded">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Presentase Usia Kerja 15+ Tahun</h5>
                    <p class="card-text">Statistik berdasarkan kegiatan & jenis kelamin</p>
                    <a href="{{ route('ketenagakerjaan') }}" class="btn btn-primary">
                        <i class="bi bi-bar-chart-fill"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm rounded">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Jumlah Usia Kerja Kota Semarang</h5>
                    <p class="card-text">Data berdasarkan kegiatan & jenis kelamin</p>
                    <a href="{{ route('tenagakerjadua') }}" class="btn btn-success">
                        <i class="bi bi-people-fill"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm rounded">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Kondisi Ketenagakerjaan Jateng</h5>
                    <p class="card-text">Statistik kota/kabupaten di Jawa Tengah</p>
                    <a href="#" class="btn btn-warning text-white">
                        <i class="bi bi-graph-up"></i> Lihat Data
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
