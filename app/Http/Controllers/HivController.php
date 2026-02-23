<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class HivController extends Controller
{
    public function index()
    {
        $pasien = DB::table('hiv_clinical_pathways as h')
            ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->select(
                'h.no_rawat',
                'p.no_rkm_medis as no_rm',
                'p.nm_pasien as nama_pasien',
                'h.created_at'
            )
            ->orderByDesc('h.created_at')
            ->paginate(50);

        return view('hiv.index', compact('pasien'));
    }

    public function create(Request $request)
    {
        $no_rawat = $request->query('no_rawat');

        if (!$no_rawat) {
            return view('hiv.create', ['data' => null]);
        }

        $data = $this->getPatient($no_rawat);

        if (!$data) {
            return back()->with('error', 'Data pasien tidak ditemukan.');
        }

        $dokter = $this->getDokterList();
        $petugas = $this->getPetugasList();

        return view('hiv.create', compact('data', 'dokter', 'petugas'));
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

        DB::table('hiv_clinical_pathways')->insert([
            'no_rawat' => $request->no_rawat,
            'hari_penyakit_ke' => implode(',', $request->hari_penyakit_ke),
            'hari_rawat_ke' => implode(',', $request->hari_rawat_ke),
            'dokter_igd' => $request->has('dokter_igd') ? 1 : 0,
            'dokter_spesialis' => $request->has('dokter_spesialis') ? 1 : 0,
            'perawatan_primer' => $request->has('perawatan_primer') ? 1 : 0,
            'darah_rutin' => $request->has('darah_rutin') ? 1 : 0,
            'immunoassay_antibody' => $request->has('immunoassay_antibody') ? 1 : 0,
            'rontgen_thorax' => $request->has('rontgen_thorax') ? 1 : 0,
            'ekg' => $request->has('ekg') ? 1 : 0,
            'konsultasi' => $request->has('konsultasi') ? 1 : 0,
            'dokter_dpjp' => $request->has('dokter_dpjp') ? 1 : 0,
            'dokter_nondpjp' => $request->has('dokter_nondpjp') ? 1 : 0,
            'perawat_penanggung_jawab' => $request->has('perawat_penanggung_jawab') ? 1 : 0,
            'tenaga_gizi' => $request->has('tenaga_gizi') ? 1 : 0,
            'telaah_resep' => $request->has('telaah_resep') ? 1 : 0,
            'rekonsiliasi_obat' => $request->has('rekonsiliasi_obat') ? 1 : 0,
            'kode_00132' => $request->has('kode_00132') ? 1 : 0,
            'kode_00142' => $request->has('kode_00142') ? 1 : 0,
            'kode_00085' => $request->has('kode_00085') ? 1 : 0,
            'kode_00094' => $request->has('kode_00094') ? 1 : 0,
            'perubahan_nilai_lab_gizi' => $request->has('perubahan_nilai_lab_gizi') ? 1 : 0,
            'kurang_tau_gizi' => $request->has('kurang_tau_gizi') ? 1 : 0,
            'kebutuhan_asupan_gizi' => $request->kebutuhan_asupan_gizi ?? 0,
            'jadwal_kontrol' => $request->jadwal_kontrol ?? 0,
            'identifikasi_kebutuhan_di_rumah' => $request->has('identifikasi_kebutuhan_di_rumah') ? 1 : 0,
            'identifikasi_alat_pendukung_mobilisasi' => $request->has('identifikasi_alat_pendukung_mobilisasi') ? 1 : 0,
            'program_rehab_medik' => $request->program_rehab_medik ?? 0,
            'informasi_pemberian_obat_dirumah' => $request->has('informasi_pemberian_obat_dirumah') ? 1 : 0,
            'penjelasan_diagnosis' => $request->penjelasan_diagnosis ?? 0,
            'rencana_terapi' => $request->has('rencana_terapi') ? 1 : 0,
            'informed_consent' => $request->informed_consent ?? 0,
            'asesment_ulang_dpjp' => $request->asesment_ulang_dpjp ?? 0,
            'kurangi_karbohidrat' => $request->has('kurangi_karbohidrat') ? 1 : 0,
            'jangan_tunda_makan' => $request->has('jangan_tunda_makan') ? 1 : 0,
            'olahraga_rutin' => $request->olahraga_rutin ?? 0,
            'jaga_kebersihan' => $request->has('jaga_kebersihan') ? 1 : 0,
            'konsumsi_serat' => $request->has('konsumsi_serat') ? 1 : 0,
            'informasi_obat' => $request->has('informasi_obat') ? 1 : 0,
            'konseling_obat' => $request->has('konseling_obat') ? 1 : 0,
            'lembar_edukasi_terintegrasi' => $request->has('lembar_edukasi_terintegrasi') ? 1 : 0,
            'antibiotik_cefriaxone' => $request->antibiotik_cefriaxone ?? 0,
            'ranitidine' => $request->has('ranitidine') ? 1 : 0,
            'analgesik' => $request->has('analgesik') ? 1 : 0,
            'rl_1000_1500_cc' => $request->rl_1000_1500_cc ?? 0,
            'azt_3tc_nvp' => $request->has('azt_3tc_nvp') ? 1 : 0,
            'azt_3tc_efv' => $request->has('azt_3tc_efv') ? 1 : 0,
            'tdf_ftc_nvp' => $request->has('tdf_ftc_nvp') ? 1 : 0,
            'tdf_ftc_efc' => $request->has('tdf_ftc_efc') ? 1 : 0,
            'arv_ditentukan' => $request->arv_ditentukan ?? 0,
            'analgesic' => $request->has('analgesic') ? 1 : 0,
            'obat_tambahan' => $request->has('obat_tambahan') ? 1 : 0,
            'kateter_urine' => $request->has('kateter_urine') ? 1 : 0,
            'nic_413' => $request->nic_413 ?? 0,
            'nic_4190' => $request->has('nic_4190') ? 1 : 0,
            'nic_431' => $request->nic_431 ?? 0,
            'nic_1400' => $request->has('nic_1400') ? 1 : 0,
            'nic_0580' => $request->has('nic_0580') ? 1 : 0,
            'nic_2314' => $request->has('nic_2314') ? 1 : 0,
            'nic_2304' => $request->has('nic_2304') ? 1 : 0,
            'diet_cair' => $request->has('diet_cair') ? 1 : 0,
            'rekom_ke_dpjp' => $request->has('rekom_ke_dpjp') ? 1 : 0,
            'assesmen_ulang' => $request->assesmen_ulang ?? 0,
            'monitor_ttv' => $request->has('monitor_ttv') ? 1 : 0,
            'monitor_nyeri' => $request->monitor_nyeri ?? 0,
            'monitoring_kemampuan_mobilisasi' => $request->monitoring_kemampuan_mobilisasi ?? 0,
            'monitoring_asupan_makan' => $request->has('monitoring_asupan_makan') ? 1 : 0,
            'monitoring_biokimia' => $request->has('monitoring_biokimia') ? 1 : 0,
            'monitoring_fisik' => $request->has('monitoring_fisik') ? 1 : 0,
            'monitoring_interaksi_obat' => $request->has('monitoring_interaksi_obat') ? 1 : 0,
            'monitoring_efek_samping_obat' => $request->monitoring_efek_samping_obat ?? 0,
            'pemantauan_terapi_obat' => $request->has('pemantauan_terapi_obat') ? 1 : 0,
            'medis_dibantu_mandiri' => $request->has('medis_dibantu_mandiri') ? 1 : 0,
            'keperawatan_dibantu_mandiri' => $request->has('keperawatan_dibantu_mandiri') ? 1 : 0,
            'fisioterapi_dibantu_mandiri' => $request->has('fisioterapi_dibantu_mandiri') ? 1 : 0,
            'mobilisasi_mandiri' => $request->has('mobilisasi_mandiri') ? 1 : 0,
            'ttv_stabil' => $request->ttv_stabil ?? 0,
            'kemampuan_mobilisasi' => $request->kemampuan_mobilisasi ?? 0,
            'asupan_makanan' => $request->has('asupan_makanan') ? 1 : 0,
            'status_gizi_optimal' => $request->has('status_gizi_optimal') ? 1 : 0,
            'terapi_obat_sesuai_indikasi' => $request->terapi_obat_sesuai_indikasi ?? 0,
            'obat_rasional' => $request->obat_rasional ?? 0,
            'resume_medis' => $request->has('resume_medis') ? 1 : 0,
            'penjelasan_keadaan_umum' => $request->has('penjelasan_keadaan_umum') ? 1 : 0,
            'surat_pengantar_control' => $request->surat_pengantar_control ?? 0,
            'kriteria_pulang' => $request->kriteria_pulang,
            'varian' => $request->varian,
            'kd_dokter' => $request->kd_dokter,
            'id_petugas' => $request->id_petugas,

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('hiv.index')->with('success', 'Data berhasil disimpan.');
    }

    public function destroy($id)
    {
        try {
            $deleted = DB::table('hiv_clinical_pathways')
                ->where('id', $id)
                ->delete();

            if ($deleted) {
                return redirect()
                    ->route('hiv.index')
                    ->with('success', 'Data berhasil dihapus.');
            }

            return redirect()
                ->route('hiv.index')
                ->with('error', 'Data tidak ditemukan.');

        } catch (\Exception $e) {
            return redirect()
                ->route('hiv.index')
                ->with('error', 'Gagal menghapus data.');
        }
    }

    // public function destroy(Request $request)
    // {
    //     $no_rawat = $request->no_rawat;

    //     try {
    //         $deleted = DB::table('dm_clinical_pathways')
    //             ->where('no_rawat', $no_rawat)
    //             ->delete();

    //         if ($deleted) {
    //             return redirect()
    //                 ->route('dm.index')
    //                 ->with('success', 'Data berhasil dihapus.');
    //         }

    //         return redirect()
    //             ->route('dm.index')
    //             ->with('error', 'Data tidak ditemukan.');
    //     } catch (\Exception $e) {

    //         return redirect()
    //             ->route('dm.index')
    //             ->with('error', 'Gagal menghapus data.');
    //     }
    // }

    public function getPatient($no_rawat)
    {
        return $this->queryPasien()
            ->where('r.no_rawat', $no_rawat)
            ->first();
    }

    private function queryPasien()
    {
        return DB::table('reg_periksa as r')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')

            // ✅ Ambil kamar_inap terakhir saja (bukan semua)
            ->leftJoin(DB::raw('
            (SELECT ki1.* 
             FROM kamar_inap ki1
             INNER JOIN (
                 SELECT no_rawat, MAX(tgl_masuk) as max_tgl
                 FROM kamar_inap
                 GROUP BY no_rawat
             ) ki2 ON ki1.no_rawat = ki2.no_rawat 
                  AND ki1.tgl_masuk = ki2.max_tgl
            ) as ki
        '), 'r.no_rawat', '=', 'ki.no_rawat')

            ->leftJoin('kamar as k', 'ki.kd_kamar', '=', 'k.kd_kamar')

            // ✅ Ambil diagnosa pertama saja
            ->leftJoin(DB::raw('
            (SELECT dp1.*
             FROM diagnosa_pasien dp1
             INNER JOIN (
                 SELECT no_rawat, MIN(prioritas) as min_prioritas
                 FROM diagnosa_pasien
                 GROUP BY no_rawat
             ) dp2 ON dp1.no_rawat = dp2.no_rawat 
                  AND dp1.prioritas = dp2.min_prioritas
            ) as dp
        '), 'r.no_rawat', '=', 'dp.no_rawat')

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
                'k.kd_kamar',
                'rm.perujuk as rujukan'
            );
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

    private function getDokterList()
    {
        return DB::table('dokter')
            ->select('kd_dokter', 'nm_dokter')
            ->orderBy('nm_dokter')
            ->get();
    }

    private function getPetugasList()
    {
        return DB::table('pegawai')
            ->select('id', 'nama')
            ->orderBy('nama')
            ->get();
    }

    // public function show($no_rawat)
    // {
    //     $no_rawat = urldecode($no_rawat);

    //     $data = DB::table('hiv_clinical_pathways as h')

    //         ->leftJoin('dokter as d', 'h.kd_dokter', '=', 'd.kd_dokter')
    //         ->leftJoin('pegawai as pg', 'h.id_petugas', '=', 'pg.id')

    //         ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
    //         ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')

    //         ->select(
    //             'h.*',

    //             'p.no_rkm_medis as no_rm',
    //             'p.nm_pasien as nm_pasien',
    //             'p.jk',
    //             'p.umur',

    //             'd.nm_dokter',
    //             'pg.nama as nama_petugas',

    //             'r.tgl_registrasi',
    //             'h.created_at'
    //         )

    //         ->where('h.no_rawat', $no_rawat)
    //         ->first();

    //     if (!$data) {
    //         return redirect()
    //             ->route('hiv.index')
    //             ->with('error', 'Data tidak ditemukan');
    //     }

    //     // potong umur
    //     preg_match('/\d+\s*Th/', $data->umur, $matches);
    //     $data->umur_tahun = $matches[0] ?? $data->umur;

    //     return view('hiv.show', compact('data'));
    // }

    public function show($no_rawat)
    {
        $no_rawat = urldecode($no_rawat);

        $data = DB::table('hiv_clinical_pathways as h')

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
            return redirect()
                ->route('hiv.index')
                ->with('error', 'Data tidak ditemukan');
        }

        // potong umur
        preg_match('/\d+\s*Th/', $data->umur, $matches);
        $data->umur_tahun = $matches[0] ?? $data->umur;

        return view('hiv.show', compact('data'));
    }

    public function exportPdf($no_rawat)
    {
        $no_rawat = urldecode($no_rawat);

        $data = DB::table('hiv_clinical_pathways as h')
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
            return redirect()
                ->route('hiv.index')
                ->with('error', 'Data tidak ditemukan');
        }

        if (isset($data->umur)) {
            preg_match('/\d+\s*Th/', $data->umur, $matches);
            $data->umur_tahun = $matches[0] ?? $data->umur;
        } else {
            $data->umur_tahun = '-';
        }

        $logoPath = public_path('image/logorsb.jpg');
        $logoBase64 = '';

        if (file_exists($logoPath)) {
            $imageData = file_get_contents($logoPath);
            $base64 = base64_encode($imageData);
            $logoBase64 = 'data:image/jpeg;base64,' . $base64;
        }

        $pdf = Pdf::loadView('hiv.pdf', [
            'data' => $data,
            'logoBase64' => $logoBase64  
        ])
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        $fileName = 'HIV_Clinical_Pathway_' . str_replace('/', '_', $no_rawat) . '_' . date('Ymd_His') . '.pdf';

        return $pdf->download($fileName);
    }


    /**
     * PRIVATE FUNCTION: ambil detail pasien
     */
    // private function getPatient($no_rawat)
    // {
    //     return DB::table('reg_periksa as r')
    //         ->join('pasien as p', 'p.no_rkm_medis', '=', 'r.no_rkm_medis')
    //         ->select(
    //             'r.no_rawat',
    //             'p.nm_pasien as nama_pasien',
    //             'p.jk',
    //             DB::raw('TIMESTAMPDIFF(YEAR, p.tgl_lahir, CURDATE()) as usia'),
    //             'r.tgl_registrasi as tgl_masuk',
    //             'r.tgl_keluar',
    //             DB::raw('DATEDIFF(r.tgl_keluar, r.tgl_registrasi) as lama_rawat'),
    //             'r.kd_kamar',
    //             'r.diagnosa_awal',
    //             'r.rujukan'
    //         )
    //         ->where('r.no_rawat', $no_rawat)
    //         ->first();
    // }


        // public function exportPdf($no_rawat)
    // {
    //     $no_rawat = urldecode($no_rawat);

    //     $data = DB::table('hiv_clinical_pathways as h')
    //         ->leftJoin('dokter as d', 'h.kd_dokter', '=', 'd.kd_dokter')
    //         ->leftJoin('pegawai as pg', 'h.id_petugas', '=', 'pg.id')
    //         ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
    //         ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
    //         ->select(
    //             'h.*',
    //             'p.no_rkm_medis as no_rm',
    //             'p.nm_pasien as nm_pasien',
    //             'p.jk',
    //             'p.umur',
    //             'd.nm_dokter',
    //             'pg.nama as nama_petugas',
    //             'r.tgl_registrasi',
    //             'h.created_at'
    //         )
    //         ->where('h.no_rawat', $no_rawat)
    //         ->first();

    //     if (!$data) {
    //         return redirect()
    //             ->route('hiv.index')
    //             ->with('error', 'Data tidak ditemukan');
    //     }

    //     // Potong umur
    //     preg_match('/\d+\s*Th/', $data->umur, $matches);
    //     $data->umur_tahun = $matches[0] ?? $data->umur;

    //     // Generate PDF
    //     $pdf = Pdf::loadView('hiv.pdf', compact('data'))
    //         ->setPaper('a4', 'portrait')
    //         ->setOptions([
    //             'isHtml5ParserEnabled' => true,
    //             'isRemoteEnabled' => true,
    //             'defaultFont' => 'sans-serif',
    //             'enable_php' => true
    //         ]);

    //     // Download dengan nama file yang jelas
    //     $fileName = 'HIV_Clinical_Pathway_' . str_replace('/', '_', $no_rawat) . '_' . date('Ymd_His') . '.pdf';

    //     return $pdf->download($fileName);
    // }
}
