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
        --success-dark: #059669;
    }

    .dashboard-container {
        min-height: calc(100vh - 120px);
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 32px;
    }

    .activity-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        background: white;
        border-radius: 24px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid var(--border);
    }

    .activity-header {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        padding: 40px 48px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .activity-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1), transparent);
        border-radius: 50%;
    }

    .activity-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .header-icon {
        width: 72px;
        height: 72px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .header-text h1 {
        font-size: 32px;
        font-weight: 800;
        margin: 0 0 8px 0;
        letter-spacing: -0.5px;
    }

    .header-text p {
        font-size: 15px;
        margin: 0;
        opacity: 0.9;
        font-weight: 500;
    }

    .activity-body {
        padding: 48px;
    }

    .activity-list {
        display: grid;
        gap: 20px;
    }

    .activity-item {
        background: white;
        border: 2px solid var(--border);
        border-left: 5px solid var(--accent);
        border-radius: 16px;
        padding: 28px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .activity-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(27, 60, 83, 0.02), rgba(69, 104, 130, 0.02));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .activity-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(27, 60, 83, 0.12);
        border-left-color: var(--primary);
        border-color: var(--accent);
    }

    .activity-item:hover::before {
        opacity: 1;
    }

    .activity-content {
        position: relative;
        z-index: 1;
    }

    .activity-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .activity-patient {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        min-width: 200px;
    }

    .patient-avatar {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        font-weight: 700;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(27, 60, 83, 0.2);
    }

    .patient-info {
        flex: 1;
    }

    .patient-name {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .activity-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        background: linear-gradient(135deg, var(--success), var(--success-dark));
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .activity-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 16px;
        padding: 20px;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 12px;
        border: 1px solid var(--border);
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .detail-label {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 15px;
        font-weight: 700;
        color: var(--primary);
    }

    .activity-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 16px;
        border-top: 1px solid var(--border);
    }

    .activity-time {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
    }

    .activity-time-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, rgba(27, 60, 83, 0.08), rgba(69, 104, 130, 0.08));
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-state-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 24px;
        background: linear-gradient(135deg, rgba(27, 60, 83, 0.05), rgba(69, 104, 130, 0.05));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 56px;
    }

    .empty-state-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 8px;
    }

    .empty-state-desc {
        font-size: 15px;
        color: #64748b;
        max-width: 400px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .empty-state-action {
        margin-top: 32px;
    }

    .btn-create {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 28px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 16px rgba(27, 60, 83, 0.3);
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(27, 60, 83, 0.4);
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 16px;
        }

        .activity-header {
            padding: 32px 24px;
        }

        .header-icon {
            width: 56px;
            height: 56px;
            font-size: 28px;
        }

        .header-text h1 {
            font-size: 24px;
        }

        .header-text p {
            font-size: 14px;
        }

        .activity-body {
            padding: 24px;
        }

        .activity-item {
            padding: 20px;
        }

        .activity-top {
            flex-direction: column;
        }

        .patient-avatar {
            width: 48px;
            height: 48px;
            font-size: 20px;
        }

        .patient-name {
            font-size: 16px;
        }

        .activity-details {
            grid-template-columns: 1fr;
            gap: 12px;
            padding: 16px;
        }

        .activity-footer {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
    }

    @media (max-width: 480px) {
        .activity-header {
            padding: 24px 20px;
        }

        .activity-header-content {
            flex-direction: column;
            text-align: center;
        }

        .header-text h1 {
            font-size: 20px;
        }

        .activity-body {
            padding: 16px;
        }

        .activity-item {
            padding: 16px;
        }
    }
</style>

        <div class="activity-header">
            <div class="activity-header-content">
                <div class="header-icon">🕐</div>
                <div class="header-text">
                    <h1>Aktivitas Terbaru</h1>
                    <p>Pantau semua aktivitas pathway dalam satu tampilan</p>
                </div>
            </div>
        </div>

        <div class="activity-body">
            <div class="activity-list">
                @forelse($recentActivities ?? [] as $activity)
                <div class="activity-item">
                    <div class="activity-content">
                        <div class="activity-top">
                            <div class="activity-patient">
                                <div class="patient-avatar">
                                    {{ strtoupper(substr($activity->nama_pasien, 0, 1)) }}
                                </div>
                                <div class="patient-info">
                                    <div class="patient-name">{{ $activity->nama_pasien }}</div>
                                </div>
                            </div>
                            <div class="activity-badge">
                                <span>📋</span>
                                <span>{{ $activity->jenis }}</span>
                            </div>
                        </div>
                        <div class="activity-details">
                            <div class="detail-item">
                                <div class="detail-label">No. Rekam Medis</div>
                                <div class="detail-value">{{ $activity->no_rm }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">No. Rawat</div>
                                <div class="detail-value">{{ $activity->no_rawat }}</div>
                            </div>
                        </div>
                        <div class="activity-footer">
                            <div class="activity-time">
                                <div class="activity-time-icon">🕐</div>
                                <span>{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <div class="empty-state-title">Belum Ada Aktivitas</div>
                    <div class="empty-state-desc">
                        Aktivitas pathway akan ditampilkan di sini. Mulai dengan membuat pathway pertama Anda.
                    </div>
                    <div class="empty-state-action">
                        <a href="{{ route('pathway.create') }}" class="btn-create">
                            <span>➕</span>
                            <span>Buat Pathway Baru</span>
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
@endsection