<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PendudukJateng;
use Illuminate\Http\Request;

class PendudukJatengApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PendudukJateng::query();
        if($request->filled('tahun')){
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
            'provinsi' => 'required|string',
            'jumlahwarga' => 'required|integer',
            'pria' => 'required|integer',
            'wanita' => 'required|integer'
        ]);

        // Hitung jumlah warga
        $validated['jumlahwarga'] = $validated['pria'] + $validated['wanita'];

        // Simpan data penduduk jateng
        $data = PendudukJateng::create($validated);

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
        $data = PendudukJateng::find($id);
        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
