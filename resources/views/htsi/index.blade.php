@extends('layouts.app')

@section('content')

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #456882;
    }

    .page-title {
        font-size: 28px;
        font-weight: bold;
        color: #1B3C53;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .btn-add {
        background: #1B3C53;
        color: white;
        padding: 12px 24px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(27, 60, 83, 0.3);
    }

    .btn-add:hover {
        background: #234C6A;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(27, 60, 83, 0.4);
        color: white;
    }

    .table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table thead {
        background: #1B3C53;
        color: white;
    }

    .custom-table thead th {
        padding: 16px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .custom-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.2s ease;
    }

    .custom-table tbody tr:hover {
        background: linear-gradient(135deg, #f8fafb 0%, #f5f7f9 100%);
        transform: scale(1.01);
    }

    .custom-table tbody td {
        padding: 16px;
        color: #374151;
    }

     .btn-show {
        background: #1B3C53;
        color: white;
        padding: 4px 8px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 50;
        display: inline-flex;
        align-items: center;
        gap: 2px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(27, 60, 83, 0.3);
    }

    .btn-view {
        background: #456882;
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        border: 1px solid #456882;
    }

    .btn-view:hover {
        background: #234C6A;
        border-color: #234C6A;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(69, 104, 130, 0.4);
        color: white;
    }

    .btn-edit {
        background: white;
        color: #456882;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        border: 1px solid #456882;
    }

    .btn-edit:hover {
        background: #456882;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(69, 104, 130, 0.4);
    }

    .btn-delete {
        background: white;
        color: #ef4444;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        border: 1px solid #ef4444;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    .btn-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-primary {
        background: rgba(27, 60, 83, 0.1);
        color: #1B3C53;
    }

    .badge-secondary {
        background: rgba(35, 76, 106, 0.1);
        color: #234C6A;
    }

    .badge-success {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .badge-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }

    .badge-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9ca3af;
    }

    .empty-state-icon {
        font-size: 64px;
        margin-bottom: 16px;
        color: #456882;
        opacity: 0.5;
    }

    .empty-state-text {
        font-size: 18px;
        font-weight: 600;
        color: #234C6A;
    }

    .empty-state-subtext {
        font-size: 14px;
        color: #6b7280;
        margin-top: 8px;
    }

    /* Responsive Table */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .table-container {
            overflow-x: auto;
        }

        .custom-table {
            min-width: 600px;
        }

        .btn-group {
            flex-direction: column;
        }

        .btn-group .btn-view,
        .btn-group .btn-edit,
        .btn-group .btn-delete {
            width: 100%;
            justify-content: center;
        }
    }
</style>
<div class="page-header">
    <h1 class="page-title">
        <span>🔬</span>
        Daftar Clinical Pathway Hipertensi
    </h1>
    <button class="btn-add" onclick="window.location.href='{{ route('htsi.create') }}'">
        Tambah Pasien
    </button>
</div>

<div class="table-container">
    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">No. Rawat</th>
                <th style="width: 20%;">No. RM</th>
                <th style="width: 30%;">Nama Pasien</th>
                <th style="width: 15%;">Tanggal Input</th>
                <th style="width: 10%; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pasien as $index => $row)
            <tr>
                <td>{{ $pasien->firstItem() + $index }}</td>
                <td><strong>{{ $row->no_rawat }}</strong></td>
                <td>{{ $row->no_rm }}</td>
                <td>{{ $row->nama_pasien }}</td>
                <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y H:i') }}</td>

	<td class="text-center">
                    <a href="{{ route('htsi.show', urlencode($row->no_rawat)) }}" class="btn-show">
                        Lihat Detail
                    </a>
                </td>
                        </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <div class="empty-state-icon">📋</div>
                        <div class="empty-state-text">Belum ada data pasien</div>
                        <p style="margin-top: 8px; font-size: 14px;">Klik tombol "Tambah Pasien" untuk memulai</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ✅ PAGINATION --}}
@if($pasien->hasPages())
<div class="pagination-wrapper" style="margin-top: 20px; display: flex; justify-content: center;">
    {{ $pasien->links() }}
</div>
@endif

{{-- ✅ TAMBAHAN: Info total data --}}
<div style="text-align: center; margin-top: 10px; color: #666; font-size: 14px;">
    Menampilkan {{ $pasien->firstItem() ?? 0 }} - {{ $pasien->lastItem() ?? 0 }}
    dari {{ $pasien->total() }} data
</div>

<style>
    /* Styling untuk pagination */
    .pagination-wrapper .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        gap: 5px;
    }

    .pagination-wrapper .pagination li {
        display: inline-block;
    }

    .pagination-wrapper .pagination li a,
    .pagination-wrapper .pagination li span {
        padding: 8px 12px;
        border: 1px solid #E3E3E3;
        background: white;
        color: #333;
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.3s;
    }

    .pagination-wrapper .pagination li a:hover {
        background: #456882;
        color: white;
        border-color: #456882;
    }

    .pagination-wrapper .pagination li.active span {
        background: #1B3C53;
        color: white;
        border-color: #1B3C53;
    }

    .pagination-wrapper .pagination li.disabled span {
        color: #ccc;
        cursor: not-allowed;
        background: #f5f5f5;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-state-icon {
        font-size: 64px;
        margin-bottom: 16px;
        opacity: 0.5;
        color: #456882;
    }

    .empty-state-text {
        font-size: 18px;
        font-weight: 600;
        color: #234C6A;
    }

    .empty-state-subtext {
        font-size: 14px;
        color: #666;
        margin-top: 8px;
    }
</style>
@endsection
