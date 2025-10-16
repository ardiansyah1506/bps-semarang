<?php

namespace App\Http\Controllers;

use App\Models\PendudukUmur;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
// use Maatwebsite\Excel\Concerns\ToModel;
use App\Imports\PendudukUmurImport;


class PendudukUmurController extends Controller
{
    public function index(Request $request)
    {
        // Daftar tahun yang bisa dipilih
        $tahunList = ['2020','2021', '2022', '2023', '2024'];
    
        // Ambil tahun dari request atau default ke tahun terakhir di daftar
        $tahun = $request->get('tahun');
        if (!$tahun || !in_array($tahun, $tahunList)) {
            $tahun = end($tahunList);
        }
    
        $filterUmur = $request->get('umur', []); // filter umur array
    
        // Ambil data berdasarkan tahun
        $dataUmurQuery = PendudukUmur::where('tahun', $tahun)
            ->select('id', 'umur', 'laki_laki', 'perempuan', 'jumlah');
    
        $dataUmur = $dataUmurQuery->get()->map(function ($item) {
            return [
                'id'         => $item->id,
                'umur'       => $item->umur,
                'laki_laki'  => $item->laki_laki,
                'perempuan'  => $item->perempuan,
                'jumlah'     => $item->jumlah
            ];
        })->toArray();
    
        // Fallback: jika data kosong, ambil tahun terakhir yang ada datanya
      
        // Filter umur jika ada
        if (!empty($filterUmur) && is_array($filterUmur)) {
            $dataUmur = array_filter($dataUmur, function ($item) use ($filterUmur) {
                return in_array($item['umur'], $filterUmur);
            });
            $dataUmur = array_values($dataUmur); // reset key
        }
    
        $umurList = [
            '0-4 tahun' => '0-4 tahun',
            '5-9 tahun' => '5-9 tahun',
            '10-14 tahun' => '10-14 tahun',
            '15-19 tahun' => '15-19 tahun',
            '20-24 tahun' => '20-24 tahun',
            '25-29 tahun' => '25-29 tahun',
            '30-34 tahun' => '30-34 tahun',
            '35-39 tahun' => '35-39 tahun',
            '40-44 tahun' => '40-44 tahun',
            '45-49 tahun' => '45-49 tahun',
            '50-54 tahun' => '50-54 tahun',
            '55-59 tahun' => '55-59 tahun',
            '60-64 tahun' => '60-64 tahun',
            '65-69 tahun' => '65-69 tahun',
            '70-74 tahun' => '70-74 tahun',
            '75+ tahun'  => '75+ tahun',
        ];
    
        return view('dashboard.penduduk-umur', compact('dataUmur', 'tahun', 'tahunList', 'umurList', 'filterUmur'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'umur' => 'required|string',
            'laki_laki' => 'required|integer|min:0',
            'perempuan' => 'required|integer|min:0',
            'tahun' => 'required|integer'
        ]);

        try {
            // Hitung total
            $total = $request->laki_laki + $request->perempuan;
            
            // Simpan ke database
            PendudukUmur::create([
                'tahun' => $request->tahun,
                 'umur' => $request->umur, // Gunakan field umur untuk menyimpan umur
                'laki_laki' => $request->laki_laki,
                'perempuan' => $request->perempuan,
                'jumlah' => $total
            ]);
            
            return redirect()->route('penduduk.umur.index', [
                'tahun' => $request->tahun
            ])->with('success', 'Data berhasil ditambahkan!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    // Method untuk edit data umur
    public function update(Request $request, $id)
    {
        $request->validate([
            'umur' => 'required|string',
            'laki_laki' => 'required|integer|min:0',
            'perempuan' => 'required|integer|min:0',
            'tahun' => 'required|integer'
        ]);

        try {
            // Hitung total
            $total = $request->laki_laki + $request->perempuan;
            
            // Update data di database
            $penduduk = PendudukUmur::findOrFail($id);
            $penduduk->update([
                'tahun' => $request->tahun,
                'umur' => $request->umur, // Gunakan field kecamatan untuk menyimpan umur
                'laki_laki' => $request->laki_laki,
                'perempuan' => $request->perempuan,
                'jumlah' => $total
            ]);
            
            return redirect()->route('penduduk.umur.index', [
                'tahun' => $request->tahun
            ])->with('success', 'Data berhasil diperbarui!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    // Method untuk hapus data umur
    public function delete($id)
    {
        try {
            // Hapus data dari database
            $penduduk = PendudukUmur::findOrFail($id);
            $penduduk->delete();
            
            return redirect()->back()->with('success', 'Data berhasil dihapus!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function showImportForm()
    {
        return view('penduduk.umur.import');
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
        // 'tahun' => 'required|integer',
    ]);

    try {
        // Excel::import(new PendudukUmurImport($request->tahun), $request->file('file'));
        Excel::import(new PendudukUmur, request()->file('file'));
        return redirect()->route('dashboard.penduduk-umur')->with('success', 'Data berhasil diimpor.');
    } catch (\Exception $e) {
        return back()->withErrors(['import_error' => $e->getMessage()]);
    }
}

}
