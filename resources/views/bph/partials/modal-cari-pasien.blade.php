@push('modals')
<div id="modalCariPasien" class="modal-overlay" style="display:none;">
    <div class="modal-container">
        <div class="modal-box">

            <!-- Header dengan Gradient -->
            <div class="modal-header-gradient">
                <div class="header-content">
                    <div class="icon-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </div>
                    <h4 style="margin: 0; font-weight: 700;">Cari Data Pasien</h4>
                </div>
            </div>

            <!-- Body -->
            <div class="modal-body-content">
                <!-- Input Search dengan Icon -->
                <div class="input-wrapper">
                    <span class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                        </svg>
                    </span>
                    <input type="text" id="inputCariRm" class="input-search" placeholder="Masukkan Nomor Rekam Medis">
                </div>

                <!-- Tombol Cari -->
                <button class="btn-cari-pasien" id="btnCariPasien" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                    Cari Pasien
                </button>

                <!-- Result Area -->
                <div id="resultCariPasien"></div>

                <!-- Tombol Tutup -->
                <button class="btn-tutup" onclick="hideModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path
                            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                    </svg>
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>

<style>
    /* Reset semua style yang mungkin conflict */
    .modal-overlay * {
        box-sizing: border-box;
    }

    /* Modal Overlay */
    .modal-overlay {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        background: rgba(0, 0, 0, 0.6) !important;
        backdrop-filter: blur(5px);
        z-index: 99999 !important;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        margin: 0 !important;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Modal Container */
    .modal-container {
        width: 100%;
        max-width: 900px;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Modal Box */
    .modal-box {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    }

    /* Header */
    .modal-header-gradient {
        background: #1B3C53;
        padding: 24px;
        color: white;
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .icon-circle {
        background: rgba(227, 227, 227, 0.25);
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .header-content h4 {
        color: #E3E3E3;
    }

    /* Body */
    .modal-body-content {
        padding: 32px;
    }

    /* Input Wrapper */
    .input-wrapper {
        position: relative;
        margin-bottom: 24px;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        pointer-events: none;
    }

    .input-search {
        width: 100%;
        padding: 16px 16px 16px 50px;
        font-size: 16px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .input-search:focus {
        outline: none;
        border-color: #456882;
        box-shadow: 0 0 0 4px rgba(69, 104, 130, 0.1);
        transform: translateY(-2px);
    }

    /* Button Cari */
    .btn-cari-pasien {
        width: 100%;
        padding: 16px;
        background: #234C6A;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 24px;
    }

    .btn-cari-pasien:not(:disabled):hover {
        background: #456882;
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(35, 76, 106, 0.3);
    }

    .btn-cari-pasien:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Button Tutup */
    .btn-tutup {
        width: 100%;
        padding: 16px;
        background: #f8f9fa;
        color: #495057;
        border: 2px solid #dee2e6;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 16px;
    }

    .btn-tutup:hover {
        background: #e9ecef;
        border-color: #456882;
        color: #456882;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Result Container */
    #resultCariPasien {
        margin-bottom: 16px;
    }

    /* Table Styling */
    .result-table-wrapper {
        animation: fadeInUp 0.4s ease;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .result-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .result-table thead {
        background: #1B3C53;
        color: white;
    }

    .result-table thead th {
        padding: 16px;
        text-align: left;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
        color: #E3E3E3;
    }

    .result-table tbody tr {
        transition: all 0.3s ease;
        background: white;
    }

    .result-table tbody tr:hover {
        background: #f8fafb;
        transform: scale(1.01);
    }

    .result-table tbody td {
        padding: 16px;
        border-bottom: 1px solid #e9ecef;
    }

    /* Badge No RM */
    .badge-no-rm {
        background: #456882;
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        display: inline-block;
    }

    /* Badge No Rawat */
    .badge-no-rawat {
        background: #f8f9fa;
        color: #495057;
        padding: 6px 12px;
        border-radius: 6px;
        border: 1px solid #dee2e6;
        font-size: 14px;
    }

    /* Button Pilih */
    .btn-pilih {
        background: #10b981;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
    }

    .btn-pilih:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(16, 185, 129, 0.3);
    }

    /* Alert Styling */
    .alert-box {
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        animation: fadeInUp 0.4s ease;
        font-weight: 500;
    }

    .alert-info {
        background: #234C6A;
        color: white;
    }

    .alert-danger {
        background: #e74c3c;
        color: white;
    }

    .spinner-border {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .modal-overlay {
            padding: 10px;
        }

        .modal-body-content {
            padding: 20px;
        }

        .result-table {
            font-size: 14px;
        }

        .result-table thead th,
        .result-table tbody td {
            padding: 12px 8px;
        }
    }
</style>

<script>
    // --- Modal Control ---
function openModal() {
    const modal = document.getElementById('modalCariPasien');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function hideModal() {
    const modal = document.getElementById('modalCariPasien');
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

// --- Anti Spam ---
let isSearching = false;

// --- Toggle Tombol ---
const inputCariRm = document.getElementById('inputCariRm');
const btnCari = document.getElementById('btnCariPasien');

inputCariRm.addEventListener('input', () => {
    btnCari.disabled = inputCariRm.value.trim() === "";
});

// --- Cari Pasien ---
function cariPasien() {
    if (isSearching) return;
    isSearching = true;

    let no_rm = inputCariRm.value.trim();
    let box = document.getElementById('resultCariPasien');
    box.innerHTML = `
        <div class='alert-box alert-info'>
            <span class="spinner-border"></span>
            <div style="margin-top: 8px;">Mencari data pasien...</div>
        </div>
    `;

    fetch('{{ route("bph.find") }}', {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ no_rm })
    })
    .then(res => res.json())
    .then(res => {
        isSearching = false;

        if (!res.data || res.data.length === 0) {
            box.innerHTML = `
                <div class='alert-box alert-danger'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16" style="margin-bottom: 8px;">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                    </svg>
                    <div style="font-size: 16px; margin-bottom: 4px;">Pasien tidak ditemukan</div>
                    <small style="opacity: 0.9;">Silakan periksa kembali nomor rekam medis</small>
                </div>
            `;
            return;
        }

        let html = `
            <div class="result-table-wrapper">
                <table class="result-table">
                    <thead>
                        <tr>
                            <th>No RM</th>
                            <th>Nama Pasien</th>
                            <th>No Rawat</th>
                            <th>Tanggal</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        res.data.forEach(item => {
            html += `
                <tr>
                    <td><span class="badge-no-rm">${item.no_rm}</span></td>
                    <td style="font-weight: 500;">${item.nama_pasien}</td>
                    <td><span class="badge-no-rawat">${item.no_rawat}</span></td>
                    <td>
                        
                        ${item.tgl_registrasi}
                    </td>
                    <td style="text-align: center;">
                        <button class="btn-pilih" onclick="pilihPasien('${item.no_rawat}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                            </svg>
                            Pilih
                        </button>
                    </td>
                </tr>
            `;
        });

        html += `
                    </tbody>
                </table>
            </div>
        `;

        box.innerHTML = html;
    })
    .catch(() => {
        isSearching = false;
        box.innerHTML = `
            <div class='alert-box alert-danger'>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16" style="margin-bottom: 8px;">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <div style="font-size: 16px; margin-bottom: 4px;">Terjadi kesalahan server</div>
                <small style="opacity: 0.9;">Silakan coba lagi dalam beberapa saat</small>
            </div>
        `;
    });
}

// --- Pilih Pasien ---
function pilihPasien(no_rawat) {
    hideModal();
    window.location.href = "/bph/create?no_rawat=" + no_rawat;
}

btnCari.addEventListener('click', cariPasien);

// Enter key support
inputCariRm.addEventListener('keypress', (e) => {
    if (e.key === 'Enter' && !btnCari.disabled) {
        cariPasien();
    }
});

// Close modal saat klik outside
document.getElementById('modalCariPasien').addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        hideModal();
    }
});
</script>
@endpush