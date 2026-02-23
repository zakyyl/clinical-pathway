<div class="form-hari-wrapper">
    <div class="form-hari-header">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5z" />
        </svg>
        <h4>Pilih Hari</h4>
    </div>

    <div class="form-hari-table">
        <table class="table-hari">
            <thead>
                <tr>
                    <th rowspan="2" class="col-kegiatan">KEGIATAN</th>
                    <th rowspan="2" class="col-uraian">URAIAN KEGIATAN</th>
                    <th colspan="7" class="col-hari-header">HARI PENYAKIT</th>
                    <th rowspan="2" class="col-keterangan">KETERANGAN</th>
                </tr>
                <tr class="row-hari-numbers">
                    <th class="col-number">1</th>
                    <th class="col-number">2</th>
                    <th class="col-number">3</th>
                    <th class="col-number">4</th>
                    <th class="col-number">5</th>
                    <th class="col-number">6</th>
                    <th class="col-number">7</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="static-text">Pilih Hari Penyakit</td>
                    <td class="static-text">Pilih salah satu hari penyakit pasien</td>
                    @for ($i = 1; $i <= 7; $i++) <td class="checkbox-cell">
                        <label class="checkbox-container">
                            <input type="checkbox" name="hari_penyakit_ke[]" value="{{ $i }}"
                                class="hari-penyakit-checkbox">
                            <span class="checkmark"></span>
                        </label>
                        </td>
                        @endfor
                        <td class="static-text">
                            <span class="selected-day" id="selected-penyakit">-</span>
                        </td>
                </tr>
            </tbody>
        </table>

        <table class="table-hari mt-3">
            <thead>
                <tr>
                    <th rowspan="2" class="col-kegiatan">KEGIATAN</th>
                    <th rowspan="2" class="col-uraian">URAIAN KEGIATAN</th>
                    <th colspan="7" class="col-hari-header">HARI RAWAT</th>
                    <th rowspan="2" class="col-keterangan">KETERANGAN</th>
                </tr>
                <tr class="row-hari-numbers">
                    <th class="col-number">1</th>
                    <th class="col-number">2</th>
                    <th class="col-number">3</th>
                    <th class="col-number">4</th>
                    <th class="col-number">5</th>
                    <th class="col-number">6</th>
                    <th class="col-number">7</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="static-text">Pilih Hari Rawat</td>
                    <td class="static-text">Pilih salah satu hari rawat inap pasien</td>
                    @for ($i = 1; $i <= 7; $i++) <td class="checkbox-cell">
                        <label class="checkbox-container">
                            <input type="checkbox" name="hari_rawat_ke[]" value="{{ $i }}" class="hari-rawat-checkbox">
                            <span class="checkmark"></span>
                        </label>
                        </td>
                        @endfor
                        <td class="static-text">
                            <span class="selected-day" id="selected-rawat">-</span>
                        </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Form Hari Wrapper */
    .form-hari-wrapper {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .form-hari-header {
        background: #1B3C53;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: white;
    }

    .form-hari-header h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #E3E3E3;
    }

    .form-hari-table {
        padding: 20px;
    }

    /* Table Styling */
    .table-hari {
        width: 100%;
        border-collapse: collapse;
        border: 2px solid #456882;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .table-hari thead {
        background: #1B3C53;
        color: white;
    }

    .table-hari thead th {
        padding: 14px 12px;
        text-align: center;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid rgba(227, 227, 227, 0.2);
        color: #E3E3E3;
    }

    /* Column Widths */
    .col-kegiatan {
        width: 15%;
        min-width: 120px;
    }

    .col-uraian {
        width: 25%;
        min-width: 200px;
    }

    .col-hari-header {
        background: #234C6A;
    }

    .col-number {
        width: 50px;
        font-size: 14px;
        font-weight: 700;
    }

    .col-keterangan {
        width: 15%;
        min-width: 100px;
    }

    /* Row Numbers */
    .row-hari-numbers th {
        padding: 10px 8px;
    }

    /* Table Body */
    .table-hari tbody tr {
        transition: all 0.3s ease;
    }

    .table-hari tbody tr:hover {
        background: #f8fafb;
    }

    .table-hari tbody td {
        padding: 12px;
        border: 1px solid #e0e4e8;
        vertical-align: middle;
    }

    /* Static Text */
    .static-text {
        color: #495057;
        font-size: 14px;
        font-weight: 500;
        text-align: left;
    }

    /* Selected Day Display */
    .selected-day {
        display: inline-block;
        padding: 6px 16px;
        background: #456882;
        color: white;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
        min-width: 40px;
        text-align: center;
    }

    /* Checkbox Cell */
    .checkbox-cell {
        text-align: center;
        background: #fafbfc;
        padding: 8px;
    }

    .checkbox-cell.disabled {
        background: #f0f0f0;
        opacity: 0.6;
    }

    /* Custom Checkbox */
    .checkbox-container {
        display: inline-flex;
        position: relative;
        cursor: pointer;
        user-select: none;
    }

    .checkbox-container.disabled {
        cursor: not-allowed;
        opacity: 0.5;
    }

    .checkbox-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .checkbox-container input:disabled {
        cursor: not-allowed;
    }

    .checkmark {
        display: inline-block;
        width: 24px;
        height: 24px;
        background-color: white;
        border: 2px solid #456882;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .checkbox-container:not(.disabled):hover .checkmark {
        background-color: #f0f5f8;
        transform: scale(1.1);
    }

    .checkbox-container input:checked~.checkmark {
        background: #456882;
        border-color: #456882;
    }

    .checkbox-container input:disabled~.checkmark {
        background-color: #e9ecef;
        border-color: #ced4da;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .checkbox-container input:checked~.checkmark:after {
        display: block;
    }

    .checkbox-container .checkmark:after {
        left: 7px;
        top: 3px;
        width: 6px;
        height: 11px;
        border: solid white;
        border-width: 0 2.5px 2.5px 0;
        transform: rotate(45deg);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .form-hari-table {
            overflow-x: auto;
        }

        .table-hari {
            min-width: 800px;
        }
    }

    @media (max-width: 768px) {
        .form-hari-header {
            padding: 12px 16px;
        }

        .form-hari-header h4 {
            font-size: 14px;
        }

        .form-hari-table {
            padding: 12px;
        }

        .table-hari thead th {
            padding: 10px 8px;
            font-size: 11px;
        }

        .table-hari tbody td {
            padding: 8px;
            font-size: 13px;
        }

        .col-number {
            width: 40px;
        }

        .checkmark {
            width: 20px;
            height: 20px;
        }

        .checkbox-container .checkmark:after {
            left: 6px;
            top: 2px;
            width: 5px;
            height: 9px;
        }

        .selected-day {
            padding: 4px 12px;
            font-size: 12px;
        }
    }

    /* Print Styles */
    @media print {
        .table-hari {
            border: 2px solid #000;
        }

        .table-hari thead {
            background: #e0e0e0 !important;
            color: #000 !important;
        }

        .checkmark {
            border-color: #000;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Handle Hari Penyakit Selection
    const penyakitCheckboxes = document.querySelectorAll('.hari-penyakit-checkbox');
    const selectedPenyakitDisplay = document.getElementById('selected-penyakit');
    
    penyakitCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                // Uncheck and disable all other checkboxes
                penyakitCheckboxes.forEach(cb => {
                    if (cb !== this) {
                        cb.checked = false;
                        cb.disabled = true;
                        cb.parentElement.classList.add('disabled');
                        cb.closest('.checkbox-cell').classList.add('disabled');
                    }
                });
                
                // Update display
                selectedPenyakitDisplay.textContent = 'Hari ke-' + this.value;
            } else {
                // If unchecked, enable all checkboxes
                penyakitCheckboxes.forEach(cb => {
                    cb.disabled = false;
                    cb.parentElement.classList.remove('disabled');
                    cb.closest('.checkbox-cell').classList.remove('disabled');
                });
                
                // Reset display
                selectedPenyakitDisplay.textContent = '-';
            }
        });
    });
    
    // Handle Hari Rawat Selection
    const rawatCheckboxes = document.querySelectorAll('.hari-rawat-checkbox');
    const selectedRawatDisplay = document.getElementById('selected-rawat');
    
    rawatCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                // Uncheck and disable all other checkboxes
                rawatCheckboxes.forEach(cb => {
                    if (cb !== this) {
                        cb.checked = false;
                        cb.disabled = true;
                        cb.parentElement.classList.add('disabled');
                        cb.closest('.checkbox-cell').classList.add('disabled');
                    }
                });
                
                // Update display
                selectedRawatDisplay.textContent = 'Hari ke-' + this.value;
            } else {
                // If unchecked, enable all checkboxes
                rawatCheckboxes.forEach(cb => {
                    cb.disabled = false;
                    cb.parentElement.classList.remove('disabled');
                    cb.closest('.checkbox-cell').classList.remove('disabled');
                });
                
                // Reset display
                selectedRawatDisplay.textContent = '-';
            }
        });
    });
});
</script>