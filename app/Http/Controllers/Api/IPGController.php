<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IPG; // Assuming you have an Ipg model
use Illuminate\Http\Request;

class IPGController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $query = IPG::query();
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
        $validated = $request->validated([
            'tahun' => 'required|integer|min:0',
            'UHH_Pria' => 'required|numeric|min:0',
            'UHH_Wanita' => 'required|numeric|min:0',
            'RLS_Pria' => 'required|numeric|min:0',
            'RLS_Wanita' => 'required|numeric|min:0',
            'HLS_Pria' => 'required|numeric|min:0',
            'HLS_Wanita' => 'required|numeric|min:0',
            'Pengeluaran_Pria' => 'required|integer|min:0',
            'Pengeluaran_Wanita' => 'required|integer|min:0',
            'jumlah' => 'nullable|integer|min:0', // This will be calculated later
        ]);
        $validated['jumlah'] =
            $validated['UHH_Pria'] + $validated['UHH_Wanita'] +
            $validated['RLS_Pria'] + $validated['RLS_Wanita'] +
            $validated['HLS_Pria'] + $validated['HLS_Wanita'];

        $ipg = IPG::create($validated);
        return response()->json($ipg, 201);
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
        $ipg = IPG::findOrFail($id);
        $ipg->delete();
        return response()->json(null, 204);
    }
}
