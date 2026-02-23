<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Clinical Pathway DM - {{ $data->no_rawat }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
            line-height: 1.2;
            color: #333;
            padding: 10px;
        }

        .header {
            border-bottom: 2px solid #1B3C53;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: middle;
        }

        .header-logo {
            width: 60px;
        }

        .header-logo img {
            width: 55px;
            height: 55px;
            object-fit: contain;
        }

        .header-content {
            padding-left: 10px;
        }

        .rs-name {
            font-size: 11px;
            font-weight: bold;
            color: #1B3C53;
            margin-bottom: 2px;
        }

        .title {
            font-size: 10px;
            font-weight: bold;
            color: #1B3C53;
            margin-bottom: 2px;
        }

        .subtitle {
            font-size: 7px;
            color: #666;
        }

        .header-right {
            width: 120px;
            text-align: right;
        }

        .date-label {
            font-size: 7px;
            color: #666;
        }

        .date-value {
            font-size: 8px;
            font-weight: bold;
            color: #333;
        }

        .section-header {
            background: #f1f5f9;
            padding: 4px 8px;
            margin: 8px 0 5px 0;
            border-left: 3px solid #1B3C53;
            font-weight: bold;
            color: #1B3C53;
            font-size: 9px;
        }

        .content-wrapper {
            width: 100%;
        }

        .two-column {
            width: 100%;
            border-collapse: collapse;
        }

        .column-left {
            width: 50%;
            vertical-align: top;
            padding-right: 5px;
        }

        .column-right {
            width: 50%;
            vertical-align: top;
            padding-left: 5px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table tr {
            border-bottom: 1px solid #e5e7eb;
        }

        .data-table td {
            padding: 3px 5px;
            vertical-align: top;
        }

        .data-table tr:nth-child(odd) {
            background: #fafafa;
        }

        .data-label {
            width: 40%;
            color: #64748b;
            font-weight: 500;
            font-size: 7px;
        }

        .data-value {
            width: 60%;
            color: #1e293b;
            font-weight: 600;
            font-size: 7px;
        }

        .badge-status {
            display: inline-block;
            padding: 1px 5px;
            border-radius: 2px;
            font-size: 6px;
            font-weight: bold;
        }

        .badge-ya {
            background: #bbf7d0;
            color: #166534;
        }

        .badge-tidak {
            background: #fecaca;
            color: #991b1b;
        }

        .footer {
            margin-top: 10px;
            padding-top: 5px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 6px;
            color: #999;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <table class="header-table">
            <tr>
                <td class="header-logo">
                    @if(!empty($logoBase64))
                        <img src="{{ $logoBase64 }}" alt="Logo RS">
                    @endif
                </td>
                <td class="header-content">
                    <div class="rs-name">RUMAH SAKIT BHAYANGKARA JAMBI</div>
                    <div class="title">Clinical Pathway DM</div>
                    <div class="subtitle">No. Rawat: {{ $data->no_rawat }}</div>
                </td>
                <td class="header-right">
                    <div class="date-label">Tanggal Input</div>
                    <div class="date-value">{{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y H:i') }}</div>
                </td>
            </tr>
        </table>
    </div>

    @php
    function formatLabel($text) {
        return ucwords(str_replace('_', ' ', $text));
    }

    function renderValue($value) {
        if($value === 1 || $value === '1') {
            return '<span class="badge-status badge-ya">Ya</span>';
        } elseif($value === 0 || $value === '0') {
            return '<span class="badge-status badge-tidak">Tidak</span>';
        } elseif($value === null || $value === '') {
            return '-';
        } else {
            return htmlspecialchars($value);
        }
    }

    $exclude = [
        'id','no_rawat','created_at','updated_at','deleted_at',
        'kd_dokter','id_petugas'
    ];

    $excludeAll = array_merge($exclude, [
        'no_rm','nm_pasien','jk','umur_tahun','umur','tgl_registrasi',
        'nm_dokter','nama_petugas'
    ]);

    // Ambil semua data lainnya dan convert object ke array
    $otherData = [];
    $dataArray = (array) $data;
    foreach($dataArray as $key => $value) {
        if(!in_array($key, $excludeAll)) {
            $otherData[$key] = $value;
        }
    }

    // Split data menjadi 2 kolom
    $allKeys = array_keys($otherData);
    $dataCount = count($allKeys);
    $halfCount = ceil($dataCount / 2);
    
    $leftKeys = array_slice($allKeys, 0, $halfCount);
    $rightKeys = array_slice($allKeys, $halfCount);
    @endphp

    <!-- Informasi Pasien -->
    <div class="section-header">Informasi Pasien</div>
    <table class="two-column">
        <tr>
            <td class="column-left">
                <table class="data-table">
                    <tr>
                        <td class="data-label">No. RM</td>
                        <td class="data-value">{{ $data->no_rm ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="data-label">Nama Pasien</td>
                        <td class="data-value">{{ $data->nm_pasien ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="data-label">Umur</td>
                        <td class="data-value">{{ $data->umur_tahun ?? '-' }}</td>
                    </tr>
                </table>
            </td>
            <td class="column-right">
                <table class="data-table">
                    <tr>
                        <td class="data-label">No. Rawat</td>
                        <td class="data-value">{{ $data->no_rawat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="data-label">Jenis Kelamin</td>
                        <td class="data-value">{{ isset($data->jk) && $data->jk === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td class="data-label">Tgl Registrasi</td>
                        <td class="data-value">{{ isset($data->tgl_registrasi) ? \Carbon\Carbon::parse($data->tgl_registrasi)->format('d/m/Y') : '-' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Informasi Petugas -->
    <div class="section-header">Informasi Petugas</div>
    <table class="two-column">
        <tr>
            <td class="column-left">
                <table class="data-table">
                    <tr>
                        <td class="data-label">Dokter</td>
                        <td class="data-value">{{ $data->nm_dokter ?? '-' }}</td>
                    </tr>
                </table>
            </td>
            <td class="column-right">
                <table class="data-table">
                    <tr>
                        <td class="data-label">Petugas</td>
                        <td class="data-value">{{ $data->nama_petugas ?? '-' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Data Clinical Pathway -->
    <div class="section-header">Data Clinical Pathway</div>
    <table class="two-column">
        <tr>
            <!-- Kolom Kiri -->
            <td class="column-left">
                <table class="data-table">
                    @foreach($leftKeys as $key)
                    <tr>
                        <td class="data-label">{{ formatLabel($key) }}</td>
                        <td class="data-value">{!! renderValue($otherData[$key] ?? null) !!}</td>
                    </tr>
                    @endforeach
                </table>
            </td>
            
            <!-- Kolom Kanan -->
            <td class="column-right">
                <table class="data-table">
                    @foreach($rightKeys as $key)
                    <tr>
                        <td class="data-label">{{ formatLabel($key) }}</td>
                        <td class="data-value">{!! renderValue($otherData[$key] ?? null) !!}</td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

    <div class="footer">
        Dokumen dibuat pada {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    </div>

</body>
</html>