@extends('layouts.app')

@section('title', 'Detail Rekam Medis')
@section('page-title', 'Detail Rekam Medis')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-xl font-bold">Detail Rekam Medis</h2>

            <a href="{{ route('rekammedis.index') }}" 
                class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm rounded transition">
                ← Kembali
            </a>
        </div>

        <p><strong>Nama:</strong>
            {{ $rekam->pasien->identity->name ?? '-' }}
        </p>

        <p><strong>NIK:</strong>
            {{ $rekam->pasien->identity->identity_number ?? '-' }}
        </p>

        <p><strong>Tanggal:</strong> {{ $rekam->tanggal_periksa }}</p>

        <hr class="my-6">

        <div class="bg-gray-50 border rounded-xl p-5 shadow-sm">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Informasi Pasien</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-3 text-sm">

                <div class="flex justify-between">
                    <span class="text-gray-500">Kode Pasien</span>
                    <span class="font-medium">{{ $rekam->pasien->kode_pasien ?? '-' }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Poli</span>
                    <span class="font-medium">
                        @if($rekam->pasien->poli == 1)
                            Poli Umum
                        @endif
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Nomor Antrian</span>
                    <span class="font-medium">{{ $rekam->pasien->queue_number ?? '-' }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    <span class="font-medium capitalize">{{ $rekam->pasien->status ?? '-' }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Berat Badan</span>
                    <span class="font-medium">{{ $rekam->pasien->berat_badan ?? '-' }} kg</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Tinggi Badan</span>
                    <span class="font-medium">{{ $rekam->pasien->tinggi_badan ?? '-' }} cm</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Tensi</span>
                    <span class="font-medium">{{ $rekam->pasien->tensi ?? '-' }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Estimasi Jam</span>
                    <span class="font-medium">
                        {{ \Carbon\Carbon::parse($rekam->pasien->estimasi_jam)->format('H:i') }} WIB
                </div>

                <div class="flex justify-between md:col-span-2">
                    <span class="text-gray-500">Tanggal Kunjungan</span>
                    <span class="font-medium">
                        {{ \Carbon\Carbon::parse($rekam->pasien->visit_date)->format('d M Y') ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between md:col-span-2">
                    <span class="text-gray-500">Keluhan</span>
                    <span class="font-medium text-right">
                        {{ $rekam->pasien->keluhan ?? '-' }}
                    </span>
                </div>

            </div>
        </div>

        <form id="form-konfirmasi-obat" method="POST" action="{{ route('rekammedis.update', $rekam->id) }}">
            @csrf
            @method('PUT')

            {{-- DIAGNOSIS --}}
            <div class="mt-4">
                <label class="font-semibold">Diagnosis</label>
                <textarea name="diagnosis" class="w-full border p-2" placeholder="Tuliskan diagnosa untuk pasien..." required>{{ old('diagnosis', $rekam->diagnosis) }}</textarea>
            </div>

            {{-- RESEP OBAT --}}
            <div class="mt-6">
                <label class="font-semibold">Resep Obat</label>

                <div id="resep-container">

                    <div class="resep-item grid grid-cols-12 gap-2 mt-2">

                        {{-- Dropdown Obat --}}
                        <div class="col-span-4">
                            <select name="obat_id[]" class="w-full border p-2" required>
                                <option value="">-- Pilih Obat --</option>
                                @foreach ($obats as $obat)
                                    <option value="{{ $obat->id }}">
                                        {{ $obat->nama_obat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Jumlah --}}
                        <div class="col-span-3">
                            <input type="number" name="jumlah[]" class="w-full border p-2" placeholder="Jumlah"
                                min="1" required>
                        </div>

                        {{-- Aturan Pakai --}}
                        <div class="col-span-4">
                            <input type="text" name="aturan_pakai[]" class="w-full border p-2"
                                placeholder="Aturan pakai (3x sehari sesudah makan)">
                        </div>

                        {{-- Tombol Hapus --}}
                        <div class="col-span-1 flex items-center">
                            <button type="button" onclick="removeResep(this)" class="text-red-600 text-xl">
                                &times;
                            </button>
                        </div>

                    </div>
                </div>

                {{-- Tombol Tambah --}}
                <button type="button" onclick="addResep()" class="mt-3 bg-green-600 text-white px-3 py-1 rounded">
                    + Tambah Obat
                </button>
            </div>

            <button type="button" onclick="confirmObat()" 
                class="mt-6 bg-purple-600 text-white px-4 py-2 rounded">
                Simpan & Konfirmasi
            </button>
        </form>
    </div>

    {{-- SCRIPT DINAMIS --}}
    <script>
        function addResep() {
            const container = document.getElementById('resep-container');
            const firstItem = container.querySelector('.resep-item');
            const clone = firstItem.cloneNode(true);

            clone.querySelectorAll('input').forEach(input => input.value = '');
            clone.querySelector('select').selectedIndex = 0;

            container.appendChild(clone);
        }

        function removeResep(button) {
            const container = document.getElementById('resep-container');
            if (container.children.length > 1) {
                button.closest('.resep-item').remove();
            }
        }

        function confirmObat() {
            Swal.fire({
                title: 'Konfirmasi Pemeriksaan',
                html: `
                    <div style="text-align:left">
                        <p>Apakah Anda yakin ingin menyimpan diagnosis dan resep obat ini?</p>
                        <br>
                        <ul style="font-size:14px; color:#555">
                            <li>• Pastikan diagnosis sudah benar</li>
                            <li>• Pastikan obat dan dosis sesuai</li>
                            <li>• Data yang disimpan tidak dapat diubah sembarangan</li>
                        </ul>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#6b7280',
                confirmButtonColor: '#0c1881',
                cancelButtonText: 'Periksa kembali'
                
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-konfirmasi-obat').submit();
                }
            });
        }
    </script>
@endsection