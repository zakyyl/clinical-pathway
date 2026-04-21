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

    .btn-back:hover {
        background: #456882;
        color: white;
        transform: translateY(-2px);
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #1B3C53;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-label span.required {
        color: #ef4444;
        margin-left: 3px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        color: #374151;
        transition: all 0.2s ease;
        background: #fafafa;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #456882;
        background: white;
        box-shadow: 0 0 0 3px rgba(69,104,130,0.15);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }

    .is-invalid {
        border-color: #ef4444 !important;
    }

    .btn-submit {
        background: #1B3C53;
        color: white;
        padding: 12px 32px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(27,60,83,0.3);
        font-size: 15px;
    }

    .btn-submit:hover {
        background: #234C6A;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(27,60,83,0.4);
    }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #456882;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e5e7eb;
    }

    @media (max-width: 768px) {
        .form-row { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; align-items: flex-start; gap: 16px; }
    }
</style>

<div class="page-header">
    <h1 class="page-title">
        <span></span>
        Tambah User 
    </h1>
    <a href="{{ route('users.index') }}" class="btn-back">← Kembali</a>
</div>

<div class="card">
    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="section-title">Informasi Akun</div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="Masukkan nama lengkap">
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email <span class="required">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" placeholder="contoh@email.com">
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Password <span class="required">*</span></label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                       placeholder="Minimal 8 karakter">
                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password <span class="required">*</span></label>
                <input type="password" name="password_confirmation" class="form-control"
                       placeholder="Ulangi password">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Role <span class="required">*</span></label>
                <select name="role" class="form-control @error('role') is-invalid @enderror">
                    <option value="">-- Pilih Role --</option>
                    <option value="admin"   {{ old('role') === 'admin'   ? 'selected' : '' }}>Admin</option>
                    <option value="user"    {{ old('role') === 'user'    ? 'selected' : '' }}>User</option>
                </select>
                @error('role') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div style="margin-top: 24px; display: flex; gap: 12px;">
            <button type="submit" class="btn-submit">Simpan User</button>
            <a href="{{ route('users.index') }}" class="btn-back">Batal</a>
        </div>
    </form>
</div>

@endsection
