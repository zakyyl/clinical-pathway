@extends('layouts.app')

@section('content')

<div class="modern-page-header">
    <div class="header-content">
        <div class="icon-wrapper" onclick="window.location.href='{{ route('typh.create') }}'" style="cursor:pointer;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path
                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
            </svg>
        </div>

        <div>
            <h1 class="page-title">Tambah Clinical Pathway Typhoid Pada Anak</h1>
            <p class="page-subtitle">Lengkapi formulir clinical pathway untuk pasien</p>
        </div>
    </div>
</div>

@if (!$data)
@include('typh.partials.modal-cari-pasien')

<script>
    document.addEventListener('DOMContentLoaded', function() {
            openModal();
        });
</script>
@endif

@if ($data)

<form action="{{ route('typh.store') }}" method="POST" id="typhForm">
    @csrf

    <input type="hidden" name="no_rawat" value="{{ $data->no_rawat }}">

    <div class="patient-info-card">
        <div class="card-header-custom">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
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

    <div class="form-section-card">
        @include('typh.partials.form-hari')
    </div>

    <div class="progress-container">
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill"></div>
        </div>
        <div class="progress-text">
            <span id="currentStep">1</span> dari <span id="totalSteps">16</span> Tahap
        </div>
    </div>

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

        <!-- Tab Content -->
        <div class="tabs-content">

            <!-- Tab 1: Asesmen Awal -->
            <div class="tab-content-item active" id="tab-asesmen-awal">
                <div class="section-header">
                    <h2>1. ASESMEN AWAL</h2>
                </div>
                @include('typh.partials.1_asesmen_awal.form-dokter')
                @include('typh.partials.1_asesmen_awal.form-keperawatan')
            </div>

            <!-- Tab 2: Laboratorium -->
            <div class="tab-content-item" id="tab-laboratorium">
                <div class="section-header">
                    <h2>2. LABORATORIUM</h2>
                </div>
                @include('typh.partials.2_laboratorium.form-labor')
            </div>

            <!-- Tab 3: Radiologi -->
            <div class="tab-content-item" id="tab-radiologi">
                <div class="section-header">
                    <h2>3. RADIOLOGI</h2>
                </div>
                @include('typh.partials.3_radiologi.form-radiologi')
            </div>

            <!-- Tab 4: Konsultasi -->
            <div class="tab-content-item" id="tab-konsultasi">
                <div class="section-header">
                    <h2>4. KONSULTASI</h2>
                </div>
                @include('typh.partials.4_konsultasi.form-konsultasi')
            </div>

            <!-- Tab 5: Asesmen Lanjutan -->
            <div class="tab-content-item" id="tab-asesmen-lanjutan">
                <div class="section-header">
                    <h2>5. ASESMEN LANJUTAN</h2>
                </div>
                @include('typh.partials.5_asesmen_lanjut.form-lanjut-dokter')
                @include('typh.partials.5_asesmen_lanjut.form-lanjut-keperawatan')
                @include('typh.partials.5_asesmen_lanjut.form-gizi')
                @include('typh.partials.5_asesmen_lanjut.form-farmasi')
            </div>

            <!-- Tab 6: Diagnosis -->
            <div class="tab-content-item" id="tab-diagnosis">
                <div class="section-header">
                    <h2>6. DIAGNOSIS</h2>
                    <p class="section-subtitle">typh</p>
                </div>
                @include('typh.partials.6_diagnosis.form-diag-keperawatan')
                @include('typh.partials.6_diagnosis.form-diag-gizi')
            </div>

            <!-- Tab 7: Discharge Planning -->
            <div class="tab-content-item" id="tab-discharge-planning">
                <div class="section-header">
                    <h2>7. DISCHARGE PLANNING</h2>
                </div>
                @include('typh.partials.7_dishcharge_plan.form-dish-plan')
            </div>

            <!-- Tab 8: Edukasi -->
            <div class="tab-content-item" id="tab-edukasi">
                <div class="section-header">
                    <h2>8. EDUKASI TERINTEGRASI</h2>
                </div>
                @include('typh.partials.8_edukasi.form-edu-informasi-medis')
                @include('typh.partials.8_edukasi.form-edu-keperawatan')
                @include('typh.partials.8_edukasi.form-edu-konsel-gizi')
                @include('typh.partials.8_edukasi.form-edu-farmasi')
                @include('typh.partials.8_edukasi.form-edu-pengisian-form')
            </div>

            <!-- Tab 9: Terapi Medika -->
            <div class="tab-content-item" id="tab-terapi">
                <div class="section-header">
                    <h2>9. TERAPI MEDIKA MENTOSA</h2>
                </div>
                @include('typh.partials.9_terapimedika.form-injeksi')
                @include('typh.partials.9_terapimedika.form-cairan-infus')
                @include('typh.partials.9_terapimedika.form-obat-oral')
                @include('typh.partials.9_terapimedika.form-obat-pulang')
            </div>

            <!-- Tab 10: Tatalaksana -->
            <div class="tab-content-item" id="tab-tatalaksana">
                <div class="section-header">
                    <h2>10. TATALAKSANA/INTERVENSI (TLI)</h2>
                </div>
                @include('typh.partials.10_tatalaksana.form-tli-medis')
                @include('typh.partials.10_tatalaksana.form-tli-keperawatan')
                @include('typh.partials.10_tatalaksana.form-tli-gizi')
                @include('typh.partials.10_tatalaksana.form-tli-farmasi')
            </div>

            <!-- Tab 11: Monitoring -->
            <div class="tab-content-item" id="tab-monitoring">
                <div class="section-header">
                    <h2>11. MONITORING & EVALUASI</h2>
                    <p class="section-subtitle">Monitor Perkembangan Pasien</p>
                </div>
                @include('typh.partials.11_monitoring_evaluasi.form-dokter-dpjp')
                @include('typh.partials.11_monitoring_evaluasi.form-keperawatan')
                @include('typh.partials.11_monitoring_evaluasi.form-gizi')
                @include('typh.partials.11_monitoring_evaluasi.form-farmasi')
            </div>

            <!-- Tab 12: Mobilisasi -->
            <div class="tab-content-item" id="tab-mobilisasi">
                <div class="section-header">
                    <h2>12. MOBILISASI/REHABILITASI</h2>
                </div>
                @include('typh.partials.12_mobilitasi_rehabilitasi.form-medis')
                @include('typh.partials.12_mobilitasi_rehabilitasi.form-keperawatan')
                @include('typh.partials.12_mobilitasi_rehabilitasi.form-fisioterapi')
            </div>

            <!-- Tab 13: Outcome -->
            <div class="tab-content-item" id="tab-outcome">
                <div class="section-header">
                    <h2>13. OUTCOME/HASIL</h2>
                </div>
                @include('typh.partials.13_outcome_hasil.form-medis')
                @include('typh.partials.13_outcome_hasil.form-keperawatan')
                @include('typh.partials.13_outcome_hasil.form-gizi')
                @include('typh.partials.13_outcome_hasil.form-farmasi')
            </div>

            <!-- Tab 14: Kriteria Pulang -->
            <div class="tab-content-item" id="tab-kriteria-pulang">
                <div class="section-header">
                    <h2>14. KRITERIA PULANG</h2>
                </div>
                @include('typh.partials.14_kriteria_pulang.form-kriteria-pulang')
            </div>

            <!-- Tab 15: Rencana Pulang -->
            <div class="tab-content-item" id="tab-rencana-pulang">
                <div class="section-header">
                    <h2>15. RENCANA PULANG/EDUKASI PELAYANAN LANJUTAN</h2>
                </div>
                @include('typh.partials.15_rencana_pulang.form-resume-medis-keperawatan')
            </div>

            <!-- Tab 16: Varian -->
            <div class="tab-content-item" id="tab-varian">
                <div class="section-header">
                    <h2>VARIAN</h2>
                </div>
                @include('typh.partials.16_varian.form-varian')
            </div>
            <div class="tab-content-item" id="tab-dokpes">
                <div class="section-header">
                    <h2>Form Penanggung Jawab</h2>
                </div>
                @include('dyps.partials.form-dokpes')
            </div>

        </div>
    </div>

    <div class="form-actions">
        <button type="button" class="btn-secondary-action" id="btnPrevious" style="display: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
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
                <path fill-rule="evenodd"
                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
            </svg>
        </button>

        <button type="submit" class="btn-submit-action" id="btnSubmit" style="display: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
            </svg>
            Simpan Semua Data
        </button>
    </div>
