<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Penduduk; 
use Illuminate\Http\Request;

class PendudukApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $query = Penduduk::query();

    if ($request->filled('tahun')) {
        $query->where('tahun', $request->tahun);
    }

    $data = $query->get();

    return response()->json($data);
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer',
            'kecamatan' => 'required|string',
            'jumlah_penduduk' => 'required|integer',
            'laki_laki' => 'required|integer',
            'perempuan' => 'required|integer'
        ]);

        // Hitung jumlah penduduk
        $validated['jumlah_penduduk'] = $validated['laki_laki'] + $validated['perempuan'];

        // Simpan data penduduk
        $data = Penduduk::create($validated);

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Penduduk::find($id);
        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
