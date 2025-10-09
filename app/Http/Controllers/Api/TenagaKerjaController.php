<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\_Tenagakerja;
use App\Models\TenagaKerja;

class TenagaKerjaController extends Controller
{
    public function index()
    {
        $data = _Tenagakerja::all();
        return response()->json($data);
    }
}
