@extends('layouts.app')

@section('content')

<style>
    .filter-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 24px;
    }

    .chart-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 24px;
    }

    .stat-box {
        background: #1B3C53;
        border-radius: 12px;
        padding: 20px;
        color: white;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(27, 60, 83, 0.3);
    }

    .stat-box h3 {
        font-size: 36px;
        font-weight: bold;
        margin: 0;
    }

    .stat-box p {
        font-size: 14px;
        opacity: 0.9;
        margin: 8px 0 0 0;
    }

    .filter-group {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .form-group {
        flex: 1;
        min-width: 200px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #456882;
        box-shadow: 0 0 0 3px rgba(69, 104, 130, 0.1);
    }

    .btn-filter {
        background: #234C6A;
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-filter:hover {
        background: #456882;
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(35, 76, 106, 0.3);
    }

    .btn-reset {
        background: white;
        color: #6b7280;
        border: 2px solid #e5e7eb;
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-reset:hover {
        border-color: #456882;
        color: #456882;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f3f4f6;
    }

    .chart-title {
        font-size: 18px;
        font-weight: bold;
        color: #1B3C53;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .gradient-header {
        background: #1B3C53;
        border-radius: 16px;
        padding: 32px;
        color: white;
        margin-bottom: 32px;
        box-shadow: 0 4px 12px rgba(27, 60, 83, 0.3);
    }

    .info-badge {
        background: rgba(227, 227, 227, 0.2);
        backdrop-filter: blur(10px);
        padding: 12px 20px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .filter-group {
            flex-direction: column;
        }

        .form-group {
            width: 100%;
        }

        .stat-box h3 {
            font-size: 28px;
        }
    }
</style>

<div class="gradient-header">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div>
            <h2 style="font-size: 32px; font-weight: bold; margin-bottom: 8px; color: #E3E3E3;">📊 Statistik & Laporan</h2>
            <p style="opacity: 0.95; font-size: 16px; color: #E3E3E3;">Analisis data HIV Clinical Pathway</p>
            @if(request('bulan_dari') || request('bulan_sampai'))
            <div class="info-badge" style="margin-top: 12px;">
                <span>📅</span>
                <span>
                    {{ request('bulan_dari') ? \Carbon\Carbon::parse(request('bulan_dari'))->isoFormat('MMMM YYYY') : 'Awal' }}
                    - 
                    {{ request('bulan_sampai') ? \Carbon\Carbon::parse(request('bulan_sampai'))->isoFormat('MMMM YYYY') : 'Akhir' }}
                </span>
            </div>
            @endif
        </div>
        <div style="font-size: 64px; opacity: 0.15;">📈</div>
    </div>
</div>

<div class="filter-card">
    <div class="chart-header">
        <h3 class="chart-title">
            <span>🔍</span> Filter Periode Data
        </h3>
    </div>

    <form method="GET" action="{{ route('statistik.index') }}">
        <div class="filter-group">
            <div class="form-group">
                <label for="bulan_dari">Dari Bulan:</label>
                <input type="month" 
                       name="bulan_dari" 
                       id="bulan_dari" 
                       class="form-control" 
                       value="{{ $bulan_dari }}"
                       max="{{ date('Y-m') }}">
            </div>

            <div class="form-group">
                <label for="bulan_sampai">Sampai Bulan:</label>
                <input type="month" 
                       name="bulan_sampai" 
                       id="bulan_sampai" 
                       class="form-control" 
                       value="{{ $bulan_sampai }}"
                       max="{{ date('Y-m') }}">
            </div>

            <div style="display: flex; gap: 12px; align-items: flex-end;">
                <button type="submit" class="btn-filter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                    Tampilkan
                </button>
                
                <a href="{{ route('statistik.index') }}" class="btn-reset">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                        <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                    </svg>
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 32px;">
    <div class="stat-box">
        <h3>{{ $totalData }}</h3>
        <p>Total Data Periode</p>
    </div>

    <div class="stat-box" style="background: #234C6A;">
        <h3>{{ $dataHariIni }}</h3>
        <p>Data Hari Ini</p>
    </div>

    <div class="stat-box" style="background: #456882;">
        <h3>{{ $dataBulanIni }}</h3>
        <p>Data Bulan Ini</p>
    </div>

</div>

<div class="chart-card">
    <div class="chart-header">
        <h3 class="chart-title">
            <span>📊</span> 
            @if(request('bulan_dari') || request('bulan_sampai'))
                Grafik Data Periode 
                ({{ request('bulan_dari') ? \Carbon\Carbon::parse(request('bulan_dari'))->isoFormat('MMM YYYY') : 'Awal' }}
                - 
                {{ request('bulan_sampai') ? \Carbon\Carbon::parse(request('bulan_sampai'))->isoFormat('MMM YYYY') : date('M Y') }})
            @else
                Grafik Data 12 Bulan Terakhir
            @endif
        </h3>
        <div style="display: flex; gap: 8px; align-items: center;">
            <div style="width: 16px; height: 16px; background: #456882; border-radius: 4px;"></div>
            <span style="font-size: 13px; color: #6b7280; font-weight: 600;">Jumlah Data</span>
        </div>
    </div>
    <canvas id="chartData" style="max-height: 450px;"></canvas>
</div>

<div style="background: #f0f5f8; padding: 20px; border-radius: 12px; border-left: 4px solid #456882;">
    <div style="display: flex; align-items: start; gap: 12px;">
        <span style="font-size: 24px;">💡</span>
        <div>
            <p style="font-weight: 600; color: #1B3C53; margin: 0 0 4px 0;">Tips:</p>
            <p style="font-size: 14px; color: #234C6A; line-height: 1.6; margin: 0;">
                Gunakan filter "Dari Bulan" dan "Sampai Bulan" untuk melihat data dalam periode tertentu. 
                Kosongkan filter untuk melihat semua data yang tersedia.
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    Chart.defaults.font.family = 'Figtree, sans-serif';
    Chart.defaults.color = '#6b7280';

    const ctx = document.getElementById('chartData').getContext('2d');
    
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(69, 104, 130, 0.9)');
    gradient.addColorStop(1, 'rgba(35, 76, 106, 0.7)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'Jumlah Data',
                data: {!! json_encode($chartData['data']) !!},
                backgroundColor: gradient,
                borderColor: '#1B3C53',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: '#456882',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(27, 60, 83, 0.95)',
                    padding: 16,
                    borderRadius: 8,
                    titleFont: { 
                        size: 15, 
                        weight: 'bold' 
                    },
                    bodyFont: { 
                        size: 14 
                    },
                    callbacks: {
                        title: function(context) {
                            return context[0].label;
                        },
                        label: function(context) {
                            return 'Total: ' + context.parsed.y + ' data';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        color: '#1B3C53'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        color: '#1B3C53'
                    },
                    grid: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    document.getElementById('bulan_dari').addEventListener('change', function() {
        const bulanSampai = document.getElementById('bulan_sampai');
        if (this.value) {
            bulanSampai.min = this.value;
        }
    });

    document.getElementById('bulan_sampai').addEventListener('change', function() {
        const bulanDari = document.getElementById('bulan_dari');
        if (this.value) {
            bulanDari.max = this.value;
        }
    });
</script>

@endsection