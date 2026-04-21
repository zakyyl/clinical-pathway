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

    .btn-back {
        background: white;
        color: #456882;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: 2px solid #456882;
    }

    .btn-back:hover { background: #456882; color: white; transform: translateY(-2px); }

    .btn-edit {
        background: #1B3C53;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 12px rgba(27,60,83,0.3);
    }

    .btn-edit:hover { background: #234C6A; color: white; transform: translateY(-2px); }

    .card {
        background: white;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #456882;
        margin-bottom: 20px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e5e7eb;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .detail-item { display: flex; flex-direction: column; gap: 4px; }

    .detail-label {
        font-size: 12px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 15px;
        color: #1B3C53;
        font-weight: 500;
    }

    .badge {
        padding: 4px 14px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-admin    { background: rgba(239,68,68,0.1);   color: #dc2626; }
    .badge-dokter   { background: rgba(16,185,129,0.1);  color: #059669; }
    .badge-perawat  { background: rgba(245,158,11,0.1);  color: #d97706; }
    .badge-user     { background: rgba(27,60,83,0.1);    color: #1B3C53; }

    .avatar-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1B3C53, #456882);
        color: white;
        font-size: 32px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(27,60,83,0.3);
    }

    @media (max-width: 768px) {
        .detail-grid { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; align-items: flex-start; gap: 16px; }
    }
</style>

<div class="page-header">
    <h1 class="page-title">
        <span></span>
        Detail User
    </h1>
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('users.edit', $user->id) }}" class="btn-edit">Edit</a>
        <a href="{{ route('users.index') }}" class="btn-back">← Kembali</a>
    </div>
</div>

<div class="card">
    <div class="avatar-circle">
        {{ strtoupper(substr($user->name, 0, 1)) }}
    </div>

    <div class="section-title">Informasi User</div>

    <div class="detail-grid">
        <div class="detail-item">
            <span class="detail-label">ID User</span>
            <span class="detail-value">#{{ $user->id }}</span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Nama Lengkap</span>
            <span class="detail-value">{{ $user->name }}</span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Email</span>
            <span class="detail-value">{{ $user->email }}</span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Role</span>
            <span class="detail-value">
                <span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
            </span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Status Verifikasi Email</span>
            <span class="detail-value">
                @if($user->email_verified_at)
                    ✅ Terverifikasi pada {{ \Carbon\Carbon::parse($user->email_verified_at)->format('d/m/Y H:i') }}
                @else
                    ❌ Belum Terverifikasi
                @endif
            </span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Tanggal Registrasi</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') }}</span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Terakhir Diperbarui</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i') }}</span>
        </div>
    </div>
</div>

@endsection
