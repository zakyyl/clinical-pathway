<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    public function index()
    {
        // Ambil data pasien + rawat + diagnosa + kamar + rujukan
        $data = DB::table('reg_periksa as r')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->leftJoin('kamar_inap as ki', 'r.no_rawat', '=', 'ki.no_rawat')
            ->leftJoin('kamar as k', 'ki.kd_kamar', '=', 'k.kd_kamar')
            ->leftJoin('diagnosa_pasien as dp', 'r.no_rawat', '=', 'dp.no_rawat')
            ->leftJoin('penyakit as py', 'dp.kd_penyakit', '=', 'py.kd_penyakit')
            ->leftJoin('rujuk_masuk as rm', 'r.no_rawat', '=', 'rm.no_rawat')
            ->select(
                'r.no_rawat',
                'p.no_rkm_medis as no_rm',
                'p.nm_pasien as nama_pasien',
                'p.jk',
                'p.umur as usia',
                'ki.tgl_masuk',
                'ki.tgl_keluar',
                'ki.lama as lama_rawat',
                'py.nm_penyakit as diagnosa_awal',
                'k.kelas',
                'rm.perujuk as rujukan'
            )
            ->groupBy(
                'r.no_rawat', 'p.no_rkm_medis', 'p.nm_pasien', 'p.jk', 'p.umur',
                'ki.tgl_masuk', 'ki.tgl_keluar', 'ki.lama', 'py.nm_penyakit',
                'k.kelas', 'rm.perujuk'
            )
            ->orderByDesc('ki.tgl_masuk')
            ->paginate(20);

        return view('pasien.index', compact('data'));
    }
}
