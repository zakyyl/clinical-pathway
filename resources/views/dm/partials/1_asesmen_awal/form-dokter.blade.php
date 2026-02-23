@push('styles')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endpush

<div class="judul-wrapper">
    <div class="judul-table-container">
        <table class="judul-table">
            <thead>
                <tr>
                    <th class="col-label">KEGIATAN</th>
                    <th class="col-form">PILIHAN</th>
                    <th class="col-keterangan">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="cell-label">
                        <div class="label-content">
                            <span class="label-prefix">a.</span>
                            <span class="label-text">Asesmen Awal Medis</span>
                        </div>
                    </td>

                    <td class="cell-checkbox">
                        <div class="checkbox-vertical-group">
                            <label class="custom-checkbox">
                                <input type="checkbox" name="1a_dokter_igd" value="1">
                                <span class="checkbox-box"></span>
                                <span class="checkbox-label">Dokter IGD</span>
                            </label>
                            <label class="custom-checkbox">
                                <input type="checkbox" name="1a_dokter_spesialis" value="1">
                                <span class="checkbox-box"></span>
                                <span class="checkbox-label">Dokter Spesialis</span>
                            </label>
                        </div>
                    </td>
                    <td class="cell-keterangan">
                        <div class="keterangan-vertical-group">
                            <span class="keterangan-text">Pasien Masuk Via IGD</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