</form>

@endif

<style>
    /* Modern Page Header */
    .modern-page-header {
        background: #1B3C53;
        border-radius: 16px;
        padding: 32px;
        margin-bottom: 32px;
        box-shadow: 0 10px 30px rgba(27, 60, 83, 0.3);
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .icon-wrapper {
        background: rgba(227, 227, 227, 0.2);
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .page-title {
        color: #E3E3E3;
        font-size: 28px;
        font-weight: 700;
        margin: 0;
    }

    .page-subtitle {
        color: rgba(227, 227, 227, 0.9);
        margin: 4px 0 0 0;
        font-size: 14px;
    }

    /* Progress Indicator */
    .progress-container {
        background: white;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .progress-bar {
        width: 100%;
        height: 12px;
        background: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 12px;
    }

    .progress-fill {
        height: 100%;
        background: #456882;
        border-radius: 10px;
        transition: width 0.4s ease;
        width: 6.25%;
    }

    .progress-text {
        text-align: center;
        color: #6c757d;
        font-weight: 600;
        font-size: 14px;
    }

    /* Patient Info Card */
    .patient-info-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        margin-bottom: 24px;
    }

    .card-header-custom {
        background: #1B3C53;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: white;
    }

    .card-header-custom h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #E3E3E3;
    }

    .patient-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        padding: 24px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .info-label {
        font-size: 12px;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 16px;
        color: #212529;
        font-weight: 600;
    }

    /* Form Section Card */
    .form-section-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        margin-bottom: 24px;
    }

    /* Modern Tabs */
    .modern-tabs-wrapper {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 32px;
    }

    .tabs-header {
        display: flex;
        flex-wrap: wrap;
        background: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        overflow-x: auto;
        gap: 4px;
        padding: 8px;
    }

    .tab-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        background: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
        font-weight: 500;
        color: #495057;
        white-space: nowrap;
    }

    .tab-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: #e9ecef;
    }

    .tab-btn:not(:disabled):hover {
        background: #456882;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(69, 104, 130, 0.3);
    }

    .tab-btn.active {
        background: #1B3C53;
        color: white;
        box-shadow: 0 4px 12px rgba(27, 60, 83, 0.3);
    }

    .tab-btn.completed {
        background: #10b981;
        color: white;
    }

    .tab-number {
        background: rgba(255, 255, 255, 0.2);
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 12px;
    }

    .tab-btn.active .tab-number,
    .tab-btn.completed .tab-number {
        background: rgba(255, 255, 255, 0.3);
    }

    .tab-text {
        font-weight: 600;
    }

    /* Tab Content */
    .tabs-content {
        padding: 32px;
    }

    .tab-content-item {
        display: none;
        animation: fadeInUp 0.4s ease;
    }

    .tab-content-item.active {
        display: block;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Section Header */
    .section-header {
        margin-bottom: 32px;
        padding-bottom: 16px;
        border-bottom: 3px solid #456882;
    }

    .section-header h2 {
        color: #1B3C53;
        font-size: 24px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .section-subtitle {
        color: #6c757d;
        font-size: 14px;
        margin: 0;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 16px;
        justify-content: flex-end;
        padding: 24px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .btn-primary-action {
        background: #234C6A;
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary-action:hover {
        background: #456882;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(35, 76, 106, 0.3);
    }

    .btn-submit-action {
        background: #10b981;
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-submit-action:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }

    .btn-secondary-action {
        background: white;
        color: #495057;
        border: 2px solid #dee2e6;
        padding: 14px 32px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-secondary-action:hover {
        background: #f8f9fa;
        border-color: #456882;
        color: #456882;
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .patient-info-grid {
            grid-template-columns: 1fr 1fr;
        }

        .tabs-header {
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 8px; /* For scrollbar */
        }

        .tab-btn {
            white-space: nowrap;
            flex-shrink: 0;
        }
    }

    @media (max-width: 768px) {
        .modern-page-header {
            padding: 24px;
        }

        .header-content {
            flex-direction: column;
            text-align: center;
        }

        .page-title {
            font-size: 22px;
        }

        .patient-info-grid {
            grid-template-columns: 1fr;
        }

        .tabs-header {
            flex-direction: row;
        }

        .tab-btn {
            width: auto;
            justify-content: flex-start;
        }

        .tabs-content {
            padding: 16px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-primary-action,
        .btn-secondary-action,
        .btn-submit-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content-item');
        const btnPrevious = document.getElementById('btnPrevious');
        const btnNext = document.getElementById('btnNext');
        const btnSubmit = document.getElementById('btnSubmit');
        const progressFill = document.getElementById('progressFill');
        const currentStepEl = document.getElementById('currentStep');
        const totalSteps = tabButtons.length;
        
        let currentTabIndex = 0;
        let maxUnlockedTab = 0; 

        updateButtonsAndProgress();

        tabButtons.forEach((button, index) => {
            button.addEventListener('click', function() {
                if (!this.disabled) {
                    switchToTab(index);
                }
            });
        });

        btnPrevious.addEventListener('click', function() {
            if (currentTabIndex > 0) {
                switchToTab(currentTabIndex - 1);
            }
        });

        btnNext.addEventListener('click', function() {
            if (currentTabIndex < totalSteps - 1) {
                tabButtons[currentTabIndex].classList.add('completed');
                
                if (currentTabIndex + 1 > maxUnlockedTab) {
                    maxUnlockedTab = currentTabIndex + 1;
                    tabButtons[maxUnlockedTab].disabled = false;
                }
                
                switchToTab(currentTabIndex + 1);
            }
        });

        function switchToTab(index) {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            tabButtons[index].classList.add('active');
            tabContents[index].classList.add('active');
            
            currentTabIndex = index;
            
            updateButtonsAndProgress();
            
            window.scrollTo({
                top: document.querySelector('.tabs-content').offsetTop - 20,
                behavior: 'smooth'
            });
        }

        function updateButtonsAndProgress() {
            const progress = ((currentTabIndex + 1) / totalSteps) * 100;
            progressFill.style.width = progress + '%';
            currentStepEl.textContent = currentTabIndex + 1;
            
            if (currentTabIndex === 0) {
                btnPrevious.style.display = 'none';
            } else {
                btnPrevious.style.display = 'flex';
            }
            
            if (currentTabIndex === totalSteps - 1) {
                btnNext.style.display = 'none';
                btnSubmit.style.display = 'flex';
            } else {
                btnNext.style.display = 'flex';
                btnSubmit.style.display = 'none';
            }
        }
    });
</script>

@endsection