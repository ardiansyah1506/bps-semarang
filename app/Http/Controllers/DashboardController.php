<?php

namespace App\Http\Controllers;

use App\Models\Kemiskinan;
use App\Models\PemeliharaRT;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\TenagaKerjaDua;
use App\Models\TenagaKerja;
use App\Models\IPG;
use App\Models\NakerJateng;
use App\Models\GiniRasMis;
use App\Models\IpM;
use App\Models\EkonomiSE;
use App\Models\Ekonomi;
use App\Models\Trans;
use App\Models\PerlengkapanSehat;
use App\Models\InflasiPPL;
use App\Models\InflasiPakaian;
use App\Models\InflasiMakanan;
use App\Models\PendudukJateng;
use App\Models\Informasi;
use App\Models\Pendidikan;
use App\Models\Rekreasi;
use App\Models\PendudukUmur;
use App\Models\PendidikanDua;
use App\Imports\PendudukUmurImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\InflasiPemeliharaRT;
use App\Models\Inflasi;


use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;

class DashboardController extends Controller
{
    public function index()
    {
        // ✅ Statistik utama dari tabel Penduduk
        $totalPenduduk = Penduduk::sum('jumlah_penduduk');
        $totalLaki = Penduduk::sum('laki_laki');
        $totalPerempuan = Penduduk::sum('perempuan');
        $totalKecamatan = Penduduk::distinct('kecamatan')->count('kecamatan');
        $totalTenagaKerja = TenagaKerja::sum('jumlah');
        $totalIPG = IPG::avg('pengeluaran_Pria') + IPG::sum('pengeluaran_Wanita');
         // Menghitung rata-rata Gini Rasio 
        $rataGiniRasio = GiniRasMis::avg('jumlah');
        $rataPakaian = InflasiPakaian::avg('jumlah');
        $totalTenagaKerjaDua = TenagaKerjaDua::sum('jumlah');
        // ✅ Statistik dari tabel Kemiskinan
        $totalPendudukMiskin = Kemiskinan::sum('jumlah_penduduk_miskin');
        $rataPersentaseKemiskinan = Kemiskinan::avg('persentase_penduduk_miskin');
        $rataGarisKemiskinan = Kemiskinan::avg('garis_kemiskinan');
        $rataIndeksKedalaman = Kemiskinan::avg('indeks_kedalaman_kemiskinan');
        $rataIndeksKeparahan = Kemiskinan::avg('indeks_keparahan_kemiskinan');

        // ✅ Data per tahun untuk grafik kemiskinan
        $dataKemiskinan = Kemiskinan::selectRaw('tahun, SUM(jumlah_penduduk_miskin) as total_miskin, AVG(persentase_penduduk_miskin) as persentase')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        $labelsKemiskinan = $dataKemiskinan->pluck('tahun');
        $dataJumlahMiskin = $dataKemiskinan->pluck('total_miskin');
        $dataPersentaseMiskin = $dataKemiskinan->pluck('persentase');

        // ✅ Data tren penduduk (dari tabel penduduk)
        $dataPenduduk = Penduduk::selectRaw('tahun, SUM(jumlah_penduduk) as total_penduduk')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        $labelsPenduduk = $dataPenduduk->pluck('tahun');
        $jumlahPenduduk = $dataPenduduk->pluck('total_penduduk');

        return view('dashboard.index', compact(
            'totalPenduduk',
            'totalLaki',
            'totalPerempuan',
            'totalKecamatan',
            'totalTenagaKerja',
            'rataGiniRasio',
            'totalPendudukMiskin',
            'rataPersentaseKemiskinan',
            'rataGarisKemiskinan',
            'rataIndeksKedalaman',
            'rataIndeksKeparahan',
            'labelsKemiskinan',
            'dataJumlahMiskin',
            'dataPersentaseMiskin',
            'labelsPenduduk',
            'jumlahPenduduk'
        ));
    }

    public function penduduk()
    {
        $data = Penduduk::orderBy('tahun', 'desc')->orderBy('kecamatan')->get();
        return view('dashboard.penduduk', compact('data'));
    }

    public function pendudukUmur(Request $request)
{
    // Daftar tahun yang bisa dipilih
    $tahunList = ['2020','2021', '2022', '2023', '2024'];

    // Ambil tahun dari request atau default ke tahun terakhir di daftar
    $tahun = $request->get('tahun');
    if (!$tahun || !in_array($tahun, $tahunList)) {
        $tahun = end($tahunList);
    }

    $filterUmur = $request->get('umur', []); // filter umur array

    // Ambil data berdasarkan tahun
    $dataUmurQuery = PendudukUmur::where('tahun', $tahun)
        ->select('id', 'umur', 'laki_laki', 'perempuan', 'jumlah');

    $dataUmur = $dataUmurQuery->get()->map(function ($item) {
        return [
            'id'         => $item->id,
            'umur'       => $item->umur,
            'laki_laki'  => $item->laki_laki,
            'perempuan'  => $item->perempuan,
            'jumlah'     => $item->jumlah
        ];
    })->toArray();

    // Fallback: jika data kosong, ambil tahun terakhir yang ada datanya
    if (empty($dataUmur)) {
        $tahunAdaData = PendudukUmur::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->first();

        if ($tahunAdaData) {
            $tahun = $tahunAdaData;
            $dataUmur = PendudukUmur::where('tahun', $tahun)
                ->select('id', 'umur', 'laki_laki', 'perempuan', 'jumlah')
                ->get()
                ->map(function ($item) {
                    return [
                        'id'         => $item->id,
                        'umur'       => $item->umur,
                        'laki_laki'  => $item->laki_laki,
                        'perempuan'  => $item->perempuan,
                        'jumlah'     => $item->jumlah
                    ];
                })
                ->toArray();
        }
    }

    // Filter umur jika ada
    if (!empty($filterUmur) && is_array($filterUmur)) {
        $dataUmur = array_filter($dataUmur, function ($item) use ($filterUmur) {
            return in_array($item['umur'], $filterUmur);
        });
        $dataUmur = array_values($dataUmur); // reset key
    }

    $umurList = [
        '0-4 tahun' => '0-4 tahun',
        '5-9 tahun' => '5-9 tahun',
        '10-14 tahun' => '10-14 tahun',
        '15-19 tahun' => '15-19 tahun',
        '20-24 tahun' => '20-24 tahun',
        '25-29 tahun' => '25-29 tahun',
        '30-34 tahun' => '30-34 tahun',
        '35-39 tahun' => '35-39 tahun',
        '40-44 tahun' => '40-44 tahun',
        '45-49 tahun' => '45-49 tahun',
        '50-54 tahun' => '50-54 tahun',
        '55-59 tahun' => '55-59 tahun',
        '60-64 tahun' => '60-64 tahun',
        '65-69 tahun' => '65-69 tahun',
        '70-74 tahun' => '70-74 tahun',
        '75+ tahun'  => '75+ tahun',
    ];

    return view('dashboard.penduduk-umur', compact('dataUmur', 'tahun', 'tahunList', 'umurList', 'filterUmur'));
}


