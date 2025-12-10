{{-- @extends('layouts.app')

@section('content')

<style>
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        transition: all 0.3s ease;
        border-left: 4px solid;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(78, 86, 192, 0.15);
    }
    
    .stat-card.primary {
        border-color: #4E56C0;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
    }
    
    .stat-card.secondary {
        border-color: #9B5DE0;
        background: linear-gradient(135deg, #ffffff 0%, #faf7ff 100%);
    }
    
    .stat-card.accent {
        border-color: #D78FEE;
        background: linear-gradient(135deg, #ffffff 0%, #fef9ff 100%);
    }
    
    .stat-card.success {
        border-color: #10b981;
        background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
    }
    
    .icon-box {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    
    .quick-action-btn {
        background: white;
        padding: 20px;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 2px solid #f0f0f0;
        cursor: pointer;
        text-decoration: none;
        display: block;
    }
    
    .quick-action-btn:hover {
        border-color: #9B5DE0;
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(155, 93, 224, 0.2);
    }
    
    .activity-item {
        padding: 16px;
        border-left: 3px solid #FDCFFA;
        background: #fafafa;
        border-radius: 8px;
        margin-bottom: 12px;
        transition: all 0.2s ease;
    }
    
    .activity-item:hover {
        background: white;
        border-left-color: #9B5DE0;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    
    .gradient-bg {
        background: linear-gradient(135deg, #4E56C0 0%, #9B5DE0 50%, #D78FEE 100%);
    }

    .chart-container {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-success {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-info {
        background: #dbeafe;
        color: #1e40af;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr !important;
        }
        
        .content-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Welcome Banner -->
<div class="gradient-bg" style="border-radius: 16px; padding: 32px; color: white; margin-bottom: 32px; box-shadow: 0 4px 12px rgba(78, 86, 192, 0.3);">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div>
            <h3 style="font-size: 32px; font-weight: bold; margin-bottom: 8px;">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
            <p style="opacity: 0.95; font-size: 16px;">Kelola clinical pathway dengan efisien dan efektif</p>
            <p style="opacity: 0.85; font-size: 14px; margin-top: 8px;">📅 {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</p>
        </div>
        <div style="font-size: 80px; opacity: 0.15;">🏥</div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 32px;">
    
    <!-- Total HIV Pathways -->
    <div class="stat-card primary">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: #6b7280; font-size: 14px; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Total HIV Pathways</p>
                <h3 style="font-size: 36px; font-weight: bold; color: #4E56C0; margin-bottom: 4px;">{{ $totalHiv }}</h3>
                <p style="font-size: 13px; color: #10b981; margin-top: 8px; font-weight: 500;">
                    <span style="margin-right: 4px;">↗</span> Pasien Aktif
                </p>
            </div>
            <div class="icon-box" style="background: rgba(78, 86, 192, 0.1);">
                <span style="color: #4E56C0; font-size: 28px;">📋</span>
            </div>
        </div>
    </div>

    <!-- Pasien Hari Ini -->
    <div class="stat-card secondary">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: #6b7280; font-size: 14px; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Pasien Hari Ini</p>
                <h3 style="font-size: 36px; font-weight: bold; color: #9B5DE0; margin-bottom: 4px;">{{ $pasienHariIni }}</h3>
                <p style="font-size: 13px; color: #6b7280; margin-top: 8px; font-weight: 500;">
                    <span style="margin-right: 4px;">📅</span> Data Terbaru
                </p>
            </div>
            <div class="icon-box" style="background: rgba(155, 93, 224, 0.1);">
                <span style="color: #9B5DE0; font-size: 28px;">👥</span>
            </div>
        </div>
    </div>

    <!-- Pasien Minggu Ini -->
    <div class="stat-card accent">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: #6b7280; font-size: 14px; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Minggu Ini</p>
                <h3 style="font-size: 36px; font-weight: bold; color: #D78FEE; margin-bottom: 4px;">{{ $pasienMingguIni }}</h3>
                <p style="font-size: 13px; color: #6b7280; margin-top: 8px; font-weight: 500;">
                    <span style="margin-right: 4px;">📊</span> 7 Hari Terakhir
                </p>
            </div>
            <div class="icon-box" style="background: rgba(215, 143, 238, 0.1);">
                <span style="color: #D78FEE; font-size: 28px;">📈</span>
            </div>
        </div>
    </div>

    <!-- Pasien Bulan Ini -->
    <div class="stat-card success">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: #6b7280; font-size: 14px; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Bulan Ini</p>
                <h3 style="font-size: 36px; font-weight: bold; color: #10b981; margin-bottom: 4px;">{{ $pasienBulanIni }}</h3>
                <p style="font-size: 13px; color: #6b7280; margin-top: 8px; font-weight: 500;">
                    <span style="margin-right: 4px;">📆</span> {{ \Carbon\Carbon::now()->isoFormat('MMMM YYYY') }}
                </p>
            </div>
            <div class="icon-box" style="background: rgba(16, 185, 129, 0.1);">
                <span style="color: #10b981; font-size: 28px;">✅</span>
            </div>
        </div>
    </div>

</div>

<!-- Quick Actions & Recent Activity -->
<div class="content-grid" style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 24px; margin-bottom: 32px;">
    
    <!-- Quick Actions -->
    <div>
        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h4 style="font-size: 18px; font-weight: bold; color: #4E56C0; display: flex; align-items: center;">
                    <span style="margin-right: 8px;">⚡</span> Quick Actions
                </h4>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <a href="{{ route('hiv.create') }}" class="quick-action-btn">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #4E56C0, #9B5DE0); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                            ➕
                        </div>
                        <div>
                            <p style="font-weight: 600; color: #1f2937; margin-bottom: 2px;">Tambah Pathway Baru</p>
                            <p style="font-size: 13px; color: #6b7280;">Buat clinical pathway HIV</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('hiv.index') }}" class="quick-action-btn">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #9B5DE0, #D78FEE); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                            📋
                        </div>
                        <div>
                            <p style="font-weight: 600; color: #1f2937; margin-bottom: 2px;">Lihat Semua Data</p>
                            <p style="font-size: 13px; color: #6b7280;">Kelola pathway HIV</p>
                        </div>
                    </div>
                </a>

                <a href="#" class="quick-action-btn">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #10b981, #34d399); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                            📊
                        </div>
                        <div>
                            <p style="font-weight: 600; color: #1f2937; margin-bottom: 2px;">Laporan & Statistik</p>
                            <p style="font-size: 13px; color: #6b7280;">Analisis data pathway</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div>
        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h4 style="font-size: 18px; font-weight: bold; color: #4E56C0; display: flex; align-items: center;">
                    <span style="margin-right: 8px;">🕒</span> Aktivitas Terbaru
                </h4>
                <a href="{{ route('hiv.index') }}" style="font-size: 13px; color: #9B5DE0; text-decoration: none; font-weight: 600;">
                    Lihat Semua →
                </a>
            </div>
            
            <div style="max-height: 400px; overflow-y: auto;">
                @forelse($recentActivities as $activity)
                <div class="activity-item">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px;">
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                <p style="font-weight: 700; color: #1f2937; font-size: 15px;">{{ $activity->nama_pasien }}</p>
                                <span class="badge badge-success">HIV</span>
                            </div>
                            <p style="font-size: 14px; color: #4b5563; margin-bottom: 4px;">
                                <span style="font-weight: 600;">No. RM:</span> {{ $activity->no_rm }} • 
                                <span style="font-weight: 600;">No. Rawat:</span> {{ $activity->no_rawat }}
                            </p>
                            <p style="font-size: 12px; color: #9ca3af; display: flex; align-items: center; gap: 4px;">
                                <span>🕐</span> {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                                <span style="margin-left: 8px;">📅</span> {{ \Carbon\Carbon::parse($activity->created_at)->isoFormat('D MMM YYYY, HH:mm') }}
                            </p>
                        </div>
                        <span style="color: #10b981; font-size: 24px; flex-shrink: 0;">✓</span>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 40px 20px; color: #9ca3af;">
                    <div style="font-size: 48px; margin-bottom: 12px;">📭</div>
                    <p style="font-weight: 600; color: #6b7280;">Belum ada aktivitas</p>
                    <p style="font-size: 14px; margin-top: 4px;">Data akan muncul setelah ada pathway baru</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

<!-- Additional Info Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">
    
    <div class="chart-container">
        <h5 style="font-size: 16px; font-weight: bold; color: #1f2937; margin-bottom: 16px; display: flex; align-items: center;">
            <span style="margin-right: 8px;">💡</span> Tips Hari Ini
        </h5>
        <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 16px; border-radius: 12px; border-left: 4px solid #f59e0b;">
            <p style="font-size: 14px; color: #78350f; line-height: 1.6;">
                Pastikan semua data pasien HIV diisi dengan lengkap dan akurat untuk memastikan kualitas layanan clinical pathway yang optimal.
            </p>
        </div>
    </div>

    <div class="chart-container">
        <h5 style="font-size: 16px; font-weight: bold; color: #1f2937; margin-bottom: 16px; display: flex; align-items: center;">
            <span style="margin-right: 8px;">📢</span> Pengumuman
        </h5>
        <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 16px; border-radius: 12px; border-left: 4px solid #3b82f6;">
            <p style="font-size: 14px; color: #1e40af; line-height: 1.6;">
                Sistem clinical pathway telah diperbarui dengan fitur baru untuk meningkatkan efisiensi pengelolaan data pasien.
            </p>
        </div>
    </div>

</div>

@endsection --}}