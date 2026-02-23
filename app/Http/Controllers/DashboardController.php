<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {

        $allPathways = DB::query()

            ->from('hiv_clinical_pathways')

            ->select('created_at')

            ->unionAll(
                DB::table('dm_clinical_pathways')->select('created_at')
            )

            ->unionAll(
                DB::table('bph_clinical_pathways')->select('created_at')
            )

            ->unionAll(
                DB::table('typh_clinical_pathways')->select('created_at')
            )

            ->unionAll(
                DB::table('jntg_clinical_pathways')->select('created_at')
            )

            ->unionAll(
                DB::table('peb_clinical_pathways')->select('created_at')
            )

            ->unionAll(
                DB::table('dyps_clinical_pathways')->select('created_at')
            );

        $totalAll = DB::query()
            ->fromSub($allPathways, 'all_data')
            ->count();

        $pasienHariIni = DB::query()
            ->fromSub($allPathways, 'all_data')
            ->whereDate('created_at', Carbon::today())
            ->count();


        $pasienMingguIni = DB::query()
            ->fromSub($allPathways, 'all_data')
            ->whereBetween('created_at', [
                Carbon::now()->subDays(7),
                Carbon::now()
            ])
            ->count();

        $pasienBulanIni = DB::query()
            ->fromSub($allPathways, 'all_data')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        return view('dashboard.index', compact(
            'totalAll',
            'pasienHariIni',
            'pasienMingguIni',
            'pasienBulanIni',
        ));
    }

    public function recent()
    {
        $baseQuery = DB::query()
            ->from('hiv_clinical_pathways as h')
            ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->select(
                'h.no_rawat',
                'p.no_rkm_medis as no_rm',
                'p.nm_pasien as nama_pasien',
                'h.created_at',
                DB::raw("'HIV' as jenis")
            )

            ->unionAll(
                DB::table('dm_clinical_pathways as h')
                    ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
                    ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
                    ->select(
                        'h.no_rawat',
                        'p.no_rkm_medis as no_rm',
                        'p.nm_pasien as nama_pasien',
                        'h.created_at',
                        DB::raw("'DM' as jenis")
                    )
            )

            ->unionAll(
                DB::table('bph_clinical_pathways as h')
                    ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
                    ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
                    ->select(
                        'h.no_rawat',
                        'p.no_rkm_medis as no_rm',
                        'p.nm_pasien as nama_pasien',
                        'h.created_at',
                        DB::raw("'BPH' as jenis")
                    )
            )

            ->unionAll(
                DB::table('typh_clinical_pathways as h')
                    ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
                    ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
                    ->select(
                        'h.no_rawat',
                        'p.no_rkm_medis as no_rm',
                        'p.nm_pasien as nama_pasien',
                        'h.created_at',
                        DB::raw("'TYPH' as jenis")
                    )
            )

            ->unionAll(
                DB::table('jntg_clinical_pathways as h')
                    ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
                    ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
                    ->select(
                        'h.no_rawat',
                        'p.no_rkm_medis as no_rm',
                        'p.nm_pasien as nama_pasien',
                        'h.created_at',
                        DB::raw("'JANTUNG' as jenis")
                    )
            )

            ->unionAll(
                DB::table('peb_clinical_pathways as h')
                    ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
                    ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
                    ->select(
                        'h.no_rawat',
                        'p.no_rkm_medis as no_rm',
                        'p.nm_pasien as nama_pasien',
                        'h.created_at',
                        DB::raw("'PEB' as jenis")
                    )
            )

            ->unionAll(
                DB::table('dyps_clinical_pathways as h')
                    ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
                    ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
                    ->select(
                        'h.no_rawat',
                        'p.no_rkm_medis as no_rm',
                        'p.nm_pasien as nama_pasien',
                        'h.created_at',
                        DB::raw("'DYPS' as jenis")
                    )
            );

        $recentActivities = DB::query()
            ->fromSub($baseQuery, 'activities')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.recent', compact('recentActivities'));
    }

    public function alldata(Request $request)
    {
        $queries = [];
        $queries[] = DB::table('hiv_clinical_pathways as h')
            ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->select(
                'h.no_rawat',
                'p.no_rkm_medis as no_rm',
                'p.nm_pasien as nama_pasien',
                'h.created_at',
                DB::raw("'HIV' as jenis")
            );

        $queries[] = DB::table('dm_clinical_pathways as h')
            ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->select(
                'h.no_rawat',
                'p.no_rkm_medis as no_rm',
                'p.nm_pasien as nama_pasien',
                'h.created_at',
                DB::raw("'DM' as jenis")
            );

        $queries[] = DB::table('bph_clinical_pathways as h')
            ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->select(
                'h.no_rawat',
                'p.no_rkm_medis as no_rm',
                'p.nm_pasien as nama_pasien',
                'h.created_at',
                DB::raw("'BPH' as jenis")
            );

        $queries[] = DB::table('typh_clinical_pathways as h')
            ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->select(
                'h.no_rawat',
                'p.no_rkm_medis as no_rm',
                'p.nm_pasien as nama_pasien',
                'h.created_at',
                DB::raw("'TYPH' as jenis")
            );

        $queries[] = DB::table('jntg_clinical_pathways as h')
            ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->select(
                'h.no_rawat',
                'p.no_rkm_medis as no_rm',
                'p.nm_pasien as nama_pasien',
                'h.created_at',
                DB::raw("'JANTUNG' as jenis")
            );

        $queries[] = DB::table('peb_clinical_pathways as h')
            ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->select(
                'h.no_rawat',
                'p.no_rkm_medis as no_rm',
                'p.nm_pasien as nama_pasien',
                'h.created_at',
                DB::raw("'PEB' as jenis")
            );

        $queries[] = DB::table('dyps_clinical_pathways as h')
            ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->select(
                'h.no_rawat',
                'p.no_rkm_medis as no_rm',
                'p.nm_pasien as nama_pasien',
                'h.created_at',
                DB::raw("'DYPS' as jenis")
            );

        $baseQuery = $queries[0];
        for ($i = 1; $i < count($queries); $i++) {
            $baseQuery = $baseQuery->unionAll($queries[$i]);
        }
        $finalQuery = DB::query()
            ->fromSub($baseQuery, 'all_data');
        if ($request->filled('jenis') && $request->jenis != 'all') {
            $finalQuery->where('jenis', strtoupper($request->jenis));
        }

        if ($request->filled('tanggal_mulai')) {
            $finalQuery->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $finalQuery->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $finalQuery->where(function ($query) use ($search) {
                $query->where('nama_pasien', 'like', "%{$search}%")
                    ->orWhere('no_rm', 'like', "%{$search}%")
                    ->orWhere('no_rawat', 'like', "%{$search}%");
            });
        }

        $pasien = $finalQuery
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();
        $jenisOptions = [
            'all' => 'Semua Jenis',
            'HIV' => 'HIV',
            'DM' => 'Diabetes Melitus',
            'BPH' => 'BPH',
            'TYPH' => 'Typhoid',
            'JANTUNG' => 'Jantung',
            'PEB' => 'PEB',
            'DYPS' => 'Dyspepsia'
        ];

        return view('dashboard.alldata', compact('pasien', 'jenisOptions'));
    }
}
