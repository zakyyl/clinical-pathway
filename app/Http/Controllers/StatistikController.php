<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatistikController extends Controller
{
    public function index(Request $request)
    {
        // Default values untuk bulan
        $bulan_dari = $request->filled('bulan_dari') 
            ? $request->bulan_dari 
            : Carbon::now()->subMonths(11)->format('Y-m');
        
        $bulan_sampai = $request->filled('bulan_sampai') 
            ? $request->bulan_sampai 
            : Carbon::now()->format('Y-m');

        // Parse dates
        $tanggal_dari = Carbon::parse($bulan_dari . '-01')->startOfMonth();
        $tanggal_sampai = Carbon::parse($bulan_sampai . '-01')->endOfMonth();

        // Total Data dalam periode
        $totalData = DB::table('hiv_clinical_pathways')
            ->whereBetween('created_at', [$tanggal_dari, $tanggal_sampai])
            ->count();

        // Data Hari Ini
        $dataHariIni = DB::table('hiv_clinical_pathways')
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Data Bulan Ini
        $dataBulanIni = DB::table('hiv_clinical_pathways')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Data Tahun Ini
        $dataTahunIni = DB::table('hiv_clinical_pathways')
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Generate labels and data for chart
        $chartData = $this->generateChartData($tanggal_dari, $tanggal_sampai);

        return view('statistik.index', compact(
            'totalData',
            'dataHariIni',
            'dataBulanIni',
            'dataTahunIni',
            'chartData',
            'bulan_dari',
            'bulan_sampai'
        ));
    }

    private function generateChartData($tanggal_dari, $tanggal_sampai)
    {
        $labels = [];
        $data = [];

        // Get data grouped by month
        $dataPerBulan = DB::table('hiv_clinical_pathways')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as bulan, COUNT(*) as total')
            ->whereBetween('created_at', [$tanggal_dari, $tanggal_sampai])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        // Generate all months in range
        $current = $tanggal_dari->copy();
        while ($current <= $tanggal_sampai) {
            $bulanKey = $current->format('Y-m');
            $labels[] = $current->isoFormat('MMM YYYY');
            $data[] = $dataPerBulan->has($bulanKey) ? $dataPerBulan[$bulanKey]->total : 0;
            $current->addMonth();
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}