@extends('layouts.app')

@section('content')

<style>
    @media print {
        .no-print {
            display: none;
        }
    }

    .report-container {
        max-width: 1200px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .report-header {
        border-bottom: 3px solid #1B3C53;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .report-title {
        font-size: 20px;
        font-weight: 700;
        color: #1B3C53;
        margin: 0;
    }

    .report-subtitle {
        font-size: 14px;
        color: #64748b;
        margin-top: 5px;
    }

    .section-header {
        background: #f1f5f9;
        padding: 10px 15px;
        margin: 25px 0 15px 0;
        border-left: 4px solid #1B3C53;
        font-weight: 600;
        color: #1B3C53;
        font-size: 15px;
    }

    .data-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0;
        margin-bottom: 20px;
    }

    .data-row {
        display: grid;
        grid-template-columns: 180px 1fr;
        padding: 10px 15px;
        border-bottom: 1px solid #e2e8f0;
        align-items: start;
    }

    .data-row:nth-child(odd) {
        background: #fafafa;
    }

    .data-label {
        color: #64748b;
        font-weight: 500;
        font-size: 14px;
    }

    .data-value {
        color: #1e293b;
        font-weight: 600;
        font-size: 14px;
    }

    .badge-status {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-ya {
        background: #bbf7d0;
        color: #166534;
    }

    .badge-tidak {
        background: #fecaca;
        color: #991b1b;
    }

    .btn-back {
        background: #1B3C53;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(27, 60, 83, 0.2);
    }

    .btn-back:hover {
        background: #152e3f;
        box-shadow: 0 4px 12px rgba(27, 60, 83, 0.3);
    }

    .btn-print {
        background: white;
        color: #1B3C53;
        border: 2px solid #1B3C53;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-print:hover {
        background: #1B3C53;
        color: white;
    }

    .btn-delete {
        background: #dc2626;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.2);
    }

    .btn-delete:hover {
        background: #b91c1c;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    .action-buttons {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        /* jarak antar tombol */
    }

    .action-buttons form {
        margin-left: auto;
    }
</style>

<div class="max-w-7xl mx-auto p-6">

    <div class="action-buttons no-print">
        <a href="{{ route('bph.index') }}" class="btn-back">
            ← Kembali
        </a>
        <a href="{{ route('bph.pdf', urlencode($data->no_rawat)) }}" class="btn-print" style="text-decoration: none;">
            PDF
        </a>
        <form action="{{ route('bph.destroy', $data->id) }}" method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete">
                Hapus
            </button>
        </form>

    </div>

    <div class="report-container">

        <div class="report-header">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h1 class="report-title">Detail Clinical Pathway BPH</h1>
                    <p class="report-subtitle">Periksa Data Detail {{  $data->nm_pasien }}</p>

                </div>
                <div style="text-align: right;">
                    <p style="margin: 0; color: #64748b; font-size: 13px;">Tanggal Input</p>
                    <p style="margin: 0; font-weight: 600; color: #1e293b;">
                        {{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        </div>

        @php
        function formatLabel($text) {
        return ucwords(str_replace('_', ' ', $text));
        }

        function renderValue($value) {
        if($value === 1 || $value === '1') {
        return '<span class="badge-status badge-ya">✓</span>';
        } elseif($value === 0 || $value === '0') {
        return '<span class="badge-status badge-tidak">✗</span>';
        } elseif($value === null || $value === '') {
        return '<span style="color: #94a3b8;">-</span>';
        } else {
        return htmlspecialchars($value);
        }
        }

        $exclude = [
        'id','no_rawat','created_at','updated_at','deleted_at',
        'kd_dokter','id_petugas'
        ];
        @endphp

        <div class="section-header">📋 Informasi Pasien</div>
        <div class="data-grid">
            <div class="data-row">
                <span class="data-label">No. RM</span>
                <span class="data-value">{{ $data->no_rm }}</span>
            </div>

            <div class="data-row">
                <span class="data-label">No. Rawat</span>
                <span class="data-value">{{ $data->no_rawat }}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Nama Pasien</span>
                <span class="data-value">{{ $data->nm_pasien }}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Jenis Kelamin</span>
                <span class="data-value">{{ $data->jk === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Umur</span>
                <span class="data-value">{{ $data->umur_tahun }}</span>
            </div>

            <div class="data-row">
                <span class="data-label">Tanggal Registrasi</span>
                <span class="data-value">{{ \Carbon\Carbon::parse($data->tgl_registrasi)->format('d/m/Y') }}</span>
            </div>
        </div>

        <div class="section-header">👥 Petugas Penanggung Jawab</div>
        <div class="data-grid">
            <div class="data-row">
                <span class="data-label">Dokter</span>
                <span class="data-value">{{ $data->nm_dokter ?? '-' }}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Petugas</span>
                <span class="data-value">{{ $data->nama_petugas ?? '-' }}</span>
            </div>
        </div>

        <div class="section-header">🏥 Rangkaian Kegiatan</div>
        <div class="data-grid">
            @php
            $excludeAll = array_merge($exclude, [
            'no_rm','nm_pasien','jk','umur_tahun','umur','tgl_registrasi',
            'nm_dokter','nama_petugas'
            ]);
            @endphp

            @foreach($data as $key => $value)
            @if(!in_array($key, $excludeAll))
            <div class="data-row">
                <span class="data-label">{{ formatLabel($key) }}</span>
                <span class="data-value">{!! renderValue($value) !!}</span>
            </div>
            @endif
            @endforeach
        </div>

    </div>

</div>

<script>
    window.onbeforeprint = function() {
        document.body.style.margin = '0';
    };
</script>

@endsection