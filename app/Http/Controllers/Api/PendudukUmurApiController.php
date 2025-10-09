<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendudukUmur;

class PendudukUmurApiController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->get('tahun');
        if (!$tahun) {
            return response()->json(['error' => 'Tahun wajib diisi'], 400);
        }

        $data = PendudukUmur::where('tahun', $tahun)->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer',
            'umur' => 'required|string',
            'laki_laki' => 'required|integer',
            'perempuan' => 'required|integer'
        ]);

        $validated['jumlah'] = $validated['laki_laki'] + $validated['perempuan'];

        $data = PendudukUmur::create($validated);

        return response()->json($data, 201);
    }

    public function destroy($id)
    {
        $data = PendudukUmur::find($id);
        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
