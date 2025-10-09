<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\GiniRasMis; // Assuming you have a GiniRasMis model
use Illuminate\Http\Request;

class GiniRasMisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $query = GiniRasMis::query();
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
            'penduduk_miskin' => 'required|integer|min:0',
            'penduduk_miskin_persen' => 'required|numeric|min:0',
            'garis_kemiskinan' => 'required|integer|min:0',
            'gini_rasio' => 'required|numeric|min:0',
            'jumlah' => 'nullable|integer|min:0', // This will be calculated later
        ]);

        $validated['jumlah'] = $validated['penduduk_miskin'] + $validated['garis_kemiskinan'] + $validated['gini_rasio'];

        $giniRasMis = GiniRasMis::create($validated);
        return response()->json($giniRasMis, 201);
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
        $giniRasMis = GiniRasMis::findOrFail($id);
        $giniRasMis->delete();
        return response()->json(null, 204);
    }
}
