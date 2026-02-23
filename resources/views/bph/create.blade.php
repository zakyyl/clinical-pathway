@extends('layouts.app')

@section('content')

{{-- Link ke CSS files --}}
<link rel="stylesheet" href="{{ asset('css/bph/bph-fullwidth.css') }}">
<link rel="stylesheet" href="{{ asset('css/bph/bph-form.css') }}">
<link rel="stylesheet" href="{{ asset('css/bph/bph-responsive.css') }}">

{{-- PAGE HEADER --}}
<div class="modern-page-header">
    <div class="header-content">
        <div class="icon-wrapper" onclick="window.location.href='{{ route('bph.create') }}'" style="cursor:pointer;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
            </svg>
        </div>
        <div>
            <h1 class="page-title">Tambah Clinical Pathway BPH</h1>
            <p class="page-subtitle">Lengkapi formulir clinical pathway untuk pasien</p>
        </div>
    </div>
</div>

{{-- MODAL CARI PASIEN --}}
@if (!$data)
@include('bph.partials.modal-cari-pasien')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        openModal();
    });
</script>
@endif

{{-- MAIN FORM --}}
@if ($data)
<form action="{{ route('bph.store') }}" method="POST" id="bphForm">
    @csrf
    <input type="hidden" name="no_rawat" value="{{ $data->no_rawat }}">

    {{-- PATIENT INFO CARD --}}
    <div class="patient-info-card">
        <div class="card-header-custom">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
            </svg>
            <h4>Data Pasien</h4>
        </div>
        <div class="patient-info-grid">
            <div class="info-item">
                <span class="info-label">No. Rawat</span>
                <span class="info-value">{{ $data->no_rawat }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Nama Pasien</span>
                <span class="info-value">{{ $data->nama_pasien }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Usia</span>
                <span class="info-value">{{ $data->usia }} tahun</span>
            </div>
            <div class="info-item">
                <span class="info-label">Kamar</span>
                <span class="info-value">{{ $data->kd_kamar }}</span>
            </div>
        </div>
    </div>

    {{-- FORM HARI --}}
    <div class="form-section-card">
        @include('bph.partials.form-hari')
    </div>

    {{-- PROGRESS INDICATOR --}}
    <div class="progress-container">
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill"></div>
        </div>
        <div class="progress-text">
            <span id="currentStep">1</span> dari <span id="totalSteps">17</span> Tahap
        </div>
    </div>

    {{-- TABS NAVIGATION --}}
    <div class="modern-tabs-wrapper">
        <div class="tabs-header">
            <button type="button" class="tab-btn active" data-tab="asesmen-awal" data-index="0">
                <span class="tab-number">1</span>
                <span class="tab-text">Asesmen Awal</span>
            </button>
            <button type="button" class="tab-btn" data-tab="laboratorium" data-index="1" disabled>
                <span class="tab-number">2</span>
                <span class="tab-text">Laboratorium</span>
            </button>
            <button type="button" class="tab-btn" data-tab="radiologi" data-index="2" disabled>
                <span class="tab-number">3</span>
                <span class="tab-text">Radiologi</span>
            </button>
            <button type="button" class="tab-btn" data-tab="konsultasi" data-index="3" disabled>
                <span class="tab-number">4</span>
                <span class="tab-text">Konsultasi</span>
            </button>
            <button type="button" class="tab-btn" data-tab="asesmen-lanjutan" data-index="4" disabled>
                <span class="tab-number">5</span>
                <span class="tab-text">Asesmen Lanjutan</span>
            </button>
            <button type="button" class="tab-btn" data-tab="diagnosis" data-index="5" disabled>
                <span class="tab-number">6</span>
                <span class="tab-text">Diagnosis</span>
            </button>
            <button type="button" class="tab-btn" data-tab="discharge-planning" data-index="6" disabled>
                <span class="tab-number">7</span>
                <span class="tab-text">Discharge Planning</span>
            </button>
            <button type="button" class="tab-btn" data-tab="edukasi" data-index="7" disabled>
                <span class="tab-number">8</span>
                <span class="tab-text">Edukasi</span>
            </button>
            <button type="button" class="tab-btn" data-tab="terapi" data-index="8" disabled>
                <span class="tab-number">9</span>
                <span class="tab-text">Terapi Medika</span>
            </button>
            <button type="button" class="tab-btn" data-tab="tatalaksana" data-index="9" disabled>
                <span class="tab-number">10</span>
                <span class="tab-text">Tatalaksana</span>
            </button>
            <button type="button" class="tab-btn" data-tab="monitoring" data-index="10" disabled>
                <span class="tab-number">11</span>
                <span class="tab-text">Monitoring</span>
            </button>
            <button type="button" class="tab-btn" data-tab="mobilisasi" data-index="11" disabled>
                <span class="tab-number">12</span>
                <span class="tab-text">Mobilisasi</span>
            </button>
            <button type="button" class="tab-btn" data-tab="outcome" data-index="12" disabled>
                <span class="tab-number">13</span>
                <span class="tab-text">Outcome</span>
            </button>
            <button type="button" class="tab-btn" data-tab="kriteria-pulang" data-index="13" disabled>
                <span class="tab-number">14</span>
                <span class="tab-text">Kriteria Pulang</span>
            </button>
            <button type="button" class="tab-btn" data-tab="rencana-pulang" data-index="14" disabled>
                <span class="tab-number">15</span>
                <span class="tab-text">Rencana Pulang</span>
            </button>
            <button type="button" class="tab-btn" data-tab="varian" data-index="15" disabled>
                <span class="tab-number">16</span>
                <span class="tab-text">Varian</span>
            </button>
            <button type="button" class="tab-btn" data-tab="dokpes" data-index="16" disabled>
                <span class="tab-number">17</span>
                <span class="tab-text">PJ</span>
            </button>
        </div>

        {{-- TAB CONTENTS --}}
        <div class="tabs-content">
            <!-- Tab 1: Asesmen Awal -->
            <div class="tab-content-item active" id="tab-asesmen-awal">
                <div class="section-header">
                    <h2>1. ASESMEN AWAL</h2>
                </div>
                @include('bph.partials.asesmen_awal.form-dokter')
                @include('bph.partials.asesmen_awal.form-keperawatan')
            </div>

            <!-- Tab 2: Laboratorium -->
            <div class="tab-content-item" id="tab-laboratorium">
                <div class="section-header">
                    <h2>2. LABORATORIUM</h2>
                </div>
                @include('bph.partials.laboratorium.form-labor')
            </div>

            <!-- Tab 3: Radiologi -->
            <div class="tab-content-item" id="tab-radiologi">
                <div class="section-header">
                    <h2>3. RADIOLOGI</h2>
                </div>
                @include('bph.partials.radiologi.form-radiologi')
            </div>

            <!-- Tab 4: Konsultasi -->
            <div class="tab-content-item" id="tab-konsultasi">
                <div class="section-header">
                    <h2>4. KONSULTASI</h2>
                </div>
                @include('bph.partials.konsultasi.form-konsultasi')
            </div>

            <!-- Tab 5: Asesmen Lanjutan -->
            <div class="tab-content-item" id="tab-asesmen-lanjutan">
                <div class="section-header">
                    <h2>5. ASESMEN LANJUTAN</h2>
                </div>
                @include('bph.partials.asesmen_lanjut.form-lanjut-dokter')
                @include('bph.partials.asesmen_lanjut.form-lanjut-keperawatan')
                @include('bph.partials.asesmen_lanjut.form-gizi')
                @include('bph.partials.asesmen_lanjut.form-farmasi')
            </div>

            <!-- Tab 6: Diagnosis -->
            <div class="tab-content-item" id="tab-diagnosis">
                <div class="section-header">
                    <h2>6. DIAGNOSIS</h2>
                    <p class="section-subtitle">BPH - Benign Prostatic Hyperplasia</p>
                </div>
                @include('bph.partials.diagnosis.form-diag-keperawatan')
                @include('bph.partials.diagnosis.form-diag-gizi')
            </div>

            <!-- Tab 7: Discharge Planning -->
            <div class="tab-content-item" id="tab-discharge-planning">
                <div class="section-header">
                    <h2>7. DISCHARGE PLANNING</h2>
                </div>
                @include('bph.partials.dishcharge_plan.form-dish-plan')
            </div>

            <!-- Tab 8: Edukasi -->
            <div class="tab-content-item" id="tab-edukasi">
                <div class="section-header">
                    <h2>8. EDUKASI TERINTEGRASI</h2>
                </div>
                @include('bph.partials.edukasi.form-edu-informasi-medis')
                @include('bph.partials.edukasi.form-edu-keperawatan')
                @include('bph.partials.edukasi.form-edu-konsel-gizi')
                @include('bph.partials.edukasi.form-edu-farmasi')
                @include('bph.partials.edukasi.form-edu-pengisian-form')
            </div>

            <!-- Tab 9: Terapi Medika -->
            <div class="tab-content-item" id="tab-terapi">
                <div class="section-header">
                    <h2>9. TERAPI MEDIKA MENTOSA</h2>
                </div>
                @include('bph.partials.terapimedika.form-injeksi')
                @include('bph.partials.terapimedika.form-cairan-infus')
                @include('bph.partials.terapimedika.form-obat-oral')
            </div>

            <!-- Tab 10: Tatalaksana -->
            <div class="tab-content-item" id="tab-tatalaksana">
                <div class="section-header">
                    <h2>10. TATALAKSANA/INTERVENSI (TLI)</h2>
                </div>
                @include('bph.partials.tatalaksana.form-tli-medis')
                @include('bph.partials.tatalaksana.form-tli-keperawatan')
                @include('bph.partials.tatalaksana.form-tli-gizi')
                @include('bph.partials.tatalaksana.form-tli-farmasi')
            </div>

            <!-- Tab 11: Monitoring -->
            <div class="tab-content-item" id="tab-monitoring">
                <div class="section-header">
                    <h2>11. MONITORING & EVALUASI</h2>
                    <p class="section-subtitle">Monitor Perkembangan Pasien</p>
                </div>
                @include('bph.partials.monitoring_evaluasi.form-dokter-dpjp')
                @include('bph.partials.monitoring_evaluasi.form-keperawatan')
                @include('bph.partials.monitoring_evaluasi.form-gizi')
                @include('bph.partials.monitoring_evaluasi.form-farmasi')
            </div>

            <!-- Tab 12: Mobilisasi -->
            <div class="tab-content-item" id="tab-mobilisasi">
                <div class="section-header">
                    <h2>12. MOBILISASI/REHABILITASI</h2>
                </div>
                @include('bph.partials.mobilitasi_rehabilitasi.form-medis')
                @include('bph.partials.mobilitasi_rehabilitasi.form-keperawatan')
                @include('bph.partials.mobilitasi_rehabilitasi.form-fisioterapi')
            </div>

            <!-- Tab 13: Outcome -->
            <div class="tab-content-item" id="tab-outcome">
                <div class="section-header">
                    <h2>13. OUTCOME/HASIL</h2>
                </div>
                @include('bph.partials.outcome_hasil.form-medis')
                @include('bph.partials.outcome_hasil.form-keperawatan')
                @include('bph.partials.outcome_hasil.form-gizi')
                @include('bph.partials.outcome_hasil.form-farmasi')
            </div>

            <!-- Tab 14: Kriteria Pulang -->
            <div class="tab-content-item" id="tab-kriteria-pulang">
                <div class="section-header">
                    <h2>14. KRITERIA PULANG</h2>
                </div>
                @include('bph.partials.kriteria_pulang.form-kriteria-pulang')
            </div>

            <!-- Tab 15: Rencana Pulang -->
            <div class="tab-content-item" id="tab-rencana-pulang">
                <div class="section-header">
                    <h2>15. RENCANA PULANG/EDUKASI PELAYANAN LANJUTAN</h2>
                </div>
                @include('bph.partials.rencana_pulang.form-resume-medis-keperawatan')
            </div>

            <!-- Tab 16: Varian -->
            <div class="tab-content-item" id="tab-varian">
                <div class="section-header">
                    <h2>16. VARIAN</h2>
                </div>
                @include('bph.partials.varian.form-varian')
            </div>

            <!-- Tab 17: Penanggung Jawab -->
            <div class="tab-content-item" id="tab-dokpes">
                <div class="section-header">
                    <h2>17. PENANGGUNG JAWAB</h2>
                </div>
                @include('dyps.partials.form-dokpes')
            </div>
        </div>
    </div>

    {{-- FORM ACTIONS --}}
    <div class="form-actions">
        <button type="button" class="btn-secondary-action" id="btnPrevious" style="display: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
            </svg>
            Sebelumnya
        </button>

        <button type="button" class="btn-secondary-action" onclick="window.history.back()">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
            </svg>
            Batal
        </button>

        <button type="button" class="btn-primary-action" id="btnNext">
            Selanjutnya
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
            </svg>
        </button>

        <button type="submit" class="btn-submit-action" id="btnSubmit" style="display: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
            </svg>
            Simpan Semua Data
        </button>
    </div>
</form>
@endif

{{-- Link ke JavaScript file --}}
<script src="{{ asset('js/bph/bph-navigation.js') }}"></script>

@endsection