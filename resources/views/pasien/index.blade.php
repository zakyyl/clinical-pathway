{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Kunjungan Pasien</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No. RM</th>
                <th>Nama Pasien</th>
                <th>JK</th>
                <th>Usia</th>
                <th>Tgl Masuk</th>
                <th>Tgl Keluar</th>
                <th>Lama Rawat</th>
                <th>Diagnosa Awal</th>
                <th>Kelas</th>
                <th>Rujukan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $row)
            <tr>
                <td>{{ $row->no_rm }}</td>
                <td>{{ $row->nama_pasien }}</td>
                <td>{{ $row->jk }}</td>
                <td>{{ $row->usia }}</td>
                <td>{{ $row->tgl_masuk }}</td>
                <td>{{ $row->tgl_keluar ?? '-' }}</td>
                <td>{{ $row->lama_rawat }}</td>
                <td>{{ $row->diagnosa_awal }}</td>
                <td>{{ $row->kelas }}</td>
                <td>{{ $row->rujukan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $data->links() }}
</div>
@endsection --}}