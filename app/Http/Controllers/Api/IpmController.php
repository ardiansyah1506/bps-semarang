<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IpM; // Assuming you have an Ipm model
use Illuminate\Http\Request;

class IpmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $query = IpM::query();
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
            'UHH' => 'required|numeric',
            'RLS' => 'required|numeric',
            'HLS' => 'required|numeric',
            'Pengeluaran' => 'required|integer|min:0',
            'jumlah' => 'nullable|integer|min:0', // This will be calculated later
        ]);
        $validated['jumlah'] =
            $validated['UHH'] + $validated['RLS'] + $validated['HLS'];

        $ipm = IpM::create($validated);
        return response()->json($ipm, 201);

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
        $ipm = IpM::findOrFail($id);
        $ipm->delete();
        return response()->json(null, 204);
    }
}
