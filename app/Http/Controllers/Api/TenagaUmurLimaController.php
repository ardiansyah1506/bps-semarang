<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\_Tenagakerja;

class TenagaUmurLimaController extends Controller
{
    public function index(Request $request)
    {
        $query = _Tenagakerja::query();

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $data = $query->get()->map(function ($item) {
            // Normalisasi koma jadi titik lalu cast ke float
            $item->tpak = (float) str_replace(',', '.', $item->tpak);
            $item->tkk  = (float) str_replace(',', '.', $item->tkk);
            $item->tpt  = (float) str_replace(',', '.', $item->tpt);

            // Hitung jumlah total angkatan kerja
            $item->jumlah =
                (int) $item->bekerja_laki_laki +
                (int) $item->bekerja_perempuan +
                (int) $item->pengangguran_laki_laki +
                (int) $item->pengangguran_perempuan;

            return $item;
        });

        return response()->json($data);
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'tahun' => 'required|integer',
        'tpak' => 'required|string',
        'tkk' => 'required|string',
        'tpt' => 'required|string',
        'bekerja_laki_laki' => 'required|integer|min:0',
        'bekerja_perempuan' => 'required|integer|min:0',
        'pengangguran_laki_laki' => 'required|integer|min:0',
        'pengangguran_perempuan' => 'required|integer|min:0',
        'jumlah' => 'required|integer|min:0',
    ]);

    // Pastikan simpan dengan titik
    $validated['tpak'] = str_replace(',', '.', $validated['tpak']);
    $validated['tkk']  = str_replace(',', '.', $validated['tkk']);
    $validated['tpt']  = str_replace(',', '.', $validated['tpt']);

    // Hitung jumlah total angkatan kerja
    $validated['jumlah'] =
        $validated['bekerja_laki_laki'] +
        $validated['bekerja_perempuan'] +
        $validated['pengangguran_laki_laki'] +
        $validated['pengangguran_perempuan'];

    $data = _Tenagakerja::create($validated);

    return response()->json($data, 201);
}

    public function destroy($id)
    {
        $data = _Tenagakerja::find($id);
        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
