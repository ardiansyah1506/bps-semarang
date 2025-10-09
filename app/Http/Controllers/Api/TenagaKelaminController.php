<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TenagaKerjaDua;
use Illuminate\Http\Request;

class TenagaKelaminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = TenagaKerjaDua::query();
        if (request()->has('tahun')) {
            $query->where('tahun', request()->get('tahun'));
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
            'bekerja_pria' => 'required|integer|min:0',
            'bekerja_wanita' => 'required|integer|min:0',
            'pengangguran_pria' => 'required|integer|min:0',
            'pengangguran_wanita' => 'required|integer|min:0',
            'sekolah_pria' => 'required|integer|min:0',
            'sekolah_wanita' => 'required|integer|min:0',
            'rt_pria' => 'required|integer|min:0',
            'rt_wanita' => 'required|integer|min:0',
            'lainnya_pria' => 'required|integer|min:0',
            'lainnya_wanita' => 'required|integer|min:0',
            'jumlah' => 'nullable|integer|min:0', // This will be calculated later
          
   ]);

       $validated['jumlah'] = 
    $validated['bekerja_pria'] + $validated['bekerja_wanita'] +
    $validated['pengangguran_pria'] + $validated['pengangguran_wanita'] +
    $validated['sekolah_pria'] + $validated['sekolah_wanita'] +
    $validated['rt_pria'] + $validated['rt_wanita'] +
    $validated['lainnya_pria'] + $validated['lainnya_wanita'];


        $tenagaKelamin = TenagaKerjaDua::create($validated);

        return response()->json($tenagaKelamin, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
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
        $tenagaKelamin = TenagaKerjaDua::findOrFail($id);
        $tenagaKelamin->delete();
        return response()->json(null, 204);
    }
}
