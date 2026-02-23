<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class BphController extends Controller
{

    public function index()
    {
        $pasien = DB::table('bph_clinical_pathways as h')
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

        return view('bph.index', compact('pasien'));
    }

    public function create(Request $request)
    {
        $no_rawat = $request->query('no_rawat');

        if (!$no_rawat) {
            return view('bph.create', ['data' => null]);
        }

        $data = $this->getPatient($no_rawat);

        if (!$data) {
            return back()->with('error', 'Data pasien tidak ditemukan.');
        }

        $dokter = $this->getDokterList();
        $petugas = $this->getPetugasList();

        return view('bph.create', compact('data', 'dokter', 'petugas'));
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

        DB::table('bph_clinical_pathways')->insert([
            'no_rawat' => $request->no_rawat,
            'hari_penyakit_ke' => implode(',', $request->hari_penyakit_ke),
            'hari_rawat_ke' => implode(',', $request->hari_rawat_ke),

            'dokter_igd' => $request->has('dokter_igd'),
            'dokter_spesialis' => $request->has('dokter_spesialis'),
            'perawatan_primer' => $request->has('perawatan_primer'),
            'dokter_dpjp' => $request->has('dokter_dpjp'),
            'dokter_nondpjp' => $request->has('dokter_nondpjp'),
            'perawat_penanggung_jawab' => $request->has('perawat_penanggung_jawab'),
            'tenaga_gizi' => $request->has('tenaga_gizi'),

            'darah_rutin' => $request->has('darah_rutin'),
            'urine_lengkap' => $request->has('urine_lengkap'),
            'psa' => $request->has('psa'),
            'bno_ivp' => $request->has('bno_ivp'),
            'usg_transrectal' => $request->has('usg_transrectal'),

            'bph' => $request->has('bph'),
            'kode_00016' => $request->has('kode_00016'),
            'kode_00132' => $request->has('kode_00132'),
            'kode_00206' => $request->has('kode_00206'),
            'kode_00246' => $request->has('kode_00246'),
            'kode_00094' => $request->has('kode_00094'),
            'kode_00173' => $request->has('kode_00173'),
            'kode_000161' => $request->has('kode_000161'),

            'prediksi_asupan_gizi' => $request->has('prediksi_asupan_gizi'),
            'kebutuhan_perawatan_suportif' => $request->has('kebutuhan_perawatan_suportif'),
            'kebutuhan_pasien_post_op' => $request->kebutuhan_pasien_post_op ?? 0,
            'aktivitas_pulang_rs' => $request->aktivitas_pulang_rs ?? 0,
            'kebutuhan_konseling_seksual' => $request->has('kebutuhan_konseling_seksual'),
            'identifikasi_kebutuhan_pasien_dirumah' => $request->has('identifikasi_kebutuhan_pasien_dirumah'),
            'program_rehab_medik' => $request->program_rehab_medik ?? 0,

            'informasi_pemberian_obat_dirumah' => $request->has('informasi_pemberian_obat_dirumah'),
            'penjelasan_diagnosis' => $request->penjelasan_diagnosis ?? 0,
            'rencana_terapi' => $request->has('rencana_terapi'),
            'informed_consent' => $request->informed_consent ?? 0,

            'diet_pra' => $request->has('diet_pra'),
            'gizi_seimbang' => $request->gizi_seimbang ?? 0,

            'persiapan_operasi' => $request->has('persiapan_operasi'),
            'informasi_obat' => $request->has('informasi_obat'),
            'konseling_obat' => $request->has('konseling_obat'),
            'lembar_edukasi_terintegrasi' => $request->has('lembar_edukasi_terintegrasi'),

            'ceftriaxone' => $request->has('ceftriaxone'),
            'ketorolac' => $request->ketorolac ?? 0,
            'rl' => $request->has('rl'),
            'asam_mafenamat' => $request->has('asam_mafenamat'),
            'cefixime' => $request->cefixime ?? 0,

            'nic_ttv' => $request->has('nic_ttv'),
            'nic_4190' => $request->nic_4190 ?? 0,
            'nic_309' => $request->has('nic_309'),
            'nic_0309' => $request->has('nic_0309'),
            'nic_379' => $request->nic_379 ?? 0,
            'nic_431' => $request->nic_431 ?? 0,
            'nic_1400' => $request->has('nic_1400'),
            'nic_3360' => $request->has('nic_3360'),
            'nic_0590' => $request->has('nic_0590'),
            'nic_0580' => $request->has('nic_0580'),
            'nic_0570' => $request->has('nic_0570'),
            'nic_0221' => $request->has('nic_0221'),
            'nic_2314' => $request->nic_2314 ?? 0,
            'nic_2304' => $request->has('nic_2304'),

            'monitoring_ttv' => $request->has('monitoring_ttv'),
            'monitoring_nyeri' => $request->has('monitoring_nyeri'),
            'monitoring_luka' => $request->has('monitoring_luka'),
            'monitoring_asupan_makan' => $request->has('monitoring_asupan_makan'),
            'monitoring_biokimia' => $request->has('monitoring_biokimia'),
            'monitoring_fisik' => $request->has('monitoring_fisik'),
            'monitoring_interaksi_obat' => $request->has('monitoring_interaksi_obat'),
            'monitoring_efek_samping_obat' => $request->has('monitoring_efek_samping_obat'),

            'noc_1605' => $request->noc_1605 ?? 0,
            'noc_2101' => $request->noc_2101 ?? 0,
            'noc_2102' => $request->noc_2102 ?? 0,
            'noc_1102' => $request->noc_1102 ?? 0,
            'noc_0703' => $request->noc_0703 ?? 0,
            'noc_cemas' => $request->noc_cemas ?? 0,
            'noc_mengontrol' => $request->noc_mengontrol ?? 0,

            'varian' => $request->varian,
            'kd_dokter' => $request->kd_dokter,
            'id_petugas' => $request->id_petugas,

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('bph.index')->with('success', 'Data berhasil disimpan');
    }

    public function destroy($id)
    {
        try {
            $deleted = DB::table('bph_clinical_pathways')
                ->where('id', $id)
                ->delete();

            if ($deleted) {
                return redirect()
                    ->route('bph.index')
                    ->with('success', 'Data berhasil dihapus.');
            }

            return redirect()
                ->route('bph.index')
                ->with('error', 'Data tidak ditemukan.');

        } catch (\Exception $e) {
            return redirect()
                ->route('bph.index')
                ->with('error', 'Gagal menghapus data.');
        }
    }

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

    public function show($no_rawat)
    {
        $no_rawat = urldecode($no_rawat);

        $data = DB::table('bph_clinical_pathways as h')

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
                ->route('bph.index')
                ->with('error', 'Data tidak ditemukan');
        }

        preg_match('/\d+\s*Th/', $data->umur, $matches);
        $data->umur_tahun = $matches[0] ?? $data->umur;

        return view('bph.show', compact('data'));
    }

    public function exportPdf($no_rawat)
    {
        $no_rawat = urldecode($no_rawat);

        $data = DB::table('bph_clinical_pathways as h')
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
                ->route('bph.index')
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

        $pdf = Pdf::loadView('bph.pdf', [
            'data' => $data,
            'logoBase64' => $logoBase64  
        ])
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        $fileName = 'bph_Clinical_Pathway_' . str_replace('/', '_', $no_rawat) . '_' . date('Ymd_His') . '.pdf';

        return $pdf->download($fileName);
    }

}
