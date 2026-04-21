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

    .btn-view {
        background: #456882;
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
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
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
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
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.3s ease;
        border: 1px solid #ef4444;
        cursor: pointer;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    .btn-group {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-admin {
        background: rgba(239, 68, 68, 0.1);
        color: #1B3C53;
    }

    .badge-user {
        background: rgba(27, 60, 83, 0.1);
        color: #059669;
    }

    .verified-icon {
        color: #059669;
    }

    .unverified-icon {
        color: #ef4444;
    }

    .alert {
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
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

    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination-wrapper .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        gap: 5px;
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
            min-width: 700px;
        }

        .btn-group {
            flex-direction: column;
        }
    }
</style>

@if(session('success'))
<div class="alert alert-success">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-error">❌ {{ session('error') }}</div>
@endif

<div class="page-header">
    <h1 class="page-title">
        <span></span>
        Manajemen User
    </h1>
    <button class="btn-add" onclick="window.location.href='{{ route('users.create') }}'">
        Tambah User
    </button>
</div>

<div class="table-container">
    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Nama</th>
                <th style="width: 25%;">Email</th>
                <th style="width: 10%; text-align:center;">Role</th>
                <th style="width: 25%; text-align: center;">Dibuat</th>
                <th style="width: 15%; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $index => $user)
            <tr>
                <td>{{ $users->firstItem() + $index }}</td>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->email }}</td>
                <td style="text-align:center;">
                    <span class="badge badge-{{ $user->role }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td style="text-align:center; white-space:nowrap;">
                    <div style="font-size:13px;">
                        {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}
                    </div>
                    <div style="font-size:11px; color:#6b7280;">
                        {{ \Carbon\Carbon::parse($user->created_at)->format('H:i') }}
                    </div>
                </td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="{{ route('users.show', $user->id) }}" class="btn-view">Lihat</a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn-edit">Edit</a>
                        {{-- @if(auth()->id() !== $user->id)
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">🗑 Hapus</button>
                        </form>
                        @endif --}}
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <div class="empty-state-icon">👥</div>
                        <div class="empty-state-text">Belum ada data user</div>
                        <p style="margin-top: 8px; font-size: 14px; color: #6b7280;">Klik tombol "Tambah User" untuk
                            memulai</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($users->hasPages())
<div class="pagination-wrapper">
    {{ $users->links() }}
</div>
@endif

<div style="text-align: center; margin-top: 10px; color: #666; font-size: 14px;">
    Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }}
    dari {{ $users->total() }} data
</div>

@endsection