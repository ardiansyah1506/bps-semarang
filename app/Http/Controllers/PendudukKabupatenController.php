<?php

namespace App\Http\Controllers;

use App\Models\PendudukJateng;
use Illuminate\Http\Request;

class PendudukKabupatenController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $filterProvinsi = $request->get('provinsi', []);
    
        // Ambil data dari database berdasarkan tahun
        $dataSejateng = PendudukJateng::where('tahun', $tahun)
            ->select('id', 'provinsi', 'pria', 'wanita', 'jumlahwarga as total')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'provinsi' => $item->provinsi,
                    'pria' => $item->pria,
                    'wanita' => $item->wanita,
                    'total' => $item->total
                ];
            })
            ->toArray();
    
        // Filter jika ada provinsi
        if (!empty($filterProvinsi) && is_array($filterProvinsi)) {
            $dataSejateng = array_filter($dataSejateng, function($item) use ($filterProvinsi) {
                return in_array($item['provinsi'], $filterProvinsi);
            });
            $dataSejateng = array_values($dataSejateng);
        }
    
        $tahunList = ['2020','2021','2022', '2023', '2024'];
    
        return view('dashboard.penduduk-sejateng', compact('dataSejateng', 'tahun', 'tahunList', 'filterProvinsi'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'provinsi' => 'required|string',
            'pria' => 'required|integer|min:0',
            'wanita' => 'required|integer|min:0',
            'tahun' => 'required|integer'
        ]);
    
        try {
            $total = $request->pria + $request->wanita;
    
            PendudukJateng::create([
                'tahun' => $request->tahun,
                'provinsi' => $request->provinsi,
                'pria' => $request->pria,
                'wanita' => $request->wanita,
                'jumlahwarga' => $total
            ]);
    
            return redirect()->route('penduduk.sejateng.index', [
                'tahun' => $request->tahun
            ])->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'provinsi' => 'required|string',
            'pria' => 'required|integer|min:0',
            'wanita' => 'required|integer|min:0',
            'tahun' => 'required|integer'
        ]);
    
        try {
            $total = $request->pria + $request->wanita;
    
            $data = PendudukJateng::findOrFail($id);
            $data->update([
                'tahun' => $request->tahun,
                'provinsi' => $request->provinsi,
                'pria' => $request->pria,
                'wanita' => $request->wanita,
                'jumlahwarga' => $total
            ]);
    
            return redirect()->route('penduduk.sejateng.index', [
                'tahun' => $request->tahun
            ])->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }
    
    public function delete($id)
    {
        try {
            $data = PendudukJateng::findOrFail($id);
            $data->delete();
    
            return redirect()->back()->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
    
}
