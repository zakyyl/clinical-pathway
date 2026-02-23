<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TyphController extends Controller
{
    public function index()
    {
        $pasien = DB::table('typh_clinical_pathways as h')
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

        return view('typh.index', compact('pasien'));
    }

    public function create(Request $request)
    {
        $no_rawat = $request->query('no_rawat');

        if (!$no_rawat) {
            return view('typh.create', ['data' => null]);
        }

        $data = $this->getPatient($no_rawat);

        if (!$data) {
            return back()->with('error', 'Data pasien tidak ditemukan.');
        }
        $dokter = $this->getDokterList();
        $petugas = $this->getPetugasList();

        return view('typh.create', compact('data', 'dokter', 'petugas'));
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

        DB::table('typh_clinical_pathways')->insert([

            'no_rawat' => $request->no_rawat,
            'hari_penyakit_ke' => implode(',', $request->hari_penyakit_ke),
            'hari_rawat_ke' => implode(',', $request->hari_rawat_ke),

            '1a_dokter_igd' => $request->has('1a_dokter_igd') ? 1 : 0,
            '1a_dokter_spesialis' => $request->has('1a_dokter_spesialis') ? 1 : 0,
            '1b_perawatan_primer' => $request->has('1b_perawatan_primer') ? 1 : 0,

            '2_pemeriksaan_darah' => $request->has('2_pemeriksaan_darah') ? 1 : 0,
            '2_elektrolit' => $request->has('2_elektrolit') ? 1 : 0,
            '2_fungsi_hati' => $request->has('2_fungsi_hati') ? 1 : 0,

            '3_ekg' => $request->has('3_ekg') ? 1 : 0,
            '3_usg_abdomen' => $request->has('3_usg_abdomen') ? 1 : 0,

            '4_konsultasi' => $request->has('4_konsultasi') ? 1 : 0,

            '5a_dokter_dpjp' => $request->has('5a_dokter_dpjp') ? 1 : 0,
            '5a_dokter_nondpjp' => $request->has('5a_dokter_nondpjp') ? 1 : 0,
            '5b_perawat_penanggung_jawab' => $request->has('5b_perawat_penanggung_jawab') ? 1 : 0,
            '5c_tenaga_gizi' => $request->has('5c_tenaga_gizi') ? 1 : 0,
            '5d_telaah_resep' => $request->has('5d_telaah_resep') ? 1 : 0,
            '5d_rekonsiliasi_obat' => $request->has('5d_rekonsiliasi_obat') ? 1 : 0,

            '6b_hipertermia' => $request->has('6b_hipertermia') ? 1 : 0,
            '6b_risiko_defisit_cairan' => $request->has('6b_risiko_defisit_cairan') ? 1 : 0,
            '6b_nutrisi_kurang' => $request->has('6b_nutrisi_kurang') ? 1 : 0,
            '6c_risiko_malnutrisi' => $request->has('6c_risiko_malnutrisi') ? 1 : 0,

            '7_identifikasi_kebutuhan' => $request->has('7_identifikasi_kebutuhan') ? 1 : 0,
            '7_identifikasi_rumah' => $request->has('7_identifikasi_rumah') ? 1 : 0,
            '7_hand_hygiene' => $request->has('7_hand_hygiene') ? 1 : 0,
            '7_kebersihan_lingkungan' => $request->has('7_kebersihan_lingkungan') ? 1 : 0,

            '8a_penjelasan_diagnosis' => $request->has('8a_penjelasan_diagnosis') ? 1 : 0,
            '8a_rencana_terapi' => $request->has('8a_rencana_terapi') ? 1 : 0,
            '8a_informed_consent' => $request->has('8a_informed_consent') ? 1 : 0,
            '8b_diet_serat' => $request->has('8b_diet_serat') ? 1 : 0,
            '8c_penyesuaian_aktivitas' => $request->has('8c_penyesuaian_aktivitas') ? 1 : 0,
            '8c_perawatan_diri' => $request->has('8c_perawatan_diri') ? 1 : 0,
            '8d_informasi_obat' => $request->has('8d_informasi_obat') ? 1 : 0,
            '8d_konseling_obat' => $request->has('8d_konseling_obat') ? 1 : 0,
            '8e_lembar_edukasi' => $request->has('8e_lembar_edukasi') ? 1 : 0,

            '9a_antibiotik_injeksi' => $request->has('9a_antibiotik_injeksi') ? 1 : 0,
            '9a_antipiretik_injeksi' => $request->has('9a_antipiretik_injeksi') ? 1 : 0,
            '9b_cairan_rehidrasi_sesuai_kebutuhan' => $request->has('9b_cairan_rehidrasi_sesuai_kebutuhan') ? 1 : 0,
            '9c_antibiotik' => $request->has('9c_antibiotik') ? 1 : 0,
            '9c_clopidogrel' => $request->has('9c_clopidogrel') ? 1 : 0,
            '9c_antipiretik' => $request->has('9c_antipiretik') ? 1 : 0,
            '9c_vitamin' => $request->has('9c_vitamin') ? 1 : 0,
            '9d_antipiretik_suppositoria' => $request->has('9d_antipiretik_suppositoria') ? 1 : 0,

            '10a_tli_medis' => $request->has('10a_tli_medis') ? 1 : 0,
            '10b_kompres_hangat' => $request->has('10b_kompres_hangat') ? 1 : 0,
            '10c_dietlnk' => $request->has('10c_dietlnk') ? 1 : 0,
            '10c_konseling_nutrisi' => $request->has('10c_konseling_nutrisi') ? 1 : 0,
            '10d_rekom_dpjp' => $request->has('10d_rekom_dpjp') ? 1 : 0,

            '11a_asesmen_ulang' => $request->has('11a_asesmen_ulang') ? 1 : 0,
            '11b_noc413' => $request->has('11b_noc413') ? 1 : 0,
            '11b_noc200' => $request->has('11b_noc200') ? 1 : 0,
            '11b_1400' => $request->has('11b_1400') ? 1 : 0,
            '11c_asupan_makanan' => $request->has('11c_asupan_makanan') ? 1 : 0,
            '11c_antropometri' => $request->has('11c_antropometri') ? 1 : 0,
            '11c_fisik' => $request->has('11c_fisik') ? 1 : 0,
            '11c_biokimia' => $request->has('11c_biokimia') ? 1 : 0,
            '11d_interaksi_obat' => $request->has('11d_interaksi_obat') ? 1 : 0,
            '11d_efek_samping' => $request->has('11d_efek_samping') ? 1 : 0,
            '11d_terapi_obat' => $request->has('11d_terapi_obat') ? 1 : 0,

            '12a_dibantu' => $request->has('12a_dibantu') ? 1 : 0,
            '12b_dibantu' => $request->has('12b_dibantu') ? 1 : 0,
            '12c_dibantu' => $request->has('12c_dibantu') ? 1 : 0,

            '13a_bebas_demam' => $request->has('13a_bebas_demam') ? 1 : 0,
            '13a_tidak_kom' => $request->has('13a_tidak_kom') ? 1 : 0,
            '13b_selera_makan' => $request->has('13b_selera_makan') ? 1 : 0,
            '13b_hidrasi_baik' => $request->has('13b_hidrasi_baik') ? 1 : 0,
            '13b_berpartisivasi' => $request->has('13b_berpartisivasi') ? 1 : 0,
            '13b_mampu_nyeri' => $request->has('13b_mampu_nyeri') ? 1 : 0,
            '13c_asupan_makan' => $request->has('13c_asupan_makan') ? 1 : 0,
            '13c_asupan_cairan' => $request->has('13c_asupan_cairan') ? 1 : 0,
            '13c_status_gizi' => $request->has('13c_status_gizi') ? 1 : 0,
            '13d_terapi_obat' => $request->has('13d_terapi_obat') ? 1 : 0,
            '13d_obat_rasional' => $request->has('13d_obat_rasional') ? 1 : 0,

            '14_bebas_demam' => $request->has('14_bebas_demam') ? 1 : 0,
            '14_oral_baik' => $request->has('14_oral_baik') ? 1 : 0,
            '14_sesuai_noc' => $request->has('14_sesuai_noc') ? 1 : 0,

            '15_resume_medis' => $request->has('15_resume_medis') ? 1 : 0,
            '15_penjelasan' => $request->has('15_penjelasan') ? 1 : 0,
            '15_surat' => $request->has('15_surat') ? 1 : 0,

            '16_varian' => $request->varian,

            'kd_dokter' => $request->kd_dokter,
            'id_petugas' => $request->id_petugas,

            'created_at' => now(),
            'updated_at' => now(),

        ]);



        return redirect()->route('typh.index')->with('success', 'Data berhasil disimpan.');
    }

    public function destroy($id)
    {
        try {
            $deleted = DB::table('typh_clinical_pathways')
                ->where('id', $id)
                ->delete();

            if ($deleted) {
                return redirect()
                    ->route('typh.index')
                    ->with('success', 'Data berhasil dihapus.');
            }

            return redirect()
                ->route('typh.index')
                ->with('error', 'Data tidak ditemukan.');

        } catch (\Exception $e) {
            return redirect()
                ->route('typh.index')
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

        $data = DB::table('typh_clinical_pathways as h')

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
                ->route('typh.index')
                ->with('error', 'Data tidak ditemukan');
        }

        // potong umur
        preg_match('/\d+\s*Th/', $data->umur, $matches);
        $data->umur_tahun = $matches[0] ?? $data->umur;

        return view('typh.show', compact('data'));
    }

    public function exportPdf($no_rawat)
    {
        $no_rawat = urldecode($no_rawat);

        $data = DB::table('typh_clinical_pathways as h')
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
                ->route('typh.index')
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

        $pdf = Pdf::loadView('typh.pdf', [
            'data' => $data,
            'logoBase64' => $logoBase64  
        ])
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        $fileName = 'typh_Clinical_Pathway_' . str_replace('/', '_', $no_rawat) . '_' . date('Ymd_His') . '.pdf';

        return $pdf->download($fileName);
    }
}
