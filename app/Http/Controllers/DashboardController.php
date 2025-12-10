<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total HIV Pathways
        $totalHiv = DB::table('hiv_clinical_pathways')->count();

        // Pasien Hari Ini
        $pasienHariIni = DB::table('hiv_clinical_pathways')
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Pasien Minggu Ini (7 hari terakhir)
        $pasienMingguIni = DB::table('hiv_clinical_pathways')
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
            ->count();

        // Pasien Bulan Ini
        $pasienBulanIni = DB::table('hiv_clinical_pathways')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Aktivitas Terbaru (10 data terakhir)
        $recentActivities = DB::table('hiv_clinical_pathways as h')
            ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->select(
                'h.no_rawat',
                'p.no_rkm_medis as no_rm',
                'p.nm_pasien as nama_pasien',
                'h.created_at'
            )
            ->orderByDesc('h.created_at')
            ->limit(10)
            ->get();

        return view('dashboard.index', compact(
            'totalHiv',
            'pasienHariIni',
            'pasienMingguIni',
            'pasienBulanIni',
            'recentActivities'
        ));
    }
}