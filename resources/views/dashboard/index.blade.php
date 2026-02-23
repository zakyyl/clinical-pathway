@extends('layouts.app')

@section('content')

{{-- Link ke file CSS terpisah --}}
<link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard/responsive.css') }}">

{{-- HEADER SECTION --}}
<div class="gradient-bg" style="border-radius:20px;padding:40px;color:white;margin-bottom:32px;position:relative">
    <div style="display:flex;justify-content:space-between;align-items:center;position:relative;z-index:1">
        <div>
            <h3 style="font-size:36px;font-weight:800;margin-bottom:8px;text-shadow:0 2px 8px rgba(0,0,0,0.2)">
                Selamat Datang, {{ Auth::user()->name }}!
            </h3>
            <p style="font-size:16px;opacity:0.95;margin-bottom:8px">Kelola Clinical Pathway dengan Mudah</p>
            <p style="font-size:14px;opacity:0.8;display:flex;align-items:center;gap:8px">
                <span>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</span>
            </p>
        </div>
        <div style="font-size:120px;opacity:.15">🏥</div>
    </div>
</div>

{{-- STATS SECTION --}}
<div class="stats-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:24px;margin-bottom:32px">
    <div class="stat-card secondary">
        <div class="stat-icon">📅</div>
        <div class="stat-value">{{ $pasienHariIni }}</div>
        <div class="stat-label">Hari Ini</div>
    </div>

    <div class="stat-card primary">
        <div class="stat-icon">📊</div>
        <div class="stat-value">{{ $totalAll }}</div>
        <div class="stat-label">Total Pathway</div>
    </div>

    <div class="stat-card accent">
        <div class="stat-icon">📆</div>
        <div class="stat-value">{{ $pasienBulanIni }}</div>
        <div class="stat-label">Bulan Ini</div>
    </div>
</div>

{{-- CONTENT GRID --}}
<div class="content-grid" style="display:grid;grid-template-columns:1.5fr 1fr;gap:24px;margin-bottom:32px">
    
    {{-- FLOW DIAGRAM SECTION --}}
    <div>
        <div class="flow-section">
            <div class="flow-header">
                <div class="flow-title">
                    <h3>Alur Kerja Aplikasi</h3>
                    <p>Flow Proses Clinical Pathway</p>
                </div>
            </div>
            <div class="flow-image-container">
                <img src="{{ asset('image/flow.png') }}" alt="Application Flow Diagram" class="flow-image">
            </div>
        </div>
    </div>

    {{-- QUICK ACTIONS SECTION --}}
    <div>
        <div class="section-card">
            <div class="section-header">
                <h4>Tindakan Cepat</h4>
            </div>

            <div style="display:flex;flex-direction:column;gap:14px">
                <button type="button" onclick="openModal()" class="quick-action-btn" style="border-radius:20px;background:white">
                    <div style="display:flex;align-items:center;gap:18px">
                        <div class="action-icon">➕</div>
                        <div style="text-align:left">
                            <p style="font-weight:700;font-size:15px;color:var(--primary);margin-bottom:2px">
                                Tambah Pathway Baru
                            </p>
                            <p style="font-size:13px;color:#64748b">
                               Klik Untuk Menambah Data Baru
                            </p>
                        </div>
                    </div>
                </button>

                <a href="{{ route('dashboard.alldata') }}" class="quick-action-btn">
                    <div style="display:flex;align-items:center;gap:18px">
                        <div class="action-icon" style="background:linear-gradient(135deg,#456882,#6588a2)">📋</div>
                        <div style="text-align:left">
                            <p style="font-weight:700;font-size:15px;color:var(--primary);margin-bottom:2px">
                                Semua Data
                            </p>
                            <p style="font-size:13px;color:#64748b">
                                Lihat Semua Data
                            </p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('dashboard.recent') }}" class="quick-action-btn">
                    <div style="display:flex;align-items:center;gap:18px">
                        <div class="action-icon" style="background:linear-gradient(135deg,#234C6A,#456882)">🚹</div>
                        <div style="text-align:left">
                            <p style="font-weight:700;font-size:15px;color:var(--primary);margin-bottom:2px">
                                Aktivitas Terbaru
                            </p>
                            <p style="font-size:13px;color:#64748b">
                                Cek Data Terbaru
                            </p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('statistik.index') }}" class="quick-action-btn">
                    <div style="display:flex;align-items:center;gap:18px">
                        <div class="action-icon" style="background:linear-gradient(135deg,#456882,#6588a2)">📊</div>
                        <div style="text-align:left">
                            <p style="font-weight:700;font-size:15px;color:var(--primary);margin-bottom:2px">
                                Statistik & Analisis
                            </p>
                            <p style="font-size:13px;color:#64748b">
                                Lihat laporan lengkap
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- MODAL PATHWAY SELECTION --}}
<div id="pathwayModal" class="modal-overlay" onclick="closeModalOnOutsideClick(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <div>
                <h3 style="font-size:22px;font-weight:800;color:var(--primary);margin-bottom:6px">
                    Pilih Clinical Pathway 🏥
                </h3>
                <p style="font-size:14px;color:#64748b">
                    Pilih jenis pathway yang ingin Anda buat
                </p>
            </div>
            <button onclick="closeModal()" class="close-btn">✕</button>
        </div>

        <div class="modal-body">
            <div class="pathway-grid">
                <a href="{{ route('hiv.create') }}" class="pathway-card">
                    <div class="pathway-icon">🧬</div>
                    <div class="pathway-title">HIV/AIDS</div>
                    <div class="pathway-desc">Clinical Pathway HIV</div>
                </a>

                <a href="{{ route('dm.create') }}" class="pathway-card">
                    <div class="pathway-icon">🍬</div>
                    <div class="pathway-title">Diabetes Mellitus</div>
                    <div class="pathway-desc">Clinical Pathway Diabetes</div>
                </a>

                <a href="{{ route('typh.create') }}" class="pathway-card">
                    <div class="pathway-icon">🌡️</div>
                    <div class="pathway-title">Typhoid</div>
                    <div class="pathway-desc">Clinical Pathway Demam Tifoid</div>
                </a>

                <a href="{{ route('dyps.create') }}" class="pathway-card">
                    <div class="pathway-icon">🤢</div>
                    <div class="pathway-title">Dyspepsia</div>
                    <div class="pathway-desc">Clinical Pathway Gangguan Pencernaan</div>
                </a>

                <a href="{{ route('peb.create') }}" class="pathway-card">
                    <div class="pathway-icon">🤰</div>
                    <div class="pathway-title">PEB</div>
                    <div class="pathway-desc">Clinical Pathway Preeklampsia Berat</div>
                </a>

                <a href="{{ route('jntg.create') }}" class="pathway-card">
                    <div class="pathway-icon">❤️‍🩹</div>
                    <div class="pathway-title">Jantung</div>
                    <div class="pathway-desc">Clinical Pathway Jantung</div>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Link ke file JavaScript terpisah --}}
<script src="{{ asset('js/dashboard/dashboard.js') }}"></script>

@endsection