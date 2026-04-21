@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard/responsive.css') }}">

<style>
    .dash-wrapper {
        max-width: 100%;
        padding: 0 4px;
        box-sizing: border-box;
    }

    /* HEADER */
    .dash-header {
        border-radius: 16px;
        padding: 28px 32px;
        color: white;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .dash-header .header-emoji {
        position: absolute;
        right: 32px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 80px;
        opacity: 0.12;
        pointer-events: none;
    }

    /* STATS */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-card {
        border-radius: 14px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: transform .2s, box-shadow .2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    .stat-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .stat-icon-wrap i {
        color: #234C6A;
    }
    .stat-info .stat-value {
        font-size: 26px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1;
        margin-bottom: 4px;
    }
    .stat-info .stat-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
    }

    /* CONTENT GRID */
    .main-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 20px;
        margin-bottom: 24px;
    }

    /* FLOW IMAGE CARD */
    .flow-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        flex-direction: column;
    }
    .flow-card-header {
        margin-bottom: 18px;
    }
    .flow-card-header h4 {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 3px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .flow-card-header p {
        font-size: 12px;
        color: #94a3b8;
    }
    .flow-image-wrap {
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px dashed #cbd5e1;
        padding: 16px;
        overflow: hidden;
    }
    .flow-image-wrap img {
        max-width: 100%;
        max-height: 400px;
        object-fit: contain;
        border-radius: 8px;
    }

    /* QUICK ACTIONS */
    .actions-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        height: 100%; 
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        min-width: 0; 
    }
    .actions-card h4 {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 16px;
        margin-top: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .action-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        flex-grow: 1; 
    }
    .action-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 14px;
        border-radius: 12px;
        border: 1.5px solid #f1f5f9;
        background: white;
        cursor: pointer;
        text-decoration: none;
        transition: border-color .2s, background .2s, transform .15s;
    }
    .action-item:hover {
        border-color: #234C6A;
        background: #f8fafc;
        transform: translateX(3px);
    }
    .action-ico {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .action-ico i {
        color: #234C6A;
    }
    .action-text p:first-child {
        font-weight: 700;
        font-size: 13px;
        color: #1e293b;
        margin-bottom: 2px;
        text-align: left;
    }
    .action-text p:last-child {
        font-size: 11px;
        color: #94a3b8;
        text-align: left;
    }

    /* MODAL */
    .pathway-icon i {
        font-size: 32px;
        color: #234C6A;
    }

    /* RESPONSIVE */
    @media (max-width: 1100px) {
        .main-grid { grid-template-columns: 1fr; }
        .actions-card { order: -1; }
        .action-list { flex-direction: row; flex-wrap: wrap; }
        .action-item { flex: 1; min-width: 140px; }
    }
    @media (max-width: 768px) {
        .stats-row { grid-template-columns: 1fr; }
        .flow-image-wrap img { max-height: 250px; }
    }
</style>

<div class="dash-wrapper">

    {{-- HEADER --}}
    <div class="dash-header gradient-bg">
        <div style="position:relative;z-index:1">
            <h3 style="font-size:26px;font-weight:800;margin-bottom:6px;text-shadow:0 2px 8px rgba(0,0,0,.2)">
                Selamat Datang, {{ Auth::user()->name }}!
            </h3>
            <p style="font-size:14px;opacity:.9;margin-bottom:4px">Kelola Clinical Pathway dengan Mudah</p>
            <p style="font-size:12px;opacity:.75">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</p>
        </div>
        <div class="header-emoji"><i class="fas fa-hospital"></i></div>
    </div>

    {{-- STATS --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon-wrap" style="background:#dbeafe; color:#3b82f6;"><i class="fas fa-calendar-day"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $pasienHariIni }}</div>
                <div class="stat-label">Hari Ini</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrap" style="background:#dbeafe; color:#3b82f6;"><i class="fas fa-chart-bar"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $totalAll }}</div>
                <div class="stat-label">Total Pathway</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrap" style="background:#dbeafe; color:#3b82f6;"><i class="fas fa-calendar-alt"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $pasienBulanIni }}</div>
                <div class="stat-label">Bulan Ini</div>
            </div>
        </div>
    </div>

    {{-- MAIN GRID: Flow Image + Actions --}}
    <div class="main-grid">

        {{-- USER FLOW IMAGE --}}
        <div class="flow-card">
            <div class="flow-card-header">
                <h4><i class="fas fa-project-diagram" style="color:#234C6A"></i> Alur Penggunaan (User Flow)</h4>
                <p>Panduan langkah demi langkah pengelolaan data pathway</p>
            </div>

            <div class="flow-image-wrap">
                <img src="{{ asset('image/flow.png') }}" alt="User Flow Clinical Pathway">
            </div>
        </div>

        {{-- QUICK ACTIONS --}}
        <div class="actions-card">
            <h4 style="margin-top: 0;"><i class="fas fa-bolt" style="color:#234C6A"></i> Tindakan Cepat</h4>
            <div class="action-list">
                <button type="button" onclick="openModal()" class="action-item" style="border:1.5px solid #f1f5f9; width:100%; text-align:left;">
                    <div class="action-ico" style="background:#dbeafe; color:#234C6A;"><i class="fas fa-plus"></i></div>
                    <div class="action-text">
                        <p>Tambah Pathway Baru</p>
                        <p>Buat data pathway baru</p>
                    </div>
                </button>

                <a href="{{ route('dashboard.alldata') }}" class="action-item">
                    <div class="action-ico" style="background:#dbeafe; color:#234C6A;"><i class="fas fa-clipboard-list"></i></div>
                    <div class="action-text">
                        <p>Semua Data</p>
                        <p>Lihat seluruh data</p>
                    </div>
                </a>

                <a href="{{ route('dashboard.recent') }}" class="action-item">
                    <div class="action-ico" style="background:#dbeafe; color:#234C6A;"><i class="fas fa-clock"></i></div>
                    <div class="action-text">
                        <p>Aktivitas Terbaru</p>
                        <p>Cek data terbaru</p>
                    </div>
                </a>

                <a href="{{ route('statistik.index') }}" class="action-item">
                    <div class="action-ico" style="background:#dbeafe; color:#234C6A;"><i class="fas fa-chart-pie"></i></div>
                    <div class="action-text">
                        <p>Statistik & Analisis</p>
                        <p>Lihat laporan lengkap</p>
                    </div>
                </a>
            </div>
        </div>

    </div>

</div>

{{-- MODAL --}}
<div id="pathwayModal" class="modal-overlay" onclick="closeModalOnOutsideClick(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <div>
                <h3 style="font-size:20px;font-weight:800;color:var(--primary);margin-bottom:4px; display:flex; align-items:center; gap:8px;">
                    Pilih Clinical Pathway <i class="fas fa-hospital-alt"></i>
                </h3>
                <p style="font-size:13px;color:#64748b">Pilih jenis pathway yang ingin Anda buat</p>
            </div>
            <button onclick="closeModal()" class="close-btn">✕</button>
        </div>
        <div class="modal-body">
            <div class="pathway-grid">
                <a href="{{ route('hiv.create') }}" class="pathway-card">
                    <div class="pathway-icon"><i class="fas fa-dna"></i></div>
                    <div class="pathway-title">HIV/AIDS</div>
                    <div class="pathway-desc">Clinical Pathway HIV</div>
                </a>
                <a href="{{ route('dm.create') }}" class="pathway-card">
                    <div class="pathway-icon"><i class="fas fa-cubes"></i></div>
                    <div class="pathway-title">Diabetes Mellitus</div>
                    <div class="pathway-desc">Clinical Pathway Diabetes</div>
                </a>
                <a href="{{ route('typh.create') }}" class="pathway-card">
                    <div class="pathway-icon"><i class="fas fa-thermometer-half"></i></div>
                    <div class="pathway-title">Typhoid</div>
                    <div class="pathway-desc">Clinical Pathway Demam Tifoid</div>
                </a>
                <a href="{{ route('dyps.create') }}" class="pathway-card">
                    <div class="pathway-icon"><i class="fas fa-pills"></i></div>
                    <div class="pathway-title">Dyspepsia</div>
                    <div class="pathway-desc">Clinical Pathway Gangguan Pencernaan</div>
                </a>
                <a href="{{ route('peb.create') }}" class="pathway-card">
                    <div class="pathway-icon"><i class="fas fa-baby"></i></div>
                    <div class="pathway-title">PEB</div>
                    <div class="pathway-desc">Clinical Pathway Preeklampsia Berat</div>
                </a>
                <a href="{{ route('jntg.create') }}" class="pathway-card">
                    <div class="pathway-icon"><i class="fas fa-heartbeat"></i></div>
                    <div class="pathway-title">Jantung</div>
                    <div class="pathway-desc">Clinical Pathway Jantung</div>
                </a>
                <a href="{{ route('htsi.create') }}" class="pathway-card">
                    <div class="pathway-icon"><i class="fas fa-stethoscope"></i></div>
                    <div class="pathway-title">HTSI</div>
                    <div class="pathway-desc">Clinical Pathway HTSI</div>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/dashboard/dashboard.js') }}"></script>

@endsection