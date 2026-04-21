@extends('layouts.app')

@section('content')

<style>
    :root {
        --primary: #1B3C53;
        --secondary: #234C6A;
        --accent: #456882;
        --light: #f8fafc;
        --border: #e2e8f0;
        --success: #10b981;
        --info: #3b82f6;
        --warning: #f59e0b;
        --danger: #ef4444;
    }

    .page-container {
        padding: 32px;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        min-height: calc(100vh - 120px);
    }

    .filter-card {
        background: white;
        border-radius: 20px;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid var(--border);
    }

    .filter-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid var(--border);
    }

    .filter-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
    }

    .filter-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary);
        margin: 0;
    }

    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        align-items: end;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .form-control {
        padding: 12px 16px;
        border: 2px solid var(--border);
        border-radius: 12px;
        font-size: 14px;
        color: #334155;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control:focus {
        border-color: var(--accent);
        outline: none;
        box-shadow: 0 0 0 3px rgba(69, 104, 130, 0.1);
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    .btn-group {
        display: flex;
        gap: 12px;
    }

    .btn-filter {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        box-shadow: 0 4px 12px rgba(27, 60, 83, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(27, 60, 83, 0.3);
    }

    .btn-secondary {
        background: white;
        color: var(--primary);
        border: 2px solid var(--border);
    }

    .btn-secondary:hover {
        border-color: var(--accent);
        background: var(--light);
    }

    .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
    }

    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        background: linear-gradient(135deg, #e0f2fe, #bae6fd);
        color: #0369a1;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
    }

    .table-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid var(--border);
    }

    .table-responsive {
        overflow-x: auto;
    }

    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        table-layout: auto; /* Membiarkan tabel menyesuaikan lebar layar */
    }

    .modern-table thead {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
    }

    .modern-table thead th {
        padding: 16px 20px;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
        border: none;
        white-space: normal; /* Mengizinkan teks header untuk turun ke bawah jika sempit */
        line-height: 1.4;
    }

    .modern-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid var(--border);
    }

    .modern-table tbody td {
        padding: 16px 20px;
        font-size: 14px;
        color: #334155;
        vertical-align: middle;
        word-break: break-word; /* Mengizinkan teks isi tabel panjang untuk turun */
    }

    .text-center {
        text-align: center !important;
    }

    .badge-jenis {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
        min-width: 90px;
    }

    .date-text {
        color: #64748b;
        font-size: 13px;
    }

    /* Mengembalikan styling penuh dari btn-detail */
    .btn-detail {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px; 
        padding: 6px 14px; 
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border-radius: 8px; 
        font-weight: 600;
        font-size: 11px; 
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 12px rgba(27, 60, 83, 0.2);
        white-space: nowrap;
    }

    .btn-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(27, 60, 83, 0.3);
        color: white;
    }

    .pagination-wrapper {
        padding: 32px;
        background: white;
        border-top: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
    }

    .pagination-info {
        font-size: 14px;
        color: #64748b;
        font-weight: 600;
        text-align: center;
    }

    .pagination-container {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .pagination {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .page-item {
        list-style: none;
    }

    .page-link {
        border-radius: 10px;
        border: 2px solid var(--border);
        color: var(--primary);
        font-weight: 700;
        padding: 10px 18px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-width: 44px;
        justify-content: center;
    }

    .page-link:hover:not(.disabled) {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(27, 60, 83, 0.2);
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border-color: var(--primary);
        color: white;
        box-shadow: 0 4px 12px rgba(27, 60, 83, 0.3);
    }

    .page-item.disabled .page-link {
        opacity: 0.4;
        cursor: not-allowed;
        border-color: var(--border);
        color: #94a3b8;
    }

    .page-numbers {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        border-radius: 10px;
    }

    .empty-state {
        padding: 80px 20px;
        text-align: center;
    }

    .empty-icon {
        font-size: 64px;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 8px;
    }

    .empty-desc {
        font-size: 14px;
        color: #64748b;
    }

    /* Penyesuaian Responsif Layar Kecil (Mobile) */
    @media (max-width: 768px) {
        .page-container {
            padding: 16px;
        }

        .filter-card {
            padding: 20px;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .btn-group {
            flex-direction: column;
        }

        .btn-filter {
            width: 100%;
            justify-content: center;
        }

        /* Memperkecil padding tabel agar muat di layar HP */
        .modern-table thead th,
        .modern-table tbody td {
            padding: 10px 8px;
            font-size: 12px;
        }

        .modern-table thead th {
            font-size: 11px;
        }

        .btn-detail {
            padding: 6px 10px;
            font-size: 11px;
        }

        .badge-jenis {
            padding: 4px 8px;
            font-size: 10px;
            min-width: auto;
            letter-spacing: 0;
        }

        .pagination-wrapper {
            padding: 20px;
        }

        .pagination-container {
            flex-direction: column;
            gap: 12px;
        }

        .page-link {
            padding: 8px 14px;
            font-size: 13px;
        }

        .page-numbers {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
</style>

<div class="page-container">
    <div class="filter-card">
        <div class="filter-header">
            <h3 class="filter-title">Filter & Pencarian</h3>
        </div>

        <form action="{{ route('dashboard.alldata') }}" method="GET" id="filterForm">
            <div class="filter-form">
                <div class="form-group">
                    <label class="form-label">Pencarian</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama, No. RM, atau No. Rawat"
                        value="{{ request('search') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Pathway</label>
                    <select name="jenis" class="form-control">
                        @foreach($jenisOptions as $key => $label)
                        <option value="{{ $key }}" {{ request('jenis')==$key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control"
                        value="{{ request('tanggal_selesai') }}">
                </div>

                <div class="form-group">
                    <div class="btn-group">
                        <button type="submit" class="btn-filter btn-primary">
                            <span>Filter</span>
                        </button>
                    </div>
                </div>
            </div>

            @if(request()->hasAny(['search', 'jenis', 'tanggal_mulai', 'tanggal_selesai']) && (request('jenis') != 'all'
            || request('search') || request('tanggal_mulai') || request('tanggal_selesai')))
            <div class="active-filters">
                <strong style="color: #64748b; font-size: 13px;">Filter Aktif:</strong>

                @if(request('search'))
                <span class="filter-badge">
                    🔍 Pencarian: "{{ request('search') }}"
                </span>
                @endif

                @if(request('jenis') && request('jenis') != 'all')
                <span class="filter-badge">
                    📋 Jenis: {{ $jenisOptions[request('jenis')] ?? request('jenis') }}
                </span>
                @endif

                @if(request('tanggal_mulai'))
                <span class="filter-badge">
                    📅 Dari: {{ \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d M Y') }}
                </span>
                @endif

                @if(request('tanggal_selesai'))
                <span class="filter-badge">
                    📅 Sampai: {{ \Carbon\Carbon::parse(request('tanggal_selesai'))->format('d M Y') }}
                </span>
                @endif
            </div>
            @endif
        </form>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>No. RM</th>
                        <th>Nama Pasien</th>
                        <th>No. Rawat</th>
                        <th class="text-center">Jenis Pathway</th>
                        <th>Tanggal Dibuat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pasien as $row)
                    <tr>
                        <td>{{ $row->no_rm }}</td>
                        <td>{{ $row->nama_pasien }}</td>
                        <td>{{ $row->no_rawat }}</td>
                        <td class="text-center">
                            @php
                            $jenisLower = strtolower($row->jenis);
                            $badgeClass = 'badge-' . $jenisLower;
                            @endphp
                            <span class="badge-jenis {{ $badgeClass }}">
                                {{ strtoupper($row->jenis) }}
                            </span>
                        </td>
                        <td>
                            <span class="date-text">
                                {{ \Carbon\Carbon::parse($row->created_at)->format('d M Y, H:i') }}
                            </span>
                        </td>
                        <td class="text-center">
                            @php
                            $routes = [
                                'hiv' => 'hiv.show',
                                'bph' => 'bph.show',
                                'peb' => 'peb.show',
                                'dm' => 'dm.show',
                                'jantung' => 'jntg.show',
                                'typh' => 'typh.show',
                                'dyps' => 'dyps.show',
                                'htsi' => 'htsi.show'
                            ];
                            $routeName = $routes[$jenisLower] ?? null;
                            @endphp

                            @if($routeName)
                            <a href="{{ route($routeName, ['no_rawat' => $row->no_rawat]) }}" class="btn-detail">
                                <span>Detail</span>
                            </a>
                            @else
                            <button class="btn-detail" disabled style="opacity: 0.5; cursor: not-allowed;">
                                <span>Detail</span>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon">📭</div>
                                <div class="empty-title">Tidak Ada Data</div>
                                <div class="empty-desc">
                                    @if(request()->hasAny(['search', 'jenis', 'tanggal_mulai', 'tanggal_selesai']))
                                    Tidak ada data yang sesuai dengan filter yang Anda pilih
                                    @else
                                    Belum ada data pathway yang tersedia
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pasien->hasPages())
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Halaman {{ $pasien->currentPage() }} dari {{ $pasien->lastPage() }} • Total {{ $pasien->total() }} data
            </div>

            <div class="pagination-container">
                <nav>
                    <ul class="pagination">
                        @if ($pasien->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">
                                <span>←</span>
                                <span>Previous</span>
                            </span>
                        </li>
                        @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $pasien->previousPageUrl() }}" rel="prev">
                                <span>←</span>
                                <span>Previous</span>
                            </a>
                        </li>
                        @endif
                        
                        <div class="page-numbers">
                            @php
                            $start = max($pasien->currentPage() - 2, 1);
                            $end = min($start + 4, $pasien->lastPage());
                            $start = max($end - 4, 1);
                            @endphp

                            @if($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $pasien->url(1) }}">1</a>
                            </li>
                            @if($start > 2)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                            @endif
                            @endif

                            @for ($i = $start; $i <= $end; $i++) 
                                @if ($i==$pasien->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $i }}</span>
                                </li>
                                @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $pasien->url($i) }}">{{ $i }}</a>
                                </li>
                                @endif
                            @endfor

                            @if($end < $pasien->lastPage())
                                @if($end < $pasien->lastPage() - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link" href="{{ $pasien->url($pasien->lastPage()) }}">{{ $pasien->lastPage() }}</a>
                                </li>
                            @endif
                        </div>

                        @if ($pasien->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $pasien->nextPageUrl() }}" rel="next">
                                <span>Next</span>
                                <span>→</span>
                            </a>
                        </li>
                        @else
                        <li class="page-item disabled">
                            <span class="page-link">
                                <span>Next</span>
                                <span>→</span>
                            </span>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection