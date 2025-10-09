@extends('layouts.app')

@section('title', 'Input Data Inflasi')
@section('page-title', 'Input Data Inflasi')
@section('page-subtitle', 'Tambah data inflasi per komponen')

@section('content')
<div class="container">
    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter Data --}}
    <form method="GET" action="{{ route('inflasi.data') }}" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <select name="tahun" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih Tahun --</option>
                    @for($t = 2020; $t <= 2024; $t++)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                @php
                    $bulanList = [
                        'Januari','Februari','Maret','April','Mei','Juni',
                        'Juli','Agustus','September','Oktober','November','Desember'
                    ];
                @endphp
                <select name="bulan" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih Bulan --</option>
                    @foreach($bulanList as $bln)
                        <option value="{{ $bln }}" {{ $bulan == $bln ? 'selected' : '' }}>{{ $bln }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    {{-- Form Input Data --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Form Tambah Data Inflasi</div>
        <div class="card-body">
            <form action="{{ route('inflasi.store') }}" method="POST">
                @csrf

                <input type="hidden" name="tahun" value="{{ $tahun }}">
                <input type="hidden" name="bulan" value="{{ $bulan }}">

                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>IHK</th>
                            <th>Inflasi Kumulatif</th>
                            <th>Andil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoriList as $index => $kategori)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <input type="hidden" name="kategori[]" value="{{ $kategori }}">
                                    {{ $kategori }}
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="ihk[]" class="form-control" required>
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="inflasi_komulatif[]" class="form-control" required>
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="andil[]" class="form-control" required>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">💾 Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Data yang Sudah Disimpan --}}
    <div class="card">
        <div class="card-header bg-secondary text-white">Data Inflasi Tersimpan</div>
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Bulan</th>
                        <th>Kategori</th>
                        <th>IHK</th>
                        <th>Inflasi Kumulatif</th>
                        <th>Andil</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inflasiList as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->tahun }}</td>
                            <td>{{ $item->bulan }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>{{ $item->ihk }}</td>
                            <td>{{ $item->inflasi_komulatif }}</td>
                            <td>{{ $item->andil }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data tersimpan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
