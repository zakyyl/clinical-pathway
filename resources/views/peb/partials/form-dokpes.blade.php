<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-md p-6 mt-6">

    <!-- Header -->
    <h2 class="text-xl font-semibold text-slate-700 mb-6 border-b pb-3">
        Form Dokter & Petugas
    </h2>

    <!-- Form Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">

        <!-- Dokter -->
        <label class="font-medium text-slate-600">
            Dokter Penanggung Jawab
        </label>

        <div class="md:col-span-2">
            <select
                name="kd_dokter"
                class="w-full rounded-lg border border-slate-300 px-4 py-2
                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                       outline-none transition"
            >
                <option value="">-- Pilih Dokter --</option>

                @foreach($dokter as $d)
                    <option value="{{ $d->kd_dokter }}">
                        {{ $d->nm_dokter }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Petugas -->
        <label class="font-medium text-slate-600">
            Petugas Input
        </label>

        <div class="md:col-span-2">
            <select
                name="id_petugas"
                class="w-full rounded-lg border border-slate-300 px-4 py-2
                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                       outline-none transition"
            >
                <option value="">-- Pilih Petugas --</option>

                @foreach($petugas as $p)
                    <option value="{{ $p->id }}">
                        {{ $p->nama }}
                    </option>
                @endforeach
            </select>
        </div>

    </div>

</div>