    // Method untuk menambah data umur
    public function tambahDataUmur(Request $request)
    {
        $request->validate([
            'umur' => 'required|string',
            'laki_laki' => 'required|integer|min:0',
            'perempuan' => 'required|integer|min:0',
            'tahun' => 'required|integer'
        ]);

        try {
            // Hitung total
            $total = $request->laki_laki + $request->perempuan;
            
            // Simpan ke database
            PendudukUmur::create([
                'tahun' => $request->tahun,
                 'umur' => $request->umur, // Gunakan field umur untuk menyimpan umur
                'laki_laki' => $request->laki_laki,
                'perempuan' => $request->perempuan,
                'jumlah' => $total
            ]);
            
            return redirect()->route('penduduk.umur', [
                'tahun' => $request->tahun
            ])->with('success', 'Data berhasil ditambahkan!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    // Method untuk edit data umur
    public function editDataUmur(Request $request, $id)
    {
        $request->validate([
            'umur' => 'required|string',
            'laki_laki' => 'required|integer|min:0',
            'perempuan' => 'required|integer|min:0',
            'tahun' => 'required|integer'
        ]);

        try {
            // Hitung total
            $total = $request->laki_laki + $request->perempuan;
            
            // Update data di database
            $penduduk = PendudukUmur::findOrFail($id);
            $penduduk->update([
                'tahun' => $request->tahun,
                'umur' => $request->umur, // Gunakan field kecamatan untuk menyimpan umur
                'laki_laki' => $request->laki_laki,
                'perempuan' => $request->perempuan,
                'jumlah' => $total
            ]);
            
            return redirect()->route('penduduk.umur', [
                'tahun' => $request->tahun
            ])->with('success', 'Data berhasil diperbarui!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    // Method untuk hapus data umur
    public function hapusDataUmur($id)
    {
        try {
            // Hapus data dari database
            $penduduk = PendudukUmur::findOrFail($id);
            $penduduk->delete();
            
            return redirect()->back()->with('success', 'Data berhasil dihapus!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

 

    // Method untuk menambah data kecamatan
  
    public function importPendudukUmur(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xls,xlsx',
        'tahun' => 'required|numeric'
    ]);

    Excel::import(new PendudukUmurImport($request->tahun), $request->file('file'));

    return redirect()->back()->with('success', 'Data penduduk berdasarkan umur berhasil diimpor.');
}
    public function pendudukSejateng(Request $request)
{
    $tahun = $request->get('tahun', date('Y'));
    $filterProvinsi = $request->get('provinsi', []);

    // Ambil data dari database berdasarkan tahun
    $dataSejateng = PendudukJateng::where('tahun', $tahun)
        ->select('id', 'provinsi', 'pria', 'wanita', 'jumlahwarga as total')
        ->get()
        ->map(function($item) {
            return [
                'id' => $item->id,
                'provinsi' => $item->provinsi,
                'pria' => $item->pria,
                'wanita' => $item->wanita,
                'total' => $item->total
            ];
        })
        ->toArray();

    // Filter jika ada provinsi
    if (!empty($filterProvinsi) && is_array($filterProvinsi)) {
        $dataSejateng = array_filter($dataSejateng, function($item) use ($filterProvinsi) {
            return in_array($item['provinsi'], $filterProvinsi);
        });
        $dataSejateng = array_values($dataSejateng);
    }

    $tahunList = ['2020','2021','2022', '2023', '2024'];

    return view('dashboard.penduduk-sejateng', compact('dataSejateng', 'tahun', 'tahunList', 'filterProvinsi'));
}

public function tambahDataSejateng(Request $request)
{
    $request->validate([
        'provinsi' => 'required|string',
        'pria' => 'required|integer|min:0',
        'wanita' => 'required|integer|min:0',
        'tahun' => 'required|integer'
    ]);

    try {
        $total = $request->pria + $request->wanita;

        PendudukJateng::create([
            'tahun' => $request->tahun,
            'provinsi' => $request->provinsi,
            'pria' => $request->pria,
            'wanita' => $request->wanita,
            'jumlahwarga' => $total
        ]);

        return redirect()->route('penduduk.sejateng', [
            'tahun' => $request->tahun
        ])->with('success', 'Data berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
    }
}

public function editDataSejateng(Request $request, $id)
{
    $request->validate([
        'provinsi' => 'required|string',
        'pria' => 'required|integer|min:0',
        'wanita' => 'required|integer|min:0',
        'tahun' => 'required|integer'
    ]);

    try {
        $total = $request->pria + $request->wanita;

        $data = PendudukJateng::findOrFail($id);
        $data->update([
            'tahun' => $request->tahun,
            'provinsi' => $request->provinsi,
            'pria' => $request->pria,
            'wanita' => $request->wanita,
            'jumlahwarga' => $total
        ]);

        return redirect()->route('penduduk.sejateng', [
            'tahun' => $request->tahun
        ])->with('success', 'Data berhasil diperbarui!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
    }
}

public function hapusDataSejateng($id)
{
    try {
        $data = PendudukJateng::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
    }
}


    public function tenagaKerja()
    {
        return view('dashboard.ketenagakerjaan');
    }

    public function ketenagakerjaan(Request $request)
    {   
        $query = Tenagakerja::orderBy('tahun', 'desc');

    if ($request->has('tahun') && $request->tahun != '') {
        $query->where('tahun', $request->tahun);
    }

    $data = $query->get();
        return view('dashboard.tenaga-kerja', compact('data'));
    }

 public function kerja(Request $request)
{
    $request->validate([
        'tahun' => 'required|integer',
        'tpak' => 'required|string',
        'tkk' => 'required|string',
        'tpt' => 'required|string',
        'bekerja_laki_laki' => 'required|integer|min:0',
        'bekerja_perempuan' => 'required|integer|min:0',
        'pengangguran_laki_laki' => 'required|integer|min:0',
        'pengangguran_perempuan' => 'required|integer|min:0',
    ]);

    try {
        // Hitung total jumlah angkatan kerja (bekerja + pengangguran)
        $jumlah = 
            $request->bekerja_laki_laki + 
            $request->bekerja_perempuan + 
            $request->pengangguran_laki_laki + 
            $request->pengangguran_perempuan;

        // Simpan ke database
        Tenagakerja::create([
            'tahun' => $request->tahun,
            'bekerja_laki_laki' => $request->bekerja_laki_laki,
            'bekerja_perempuan' => $request->bekerja_perempuan,
            'pengangguran_laki_laki' => $request->pengangguran_laki_laki,
            'pengangguran_perempuan' => $request->pengangguran_perempuan,
            'tpak' => $request->tpak,
            'tkk' => $request->tkk,
            'tpt' => $request->tpt,
            'jumlah' => $jumlah,
        ]);

        return redirect()->back()->with('success', 'Data tenaga kerja berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menambahkan data tenaga kerja: ' . $e->getMessage());
    }
}


    public function hapusKerja($id)
    {
        try {
            $data = Tenagakerja::findOrFail($id);
            $data->delete();

            return redirect()->back()->with('success', 'Data tenaga kerja berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data tenaga kerja: ' . $e->getMessage());
        }
    }
    

    

    public function ipmidg()
    {
        return view('dashboard.ginimenu');
    }
    public function giniRasio(Request $request)
{
    $query = GiniRasMis::orderBy('tahun', 'desc');

    if ($request->has('tahun') && $request->tahun != '') {
        $query->where('tahun', $request->tahun);
    }

    $data = $query->get();
    return view('dashboard.gini-rasio', compact('data'));
}

  // ➤ Tambah manual
    public function tambahGiniRasio(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'penduduk_miskin' => 'required|integer|min:0',
            'penduduk_miskin_persen' => 'required|numeric|min:0',
            'garis_kemiskinan' => 'required|integer|min:0',
            'gini_rasio' => 'required|numeric|min:0',
        ]);

        try {
            $jumlah = $request->penduduk_miskin + $request->garis_kemiskinan + $request->gini_rasio;

            GiniRasMis::create([
                'tahun' => $request->tahun,
                'penduduk_miskin' => $request->penduduk_miskin,
                'penduduk_miskin_persen' => $request->penduduk_miskin_persen,
                'garis_kemiskinan' => $request->garis_kemiskinan,
                'gini_rasio' => $request->gini_rasio,
                'jumlah' => $jumlah
            ]);

            return redirect()->route('gini-rasio')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal tambah data: ' . $e->getMessage());
        }
    }

    // ➤ Import Excel/CSV
    public function importGiniRasio(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        try {
            // Ambil semua data di sheet pertama
            $data = Excel::toArray([], $request->file('file'))[0];

            foreach ($data as $index => $row) {
                // Skip baris header (baris pertama)
                if ($index === 0) {
                    continue;
                }

                // Pastikan kolom ada (pakai index angka, bukan nama header)
                if (isset($row[0])) {
                    $tahun = $row[0] ?? null;
                    $pendudukMiskin = $row[1] ?? 0;
                    $pendudukMiskinPersen = $row[2] ?? 0;
                    $garisKemiskinan = $row[3] ?? 0;
                    $giniRasio = $row[4] ?? 0;

                    $jumlah = $pendudukMiskin + $garisKemiskinan + $giniRasio;

                    GiniRasMis::create([
                        'tahun' => $tahun,
                        'penduduk_miskin' => $pendudukMiskin,
                        'penduduk_miskin_persen' => $pendudukMiskinPersen,
                        'garis_kemiskinan' => $garisKemiskinan,
                        'gini_rasio' => $giniRasio,
                        'jumlah' => $jumlah
                    ]);
                }
            }

            return redirect()->route('gini-rasio')->with('success', 'Data berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }



 public function tenagakerjadua(Request $request)
    {   
        $query = TenagaKerjaDua::orderBy('tahun', 'desc');          

    if ($request->has('tahun') && $request->tahun != '') {
        $query->where('tahun', $request->tahun);
    }

    $data = $query->get();
        return view('dashboard.tenagakerja-dua', compact('data'));
    }
    
public function tambahTenagaKerjaDua(request $request)
{   
    $request->validate([
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
    ]);
    try {
        // Hitung total jumlah angkatan kerja (bekerja + pengangguran + sekolah + rt + lainnya)
        $jumlah = 
            $request->bekerja_pria + 
            $request->bekerja_wanita + 
            $request->pengangguran_pria + 
            $request->pengangguran_wanita +
            $request->sekolah_pria +
            $request->sekolah_wanita +
            $request->rt_pria +
            $request->rt_wanita +
            $request->lainnya_pria +
            $request->lainnya_wanita;

        // Simpan ke database
        TenagaKerjaDua::create([
            'tahun' => $request->tahun,
            'bekerja_pria' => $request->bekerja_pria,
            'bekerja_wanita' => $request->bekerja_wanita,
            'pengangguran_pria' => $request->pengangguran_pria,
            'pengangguran_wanita' => $request->pengangguran_wanita,
            'sekolah_pria' => $request->sekolah_pria,
            'sekolah_wanita' => $request->sekolah_wanita,
            'rt_pria' => $request->rt_pria,
            'rt_wanita' => $request->rt_wanita,
            'lainnya_pria' => $request->lainnya_pria,
            'lainnya_wanita' => $request->lainnya_wanita,
            'jumlah' => $jumlah
        ]);

        return redirect()->route('tenaga-kerja-dua')->with('success', 'Data tenaga kerja berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menambahkan data tenaga kerja: ' . $e->getMessage());
    }
}

    public function ipm(Request $request)
    {
        $query = IpM::orderBy('tahun', 'desc');

        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        $data = $query->get();
        return view('dashboard.ipm', compact('data'));
    }
    public function tambahIpM(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'UHH' => 'required|numeric|min:0',
            'RLS' => 'required|numeric|min:0',
            'HLS' => 'required|numeric|min:0',
            'Pengeluaran' => 'required|integer|min:0',
            // Hapus validasi 'jumlah' karena tidak diinput oleh user
        ]);

        try {
            // Hitung jumlah sesuai kebutuhanmu, misalnya di sini asumsi "jumlah penduduk = input + logika tertentu"
            $jumlah = $request->UHH + $request->RLS + $request->HLS;
 // 👉 Ganti sesuai kebutuhan logika atau tambahkan input form

            IpM::create([
                'tahun' => $request->tahun,
                'UHH' => $request->UHH,
                'RLS' => $request->RLS,
                'HLS' => $request->HLS,
                'Pengeluaran' => $request->Pengeluaran,
                'jumlah' => $jumlah
            ]);

            return redirect()->route('ipm')->with('success', 'Data IPM berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Jika error terjadi, tampilkan ke user
            return redirect()->back()->with('error', 'Gagal menambahkan data IPM: ' . $e->getMessage());
        }
    }
    public function ipg(Request $request)
    {
        $query = IPG::orderBy('tahun', 'desc');

        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        $data = $query->get();
        return view('dashboard.ipg', compact('data'));
    }   
    public function tambahIpG(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'UHH_Pria' => 'required|numeric|min:0',
            'UHH_Wanita' => 'required|numeric|min:0',
            'RLS_Pria' => 'required|numeric|min:0',
            'RLS_Wanita' => 'required|numeric|min:0',
            'HLS_Pria' => 'required|numeric|min:0',
            'HLS_Wanita' => 'required|numeric|min:0',
            'Pengeluaran_Pria' => 'required|integer|min:0',
            'Pengeluaran_Wanita' => 'required|integer|min:0',
            // Hapus validasi 'jumlah' karena tidak diinput oleh user
        ]);

        try {
            // Hitung jumlah sesuai kebutuhanmu, misalnya di sini asumsi "jumlah penduduk = input + logika tertentu"
            $jumlah = $request->UHH_Pria + $request->UHH_Wanita + 
                      $request->RLS_Pria + $request->RLS_Wanita + 
                      $request->HLS_Pria + $request->HLS_Wanita;

            IPG::create([
                'tahun' => $request->tahun,
                'UHH_Pria' => $request->UHH_Pria,
                'UHH_Wanita' => $request->UHH_Wanita,
                'RLS_Pria' => $request->RLS_Pria,
                'RLS_Wanita' => $request->RLS_Wanita,
                'HLS_Pria' => $request->HLS_Pria,
                'HLS_Wanita' => $request->HLS_Wanita,
                'Pengeluaran_Pria' => $request->Pengeluaran_Pria,
                'Pengeluaran_Wanita' => $request->Pengeluaran_Wanita,
                'jumlah' => $jumlah
            ]);

            return redirect()->route('ipg')->with('success', 'Data IPG berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Jika error terjadi, tampilkan ke user
            return redirect()->back()->with('error', 'Gagal menambahkan data IPG: ' . $e->getMessage());
        }
    }
    public function tambahInflasiMakanan(Request $request)
{
    $request->validate([
        'tahun'    => 'required|integer',
        'bulan'    => 'required|string', // karena simpan string
        'ihk'      => 'required|numeric|min:0',
        'inflasi'  => 'required|numeric|min:0',
        'andil'    => 'required|numeric|min:0',
    ]);

    try {
        $jumlah = $request->ihk + $request->inflasi + $request->andil;

        InflasiMakanan::create([
            'tahun'   => $request->tahun,
            'bulan'   => $request->bulan, // string nama bulan
            'ihk'     => $request->ihk,
            'inflasi' => $request->inflasi,
            'andil'   => $request->andil,
            'jumlah'  => $jumlah,
        ]);

        return redirect()->route('infasisatu')
            ->with('success', 'Data inflasi makanan berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Gagal menambahkan data inflasi makanan: ' . $e->getMessage());
    }
}

public function infasimakanan(Request $request)
{
    $query = InflasiMakanan::orderBy('tahun', 'desc')
                ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') DESC");

    if ($request->filled('tahun')) {
        $query->where('tahun', $request->tahun);
    }

    if ($request->filled('bulan')) {
        // karena string, langsung cocokkan dengan nama bulan
        $query->where('bulan', $request->bulan);
    }

    $data = $query->get();

    return view('dashboard.inflasisatu', compact('data'));
}

public function PakaianInflasi(Request $request)
{
    $query = InflasiPakaian::orderBy('tahun', 'desc')
                ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') DESC");

    if ($request->filled('tahun')) {
        $query->where('tahun', $request->tahun);
    }

    if ($request->filled('bulan')) {
        // karena string, langsung cocokkan dengan nama bulan
        $query->where('bulan', $request->bulan);
    }

    $data = $query->get();

    return view('dashboard.inflasipakaian', compact('data'));
}
public function tambahInflasiPakaian(Request $request)
{
    $request->validate([
        'tahun'    => 'required|integer',
        'bulan'    => 'required|string', // karena simpan string
        'ihk_pakaian'      => 'required|numeric|min:0',
        'inflasi_pakaian'  => 'required|numeric|min:0',
        'andil_pakaian'    => 'required|numeric|min:0',
    ]);

    try {
        $jumlah = $request->ihk_pakaian + $request->inflasi_pakaian + $request->andil_pakaian;

        InflasiPakaian::create([
            'tahun'   => $request->tahun,
            'bulan'   => $request->bulan, // string nama bulan
            'ihk_pakaian'     => $request->ihk_pakaian,
            'inflasi_pakaian' => $request->inflasi_pakaian,
            'andil_pakaian'   => $request->andil_pakaian,
            'jumlah'  => $jumlah,
        ]);

        return redirect()->route('infasipakaian')
            ->with('success', 'Data inflasi pakaian berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Gagal menambahkan data inflasi pakaian: ' . $e->getMessage());
    }

}

public function PPLInflasi(Request $request)
{
    $query = InflasiPPL::orderBy('tahun', 'desc')
                ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') DESC");

    if ($request->filled('tahun')) {
        $query->where('tahun', $request->tahun);
    }

    if ($request->filled('bulan')) {
        // karena string, langsung cocokkan dengan nama bulan
        $query->where('bulan', $request->bulan);
    }

    $data = $query->get();

    return view('dashboard.inflasippl', compact('data'));
}

public function PPLTambahInflasi(Request $request)
{
    $request->validate([
        'tahun'    => 'required|integer',
        'bulan'    => 'required|string', // karena simpan string
        'ihk_ppl'      => 'required|numeric|min:0',
        'inflasi_ppl'  => 'required|numeric|min:0',
        'andil_ppl'    => 'required|numeric|min:0',
    ]);

    try {
        $jumlah = $request->ihk_ppl + $request->inflasi_ppl + $request->andil_ppl;

        InflasiPPL::create([
            'tahun'   => $request->tahun,
            'bulan'   => $request->bulan, // string nama bulan
            'ihk_ppl'     => $request->ihk_ppl,
            'inflasi_ppl' => $request->inflasi_ppl,
            'andil_ppl'   => $request->andil_ppl,
            'jumlah'  => $jumlah,
        ]);

        return redirect()->route('infasippl')
            ->with('success', 'Data inflasi PPL berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Gagal menambahkan data inflasi PPL: ' . $e->getMessage());
    }       
}
public function PemeliharaRT(Request $request)
{
    $query = InflasiPemeliharaRT::orderBy('tahun', 'desc')
                ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') DESC");

    if ($request->filled('tahun')) {
        $query->where('tahun', $request->tahun);
    }

    if ($request->filled('bulan')) {
        // karena string, langsung cocokkan dengan nama bulan
        $query->where('bulan', $request->bulan);
    }

    $data = $query->get();

    return view('dashboard.inflasirt', compact('data'));
}
public function PemeliharaRTTambahInflasi(Request $request)
{
    $request->validate([
        'tahun'    => 'required|integer',
        'bulan'    => 'required|string', // karena simpan string
        'ihk_rt'      => 'required|numeric|min:0',
        'inflasi_rt'  => 'required|numeric|min:0',
        'andil_rt'    => 'required|numeric|min:0',
    ]);

    try {
        $jumlah = $request->ihk_rt + $request->inflasi_rt + $request->andil_rt;

        InflasiPemeliharaRT::create([
            'tahun'   => $request->tahun,
            'bulan'   => $request->bulan, // string nama bulan
            'ihk_rt'     => $request->ihk_rt,
            'inflasi_rt' => $request->inflasi_rt,
            'andil_rt'   => $request->andil_rt,
            'jumlah'  => $jumlah,
        ]);

        return redirect()->route('infasirt')
            ->with('success', 'Data inflasi pemelihara RT berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Gagal menambahkan data inflasi pemelihara RT: ' . $e->getMessage());
    }
}
public function inflasiSehat(Request $request)
{
    $query = PerlengkapanSehat::orderBy('tahun', 'desc')
                ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') DESC");

    if ($request->filled('tahun')) {
        $query->where('tahun', $request->tahun);
    }

    if ($request->filled('bulan')) {
        // karena string, langsung cocokkan dengan nama bulan
        $query->where('bulan', $request->bulan);
    }

    $data = $query->get();

    return view('dashboard.inflasisehat', compact('data'));
}
public function inflasiSehatTambah(Request $request)
{
    $request->validate([
        'tahun'    => 'required|integer',
        'bulan'    => 'required|string', // karena simpan string
        'ihk_kesehatan'      => 'required|numeric|min:0',
        'inflasi_kesehatan'  => 'required|numeric|min:0',
        'andil_kesehatan'    => 'required|numeric|min:0',
    ]);

    try {
        $jumlah = $request->ihk_kesehatan + $request->inflasi_kesehatan + $request->andil_kesehatan;

        PerlengkapanSehat::create([
            'tahun'   => $request->tahun,
            'bulan'   => $request->bulan, // string nama bulan
            'ihk_kesehatan'     => $request->ihk_kesehatan,
            'inflasi_kesehatan' => $request->inflasi_kesehatan,
            'andil_kesehatan'   => $request->andil_kesehatan,
            'jumlah'  => $jumlah,
        ]);

        return redirect()->route('infasisehat')
            ->with('success', 'Data inflasi perlengkapan sehat berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Gagal menambahkan data inflasi perlengkapan sehat: ' . $e->getMessage());
    }
}
public function inflasiSehatTrans(Request $request)
{
    $query = Trans::orderBy('tahun', 'desc')
                ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') DESC");

    if ($request->filled('tahun')) {
        $query->where('tahun', $request->tahun);
    }

    if ($request->filled('bulan')) {
        // karena string, langsung cocokkan dengan nama bulan
        $query->where('bulan', $request->bulan);
    }

    $data = $query->get();

    return view('dashboard.trans', compact('data'));
}
public function inflasiSehatTransTambah(Request $request)
{
    $request->validate([
        'tahun'    => 'required|integer',
        'bulan'    => 'required|string',
        'ihk_trans'      => 'required|numeric|min:0',
        'inflasi_trans'  => 'required|numeric|min:0',
        'andil_trans'    => 'required|numeric|min:0',
    ]);

    try {
        $jumlah = $request->ihk_trans + $request->inflasi_trans + $request->andil_trans;

        Trans::create([
            'tahun'   => $request->tahun,
            'bulan'   => $request->bulan,
            'ihk_trans'     => $request->ihk_trans,
            'inflasi_trans' => $request->inflasi_trans,
            'andil_trans'   => $request->andil_trans,
            'jumlah'        => $jumlah,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
    }
}
public function inflasiInformasi(Request $request)
{
    $query = Informasi::orderBy('tahun', 'desc')
                ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') DESC");

    if ($request->filled('tahun')) {
        $query->where('tahun', $request->tahun);
    }

    if ($request->filled('bulan')) {
        // karena string, langsung cocokkan dengan nama bulan
        $query->where('bulan', $request->bulan);
    }

    $data = $query->get();

    return view('dashboard.informasi', compact('data'));
}
public function inflasiInformasiTambah(Request $request)
{
    $request->validate([
        'tahun'    => 'required|integer',
        'bulan'    => 'required|string',
        'ihk_informasi'      => 'required|numeric|min:0',
        'inflasi_informasi'  => 'required|numeric|min:0',
        'andil_informasi'    => 'required|numeric|min:0',
    ]);

    try {
        $jumlah = $request->ihk_informasi + $request->inflasi_informasi + $request->andil_informasi;

        Informasi::create([
            'tahun'   => $request->tahun,
            'bulan'   => $request->bulan,
            'ihk_informasi'     => $request->ihk_informasi,
            'inflasi_informasi' => $request->inflasi_informasi,
            'andil_informasi'   => $request->andil_informasi,
            'jumlah'  => $jumlah,
        ]);

        return redirect()->back()->with('success', 'Data inflasi informasi berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menambahkan data inflasi informasi: ' . $e->getMessage());
    }
}
public function rekreasi(Request $request)
{
    $query = Rekreasi::orderBy('tahun', 'desc')
                ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') DESC");

    if ($request->filled('tahun')) {
        $query->where('tahun', $request->tahun);
    }

    if ($request->filled('bulan')) {
        // karena string, langsung cocokkan dengan nama bulan
        $query->where('bulan', $request->bulan);
    }

    $data = $query->get();

    return view('dashboard.rekreasi', compact('data'));
}
public function rekreasiTambah(Request $request)
{
    $request->validate([
        'tahun'    => 'required|integer',
        'bulan'    => 'required|string',
        'ihk_rekreasi'      => 'required|numeric|min:0',
        'inflasi_rekreasi'  => 'required|numeric|min:0',
        'andil_rekreasi'    => 'required|numeric|min:0',
    ]);

    try {
        $jumlah = $request->ihk_rekreasi + $request->inflasi_rekreasi + $request->andil_rekreasi;

        Rekreasi::create([
            'tahun'   => $request->tahun,
            'bulan'   => $request->bulan,
            'ihk_rekreasi'     => $request->ihk_rekreasi,
            'inflasi_rekreasi' => $request->inflasi_rekreasi,
            'andil_rekreasi'   => $request->andil_rekreasi,
            'jumlah'  => $jumlah,
        ]);

        return redirect()->back()->with('success', 'Data inflasi rekreasi berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menambahkan data inflasi rekreasi: ' . $e->getMessage());
    }
}
public function createInflasi(Request $request)
{
    $kategoriList = [
        'I. Makanan, minuman dan tembakau',
        'II. Pakaian dan Alas kaki',
        'III. Perumahan, Air, Listrik dan Bahan Bakar Rumah Tangga',
        'IV. Perlengkapan, Peralatan dan Pemeliharaan Rutin Rumah Tangga',
        'V. Kesehatan',
        'VI. Transportasi',
        'VII. Informasi, Komunikasi, dan Jasa Keuangan',
        'VIII. Rekreasi, Olahraga, dan Budaya',
        'IX. Pendidikan',
        'X. Penyediaan Makanan dan Minuman/Restoran',
        'XI. Perawatan Pribadi dan Jasa Lainnya',
    ];

    // Ambil filter dari query string
    $tahun = $request->input('tahun');
    $bulan = $request->input('bulan');

    $inflasiList = Inflasi::query()
        ->when($tahun, fn($q) => $q->where('tahun', $tahun))
        ->when($bulan, fn($q) => $q->where('bulan', $bulan))
        ->orderBy('tahun', 'desc')
        ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni',
                                      'Juli','Agustus','September','Oktober','November','Desember')")
        ->get();

    return view('dashboard.inflasidata', compact('kategoriList', 'inflasiList', 'tahun', 'bulan'));
}

    public function storeInflasi(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'bulan' => 'required|string',
            'kategori' => 'required|array',
            'ihk' => 'required|array',
            'inflasi_komulatif' => 'required|array',
            'andil' => 'required|array',
            
        ]);

        foreach ($request->kategori as $index => $kategori) {
            Inflasi::create([
                'tahun'    => $request->tahun,
                'bulan'    => $request->bulan,
                'kategori' => $kategori,
                'ihk'      => $request->ihk[$index],
                'inflasi_komulatif'  => $request->inflasi_komulatif[$index],
                'andil'    => $request->andil[$index],
                
            ]);
        }

        return redirect()->back()->with('success', 'Data inflasi berhasil disimpan');
    }
    public function inflasiMasuk(Request $request)
{
    $query = Inflasi::orderBy('tahun', 'desc')
                ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') DESC");

    if ($request->filled('tahun')) {
        $query->where('tahun', $request->tahun);
    }

    if ($request->filled('bulan')) {
        // karena string, langsung cocokkan dengan nama bulan
        $query->where('bulan', $request->bulan);
    }

    $data = $query->get();

    return view('dashboard.inflasidata', compact('kategoriList'));
}
public function Pendidikan(Request $request)
{
    // daftar umur untuk form input
    $usiaList = [
        '17-12',
        '13-15',
        '16-18',
        '19-24',
    ];

    $tahun = $request->input('tahun', null);

    // query data pendidikan yang sudah tersimpan
    $query = Pendidikan::orderBy('tahun', 'desc');

    if (!is_null($tahun) && $tahun !== '') {
        $query->where('tahun', $tahun);
    }

    $pendidikanList = $query->get();

    // kirim keduanya ke view
    return view('dashboard.pendidikan', compact('usiaList', 'pendidikanList', 'tahun'));
}

public function PendidikanTambah(Request $request)
{
    $request->validate([
        'tahun' => 'required|integer',
        'usia' => 'required|array',
        'laki' => 'required|array',
        'perempuan' => 'required|array',
    ]);

    foreach ($request->usia as $i => $usia) {
        $laki = $request->laki[$i];
        $perempuan = $request->perempuan[$i];
        $jumlah = $laki + $perempuan;

        Pendidikan::create([
            'tahun' => $request->tahun,
            'usia' => $usia,
            'laki' => $laki,
            'perempuan' => $perempuan,
            'jumlah' => $jumlah
        ]);
    }

    return redirect()->back()->with('success', 'Data pendidikan berhasil ditambahkan!');
}

public function PendidikanDua(Request $request)
{
    // daftar umur untuk form input
    $pendidikanListDuaKali = [
        'SD/Sederajat',
        'SLTP/Sederajat',
        'SLTA/Sederajat',
        'Akademi/Pt',
    ];

    $tahun = $request->input('tahun', null);

    // query data pendidikan yang sudah tersimpan
    $query = PendidikanDua::orderBy('tahun', 'desc');

    if (!is_null($tahun) && $tahun !== '') {
        $query->where('tahun', $tahun);
    }

    $pendidikanListDua = $query->get();

    // kirim keduanya ke view
    return view('dashboard.pendidikandua', compact('pendidikanListDuaKali', 'pendidikanListDua', 'tahun'));
}

public function tambahPendidikanDua(Request $request)
{
    $request->validate([
        'tahun' => 'required|integer',
        'kategori' => 'required|array',
        'apm' => 'required|array',
        'apk' => 'required|array'
    ]);

    foreach ($request->kategori as $i => $kategori){
        $apm = $request->apm[$i];
        $apk = $request->apk[$i];
        $jumlah = $apm + $apk;

        PendidikanDua::create([
            'tahun' => $request->tahun,
            'kategori' => $kategori,
            'apk' => $apk,
            'apm' => $apm,
            'jumlah' => $jumlah
         ]);
    }
     return redirect()->back()->with('success', 'Data pendidikan berhasil ditambahkan!');

}
public function Ekonomi(Request $request)
{
    // daftar umur untuk form input
    $Ekonomi = [
        'Sektor Primer',
        'Sektor Sekunder',
        'Sektor Tersier',
        'PDRB',
    ];

    $tahun = $request->input('tahun', null);

    // query data pendidikan yang sudah tersimpan
    $query = Ekonomi::orderBy('tahun', 'desc');

    if (!is_null($tahun) && $tahun !== '') {
        $query->where('tahun', $tahun);
    }

    $EkonomiSatu = $query->get();

    // kirim keduanya ke view
    return view('dashboard.ekonomitri', compact('Ekonomi', 'EkonomiSatu', 'tahun'));
}
public function tambahEkonomi(Request $request)
{
    $request->validate([
        'tahun' => 'required|integer',
        'kategori' => 'required|array',
        'trisa' => 'required|array',
        'trida' => 'required|array',
        'tri' => 'required|array',
        'trifor' => 'required|array',
        'tahunan' => 'required|array'
    ]);
      foreach ($request->kategori as $i => $kategori){
        $trisa = $request->trisa[$i];
        $trida = $request->trida[$i];
        $tri = $request->tri[$i];
        $trifor = $request->trifor[$i];
        $tahunan = $request->tahunan[$i];
      }
    Ekonomi::create([
        'tahun' => $request->tahun,
        'kategori' => $kategori,
        'trisa' => $trisa,
        'trida' => $trida,
        'tri' => $tri,
        'trifor' => $trifor,
        'tahunan' => $tahunan
    ]);
    return redirect()->back()->with('success', 'Data pendidikan berhasil ditambahkan!');

}

public function EkonomiSE(Request $request)
{
    // daftar umur untuk form input
    $EkonomiSE = [
        'Konsumsi Akhir Rumah Tangga',
        'Konsumsi Akhir Pemerintah',
        'Pembentukan Modal Tetap Bruto',
        'Lainnya',
	    'PDRB',
    ];

    $tahun = $request->input('tahun', null);

    // query data pendidikan yang sudah tersimpan
    $query = EkonomiSE::orderBy('tahun', 'desc');

    if (!is_null($tahun) && $tahun !== '') {
        $query->where('tahun', $tahun);
    }

    $EkonomiSatuE = $query->get();

    // kirim keduanya ke view
    return view('dashboard.ekonomise', compact('EkonomiSE', 'EkonomiSatuE', 'tahun'));
}
public function nambahEkonomi(Request $request)
{
    $request->validate([
        'tahun' => 'required|integer',
        'kategori' => 'required|array',
        'triwulansatu' => 'required|array',
        'triwulandua' => 'required|array',
        'triwulantiga' => 'required|array',
        'triwulanempat' => 'required|array',
        'tahunan' => 'required|array'
    ]);

    foreach ($request->kategori as $i => $kategori) {
        $triwulansatu   = $request->triwulansatu[$i];
        $triwulandua    = $request->triwulandua[$i];
        $triwulantiga   = $request->triwulantiga[$i];
        $triwulanempat  = $request->triwulanempat[$i];
        $tahunan        = $request->tahunan[$i];

        EkonomiSE::create([
            'tahun'         => $request->tahun,
            'kategori'      => $kategori,
            'triwulansatu'  => $triwulansatu,
            'triwulandua'   => $triwulandua,
            'triwulantiga'  => $triwulantiga,
            'triwulanempat' => $triwulanempat,
            'tahunan'       => $tahunan
        ]);
    }

    return redirect()->back()->with('success', 'Data ekonomi berhasil ditambahkan!');
}
public function hapusDataGinRas($id)
    {
        try {
            // Hapus data dari database
            $ginras = GiniRasMis::findOrFail($id);
            $ginras->delete();
            
            return redirect()->back()->with('success', 'Data berhasil dihapus!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

public function IDG(Request $request )
{
    $IDG =[
        'Keterlibatan Perempuan Dalam Parlemen',
        'Perempuan Sebagai Tenaga Profesional',
        'Sumbangan Pendapatan Perempuan',
    ];
    $tahun = $request->input('tahun', null);
    // query data pendidikan yang sudah tersimpan
    $query = NakerJateng::orderBy('tahun', 'desc');
    if (!is_null($tahun) && $tahun !== '') {
        $query->where('tahun', $tahun);
    }
    $IDGSatu = $query->get();
    // kirim keduanya ke view
    return view('dashboard.nakerjateng', compact('IDG', 'IDGSatu', 'tahun'));

}


}