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
        $tahunList = PendudukUmur::select('tahun')->distinct()->pluck('tahun')->sortDesc()->values()->toArray();
        $tahun = $request->get('tahun', $tahunList[0] ?? date('Y'));
        $filterUmur = $request->get('umur', []);

        $query = PendudukUmur::where('tahun', $tahun);

        if (!empty($filterUmur)) {
            $query->whereIn('umur', $filterUmur);
        }

        $data = $query->get();

        $umurList = PendudukUmur::select('umur')->distinct()->pluck('umur', 'umur')->toArray();

        return view('penduduk.umur.index', compact('data', 'tahun', 'tahunList', 'umurList', 'filterUmur'));
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
