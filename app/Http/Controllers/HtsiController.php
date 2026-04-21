<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class HtsiController extends Controller
{
    public function index()
    {
        $pasien = DB::table('htsi_clinical_pathways as h')
            ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->select(
                'h.id',
                'h.no_rawat',
                'p.no_rkm_medis as no_rm',
                'p.nm_pasien as nama_pasien',
                'h.created_at'
            )
            ->orderByDesc('h.created_at')
            ->paginate(50);

        return view('htsi.index', compact('pasien'));
    }

    public function create(Request $request)
    {
        $no_rawat = $request->query('no_rawat');

        if (!$no_rawat) {
            return view('htsi.create', ['data' => null]);
        }

        $data = $this->getPatient($no_rawat);

        if (!$data) {
            return back()->with('error', 'Data pasien tidak ditemukan.');
        }

        $dokter = $this->getDokterList();
        $petugas = $this->getPetugasList();

        return view('htsi.create', compact('data', 'dokter', 'petugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_rawat' => 'required',
            'hari_penyakit_ke' => 'required|array',
            'hari_rawat_ke' => 'required|array',
            'kd_dokter' => 'required',
            'id_petugas' => 'required',
        ]);

        DB::table('htsi_clinical_pathways')->insert([
            'no_rawat' => $request->no_rawat,
            'hari_penyakit_ke' => implode(',', $request->hari_penyakit_ke),
            'hari_rawat_ke' => implode(',', $request->hari_rawat_ke),

            // 1. Asesmen
            '1a_dokter_igd' => $request->has('1a_dokter_igd') ? 1 : 0,
            '1a_dokter_spesialis' => $request->has('1a_dokter_spesialis') ? 1 : 0,
            '1b_perawatan_primer' => $request->has('1b_perawatan_primer') ? 1 : 0,

            // 2. Lab
            '2_pemeriksaan_darah_rutin' => $request->has('2_pemeriksaan_darah_rutin') ? 1 : 0,
            '2_profil_lipid' => $request->has('2_profil_lipid') ? 1 : 0,
            '2_fungsi_ginjal_ur_cr' => $request->has('2_fungsi_ginjal_ur_cr') ? 1 : 0,
            '2_gula_darah' => $request->has('2_gula_darah') ? 1 : 0,
            '2_urinalisis' => $request->has('2_urinalisis') ? 1 : 0,

            // 3. Penunjang
            '3_ekg' => $request->has('3_ekg') ? 1 : 0,
            '3_rontgen_thorax' => $request->has('3_rontgen_thorax') ? 1 : 0,

            // 4. Konsultasi
            '4_konsultasi_spesialis' => $request->has('4_konsultasi_spesialis') ? 1 : 0,

            // 5. Pelaksana
            '5a_dokter_dpjp' => $request->has('5a_dokter_dpjp') ? 1 : 0,
            '5a_dokter_nondpjp' => $request->has('5a_dokter_nondpjp') ? 1 : 0,
            '5b_perawat_pj' => $request->has('5b_perawat_pj') ? 1 : 0,
            '5c_tenaga_gizi' => $request->has('5c_tenaga_gizi') ? 1 : 0,
            '5d_telaah_resep' => $request->has('5d_telaah_resep') ? 1 : 0,
            '5d_rekonsiliasi_obat' => $request->has('5d_rekonsiliasi_obat') ? 1 : 0,

            // 6. Diagnosa
            '6a_risiko_penurunan_curah_jantung' => $request->has('6a_risiko_penurunan_curah_jantung') ? 1 : 0,
            '6b_nyeri_akut_sakit_kepala' => $request->has('6b_nyeri_akut_sakit_kepala') ? 1 : 0,
            '6c_defisit_pengetahuan' => $request->has('6c_defisit_pengetahuan') ? 1 : 0,

            // 7. Keselamatan
            '7_identifikasi_pasien' => $request->has('7_identifikasi_pasien') ? 1 : 0,
            '7_risiko_jatuh' => $request->has('7_risiko_jatuh') ? 1 : 0,
            '7_hand_hygiene' => $request->has('7_hand_hygiene') ? 1 : 0,
            '7_kebersihan_lingkungan' => $request->has('7_kebersihan_lingkungan') ? 1 : 0,

            // 8. Edukasi
            '8a_penjelasan_diagnosis' => $request->has('8a_penjelasan_diagnosis') ? 1 : 0,
            '8a_rencana_terapi' => $request->has('8a_rencana_terapi') ? 1 : 0,
            '8a_informed_consent' => $request->has('8a_informed_consent') ? 1 : 0,
            '8b_diet_rendah_garam_dash' => $request->has('8b_diet_rendah_garam_dash') ? 1 : 0,
            '8c_aktivitas_fisik' => $request->has('8c_aktivitas_fisik') ? 1 : 0,
            '8d_informasi_obat' => $request->has('8d_informasi_obat') ? 1 : 0,
            '8e_lembar_edukasi' => $request->has('8e_lembar_edukasi') ? 1 : 0,

            // 9. Terapi
            '9a_antihipertensi_oral' => $request->has('9a_antihipertensi_oral') ? 1 : 0,
            '9b_terapi_parenteral' => $request->has('9b_terapi_parenteral') ? 1 : 0,
            '9c_analgetik' => $request->has('9c_analgetik') ? 1 : 0,

            // 10. Monitoring
            '10a_monitoring_tekanan_darah' => $request->has('10a_monitoring_tekanan_darah') ? 1 : 0,
            '10b_posisi_semi_fowler' => $request->has('10b_posisi_semi_fowler') ? 1 : 0,
            '10c_diet_rendah_natrium' => $request->has('10c_diet_rendah_natrium') ? 1 : 0,
            '10d_rekom_dpjp' => $request->has('10d_rekom_dpjp') ? 1 : 0,

            // 11. Implementasi
            '11a_monitoring_efek_samping_obat' => $request->has('11a_monitoring_efek_samping_obat') ? 1 : 0,
            '11b_evaluasi_target_tekanan_darah' => $request->has('11b_evaluasi_target_tekanan_darah') ? 1 : 0,
            '11c_asupan_makanan' => $request->has('11c_asupan_makanan') ? 1 : 0,
            '11d_interaksi_obat' => $request->has('11d_interaksi_obat') ? 1 : 0,

            // 12. Aktivitas
            '12a_dibantu' => $request->has('12a_dibantu') ? 1 : 0,
            '12b_mandiri' => $request->has('12b_mandiri') ? 1 : 0,

            // 13. Outcome
            '13a_tekanan_darah_terkontrol' => $request->has('13a_tekanan_darah_terkontrol') ? 1 : 0,
            '13b_sakit_kepala_hilang' => $request->has('13b_sakit_kepala_hilang') ? 1 : 0,
            '13c_kepatuhan_diet' => $request->has('13c_kepatuhan_diet') ? 1 : 0,
            '13d_obat_rasional' => $request->has('13d_obat_rasional') ? 1 : 0,

            // 14. Kriteria Pulang
            '14_kondisi_stabil' => $request->has('14_kondisi_stabil') ? 1 : 0,
            '14_edukasi_home_care' => $request->has('14_edukasi_home_care') ? 1 : 0,

            // 15. Rencana Pulang
            '15_resume_medis' => $request->has('15_resume_medis') ? 1 : 0,
            '15_surat_kontrol' => $request->has('15_surat_kontrol') ? 1 : 0,

            // 16. Varian & Meta
            '16_varian_kejadian' => $request->varian,
            'kd_dokter' => $request->kd_dokter,
            'id_petugas' => $request->id_petugas,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('htsi.index')->with('success', 'Data Clinical Pathway Hipertensi berhasil disimpan.');
    }

    public function show($no_rawat)
    {
        $no_rawat = urldecode($no_rawat);

        $data = DB::table('htsi_clinical_pathways as h')
            ->leftJoin('dokter as d', 'h.kd_dokter', '=', 'd.kd_dokter')
            ->leftJoin('pegawai as pg', 'h.id_petugas', '=', 'pg.id')
            ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->select(
                'h.*',
                'p.no_rkm_medis as no_rm',
                'p.nm_pasien as nm_pasien',
                'p.jk',
                'p.umur',
                'd.nm_dokter',
                'pg.nama as nama_petugas',
                'r.tgl_registrasi',
                'h.created_at'
            )
            ->where('h.no_rawat', $no_rawat)
            ->first();

        if (!$data) {
            return redirect()->route('htsi.index')->with('error', 'Data tidak ditemukan');
        }

        preg_match('/\d+\s*Th/', $data->umur, $matches);
        $data->umur_tahun = $matches[0] ?? $data->umur;

        return view('htsi.show', compact('data'));
    }

    public function destroy($id)
    {
        try {
            $deleted = DB::table('htsi_clinical_pathways')->where('id', $id)->delete();
            if ($deleted) {
                return redirect()->route('htsi.index')->with('success', 'Data berhasil dihapus.');
            }
            return redirect()->route('htsi.index')->with('error', 'Data tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->route('htsi.index')->with('error', 'Gagal menghapus data.');
        }
    }

    // Helper Functions (Sama dengan Dyps)
    public function getPatient($no_rawat)
    {
        return $this->queryPasien()->where('r.no_rawat', $no_rawat)->first();
    }

    private function queryPasien()
    {
        return DB::table('reg_periksa as r')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->leftJoin(DB::raw('(SELECT ki1.* FROM kamar_inap ki1 INNER JOIN (SELECT no_rawat, MAX(tgl_masuk) as max_tgl FROM kamar_inap GROUP BY no_rawat) ki2 ON ki1.no_rawat = ki2.no_rawat AND ki1.tgl_masuk = ki2.max_tgl) as ki'), 'r.no_rawat', '=', 'ki.no_rawat')
            ->leftJoin('kamar as k', 'ki.kd_kamar', '=', 'k.kd_kamar')
            ->leftJoin(DB::raw('(SELECT dp1.* FROM diagnosa_pasien dp1 INNER JOIN (SELECT no_rawat, MIN(prioritas) as min_prioritas FROM diagnosa_pasien GROUP BY no_rawat) dp2 ON dp1.no_rawat = dp2.no_rawat AND dp1.prioritas = dp2.min_prioritas) as dp'), 'r.no_rawat', '=', 'dp.no_rawat')
            ->leftJoin('penyakit as py', 'dp.kd_penyakit', '=', 'py.kd_penyakit')
            ->leftJoin('rujuk_masuk as rm', 'r.no_rawat', '=', 'rm.no_rawat')
            ->select('r.no_rawat', 'p.no_rkm_medis as no_rm', 'p.nm_pasien as nama_pasien', 'p.jk', 'p.umur as usia', 'ki.tgl_masuk', 'ki.tgl_keluar', 'ki.lama as lama_rawat', 'py.nm_penyakit as diagnosa_awal', 'k.kelas', 'k.kd_kamar', 'rm.perujuk as rujukan');
    }

    public function findPatient(Request $request)
    {
        $no_rm = $request->input('no_rm');
        if (strlen($no_rm) < 3) {
            return response()->json([
                'data' => [],
                'message' => 'Masukkan minimal 3 karakter'
            ]);
        }

        $data = DB::table('reg_periksa as r')
            ->join('pasien as p', 'p.no_rkm_medis', '=', 'r.no_rkm_medis')
            ->where('p.no_rkm_medis', 'LIKE', "$no_rm%")
            ->select(
                'r.no_rawat',
                'p.no_rkm_medis as no_rm',
                'p.nm_pasien as nama_pasien',
                'r.tgl_registrasi'
            )
            ->orderBy('r.tgl_registrasi', 'desc')
            ->limit(20)
            ->get();

        return response()->json(['data' => $data]);
    }

    private function getDokterList() { return DB::table('dokter')->select('kd_dokter', 'nm_dokter')->orderBy('nm_dokter')->get(); }
    private function getPetugasList() { return DB::table('pegawai')->select('id', 'nama')->orderBy('nama')->get(); }

    public function exportPdf($no_rawat)
    {
        $no_rawat = urldecode($no_rawat);
        $data = DB::table('htsi_clinical_pathways as h')
            ->leftJoin('dokter as d', 'h.kd_dokter', '=', 'd.kd_dokter')
            ->leftJoin('pegawai as pg', 'h.id_petugas', '=', 'pg.id')
            ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->select('h.*', 'p.no_rkm_medis as no_rm', 'p.nm_pasien as nm_pasien', 'p.jk', 'p.umur', 'd.nm_dokter', 'pg.nama as nama_petugas', 'r.tgl_registrasi', 'h.created_at')
            ->where('h.no_rawat', $no_rawat)
            ->first();

        if (!$data) return redirect()->route('htsi.index')->with('error', 'Data tidak ditemukan');

        preg_match('/\d+\s*Th/', $data->umur, $matches);
        $data->umur_tahun = $matches[0] ?? $data->umur;

        $logoPath = public_path('image/logorsb.jpg');
        $logoBase64 = file_exists($logoPath) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath)) : '';

        $pdf = Pdf::loadView('htsi.pdf', compact('data', 'logoBase64'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'defaultFont' => 'sans-serif']);

        return $pdf->download('Hipertensi_CP_' . str_replace('/', '_', $no_rawat) . '.pdf');
    }
}
