<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;

class PendudukKecamatanController extends Controller
{

    public function index(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));

        // Normalisasi filter menjadi array
        $rawFilter = $request->input('kecamatan');
        $filterKecamatan = [];
        if (is_array($rawFilter)) {
            $filterKecamatan = array_values(array_filter($rawFilter, fn($v) => $v !== null && $v !== ''));
        } elseif (is_string($rawFilter) && trim($rawFilter) !== '') {
            $filterKecamatan = array_values(array_filter(array_map('trim', explode(',', $rawFilter)), fn($v) => $v !== ''));
        }

        // Query dasar
        $query = Penduduk::where('tahun', $tahun)
            ->where('kecamatan', 'not like', '%tahun%')
            ->select('id', 'kecamatan', 'laki_laki', 'perempuan', 'jumlah_penduduk as total');

        // Terapkan filter hanya jika ada nilai
        if (count($filterKecamatan) > 0) {
            $query->whereIn('kecamatan', $filterKecamatan);
        }

        $dataKecamatan = $query->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'kecamatan' => $item->kecamatan,
                    'laki_laki' => $item->laki_laki,
                    'perempuan' => $item->perempuan,
                    'total' => $item->total
                ];
            })
            ->toArray();

        $tahunList = ['2020','2021', '2022', '2023', '2024'];

        return view('dashboard.penduduk-kecamatan', compact('dataKecamatan', 'tahun', 'tahunList', 'filterKecamatan'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'kecamatan' => 'required|string',
            'laki_laki' => 'required|integer|min:0',
            'perempuan' => 'required|integer|min:0',
            'tahun' => 'required|integer'
        ]);

        try {
            // Hitung total
            $total = $request->laki_laki + $request->perempuan;
            
            // Simpan ke database
            Penduduk::create([
                'tahun' => $request->tahun,
                'kecamatan' => $request->kecamatan,
                'laki_laki' => $request->laki_laki,
                'perempuan' => $request->perempuan,
                'jumlah_penduduk' => $total
            ]);
            
            return redirect()->route('penduduk.kecamatan.index', [
                'tahun' => $request->tahun
            ])->with('success', 'Data berhasil ditambahkan!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    // Method untuk edit data kecamatan
    public function update(Request $request, $id)
    {
        $request->validate([
            'kecamatan' => 'required|string',
            'laki_laki' => 'required|integer|min:0',
            'perempuan' => 'required|integer|min:0',
            'tahun' => 'required|integer'
        ]);

        try {
            // Hitung total
            $total = $request->laki_laki + $request->perempuan;
            
            // Update data di database
            $penduduk = Penduduk::findOrFail($id);
            $penduduk->update([
                'tahun' => $request->tahun,
                'kecamatan' => $request->kecamatan,
                'laki_laki' => $request->laki_laki,
                'perempuan' => $request->perempuan,
                'jumlah_penduduk' => $total
            ]);
            
            return redirect()->route('penduduk.kecamatan.index', [
                'tahun' => $request->tahun
            ])->with('success', 'Data berhasil diperbarui!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    // Method untuk hapus data kecamatan
    public function delete($id)
    {
        try {
            // Hapus data dari database
            $penduduk = Penduduk::findOrFail($id);
            $penduduk->delete();
            
            return redirect()->back()->with('success', 'Data berhasil dihapus!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

}
