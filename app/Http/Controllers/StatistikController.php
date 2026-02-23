<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatistikController extends Controller
{
    public function index(Request $request)
{
    /* ===============================
     | FILTER INPUT
     =============================== */

    $bulan_dari = $request->filled('bulan_dari')
        ? $request->bulan_dari
        : Carbon::now()->subMonths(11)->format('Y-m');

    $bulan_sampai = $request->filled('bulan_sampai')
        ? $request->bulan_sampai
        : Carbon::now()->format('Y-m');

    $penyakit = $request->penyakit; // <-- filter penyakit



    /* ===============================
     | PARSE TANGGAL
     =============================== */

    $tanggal_dari   = Carbon::parse($bulan_dari . '-01')->startOfMonth();
    $tanggal_sampai = Carbon::parse($bulan_sampai . '-01')->endOfMonth();



    /* ===============================
     | MAP TABEL
     =============================== */

    $tables = [

        'hiv'  => 'hiv_clinical_pathways',
        'dm'   => 'dm_clinical_pathways',
        'bph'  => 'bph_clinical_pathways',
        'typh' => 'typh_clinical_pathways',
        'jntg' => 'jntg_clinical_pathways',
        'peb'  => 'peb_clinical_pathways',
        'dyps' => 'dyps_clinical_pathways',

    ];



    /* ===============================
     | BUILD QUERY
     =============================== */

    // Kalau pilih penyakit tertentu
    if ($penyakit && isset($tables[$penyakit])) {

        $allPathways = DB::table($tables[$penyakit])
            ->select('created_at');

    }

    // Kalau semua penyakit
    else {

        $allPathways = DB::query()
            ->from('hiv_clinical_pathways')->select('created_at')

            ->unionAll(DB::table('dm_clinical_pathways')->select('created_at'))
            ->unionAll(DB::table('bph_clinical_pathways')->select('created_at'))
            ->unionAll(DB::table('typh_clinical_pathways')->select('created_at'))
            ->unionAll(DB::table('jntg_clinical_pathways')->select('created_at'))
            ->unionAll(DB::table('peb_clinical_pathways')->select('created_at'))
            ->unionAll(DB::table('dyps_clinical_pathways')->select('created_at'));
    }



    /* ===============================
     | STATISTIK
     =============================== */

    $totalData = DB::query()
        ->fromSub($allPathways, 'all_data')
        ->whereBetween('created_at', [$tanggal_dari, $tanggal_sampai])
        ->count();


    $dataHariIni = DB::query()
        ->fromSub($allPathways, 'all_data')
        ->whereDate('created_at', Carbon::today())
        ->count();


    $dataBulanIni = DB::query()
        ->fromSub($allPathways, 'all_data')
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->count();


    $dataTahunIni = DB::query()
        ->fromSub($allPathways, 'all_data')
        ->whereYear('created_at', Carbon::now()->year)
        ->count();



    /* ===============================
     | CHART
     =============================== */

    $chartData = $this->generateChartData(
        $tanggal_dari,
        $tanggal_sampai,
        $allPathways
    );



    return view('statistik.index', compact(
        'totalData',
        'dataHariIni',
        'dataBulanIni',
        'dataTahunIni',
        'chartData',
        'bulan_dari',
        'bulan_sampai',
        'penyakit'
    ));
}




    /* =====================================
     | GENERATE DATA GRAFIK
     ===================================== */

    private function generateChartData($tanggal_dari, $tanggal_sampai, $allPathways)
    {
        $labels = [];
        $data   = [];


        /* =====================================
         | DATA PER BULAN (SEMUA TABEL)
         ===================================== */

        $dataPerBulan = DB::query()

            ->fromSub($allPathways, 'all_data')

            ->selectRaw('
                DATE_FORMAT(created_at, "%Y-%m") as bulan,
                COUNT(*) as total
            ')

            ->whereBetween('created_at', [$tanggal_dari, $tanggal_sampai])

            ->groupBy('bulan')
            ->orderBy('bulan')

            ->get()

            ->keyBy('bulan');



        /* =====================================
         | LOOP BULAN
         ===================================== */

        $current = $tanggal_dari->copy();

        while ($current <= $tanggal_sampai) {

            $bulanKey = $current->format('Y-m');

            $labels[] = $current->isoFormat('MMM YYYY');

            $data[] = $dataPerBulan->has($bulanKey)
                ? $dataPerBulan[$bulanKey]->total
                : 0;

            $current->addMonth();
        }


        return [
            'labels' => $labels,
            'data'   => $data
        ];
    }
}
