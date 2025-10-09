@extends('layouts.app')

@section('title', 'Input Data Indeks Pemberdayaan Gender')
@section('page-title', 'Input Data IDG')
@section('page-subtitle', 'Tambah data IDG per tahun')

@section('content')
<div class="container">
    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter Data --}}
    <form method="GET" action="#" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <select name="tahun" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih Tahun --</option>
                    @for($t = 2020; $t <= 2024; $t++)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endfor
                </select>
            </div>
           
             
                  
                </select>
            </div>
        </div>
    </form>

    {{-- Form Input Data --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Form Tambah Data Inflasi</div>
        <div class="card-body">
            <form action="" method="POST">
                @csrf

                <input type="hidden" name="tahun" value="{{ $tahun }}">
               
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Nilai</th>
                            
                          
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($IDG as $index => $kategori)
<tr>
    <td>{{ $index + 1 }}</td>
    <td>
        <input type="hidden" name="kategori[]" value="{{ $kategori }}">
        {{ $kategori }}
    </td>
    <td><input type="number" step="0.01" name="nilai[]" class="form-control" required></td>
    
    

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
        <div class="card-header bg-secondary text-white">Data IDG Tersimpan</div>
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Kategori</th>
                        <th>Nilai</th>
                       
                  
                    </tr>
                </thead>
                <tbody>
                   @forelse($IDGSatu as $index => $item)
<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $item->tahun }}</td>
    <td>{{ $item->kategori }}</td>
    <td>{{ $item->nilai }}</td>
 
    
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
