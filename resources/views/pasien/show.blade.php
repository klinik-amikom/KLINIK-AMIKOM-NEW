@extends('layouts.app')

@section('title', 'Detail Pasien')
@section('page-title', 'Detail Pasien')

@section('content')

    @php
        $steps = ['menunggu_konfirmasi', 'terdaftar', 'diperiksa', 'menunggu_obat', 'selesai'];
        $currentIndex = array_search($pasien->status, $steps);
        $currentIndex = $currentIndex === false ? -1 : $currentIndex;

        $statusColor = match ($pasien->status) {
            'menunggu_konfirmasi' => 'bg-gray-100 text-gray-700',
            'terdaftar' => 'bg-yellow-100 text-yellow-700',
            'diperiksa' => 'bg-blue-100 text-blue-700',
            'menunggu_obat' => 'bg-purple-100 text-purple-700',
            'selesai' => 'bg-green-100 text-green-700',
            default => 'bg-gray-100 text-gray-700',
        };
    @endphp

    <div class="max-w-7xl mx-auto px-4 py-6">

        {{-- TOMBOL BACK --}}
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-xl font-bold">Detail Pasien</h2>

            {{-- tombol konsisten --}}
            <a href="{{ route(auth()->user()->role . '.pasien.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm rounded transition">
                ← Kembali
            </a>
        </div>

        {{-- INFORMASI PASIEN --}}
        <div class="bg-white shadow rounded-lg p-8 mb-8">
            <h2 class="text-xl font-semibold mb-8 text-purple-700">Data Pasien</h2>

            <div class="grid grid-cols-2 gap-x-16 gap-y-4 text-sm">

                <div class="flex">
                    <span class="w-40 font-semibold">Kode Pasien</span>
                    <span>: <span class="text-purple-600 font-bold ml-1">{{ $pasien->kode_pasien }}</span></span>
                </div>

                <div class="flex">
                    <span class="w-40 font-semibold">No Antrian</span>
                    <span>: {{ $pasien->queue_number ?? '-' }}</span>
                </div>

                <div class="flex">
                    <span class="w-40 font-semibold">Tgl Daftar</span>
                    <span>: {{ \Carbon\Carbon::parse($pasien->created_at)->format('d-m-Y') }}</span>
                </div>

                <div class="flex">
                    <span class="w-40 font-semibold">Jam Daftar</span>
                    <span>: {{ \Carbon\Carbon::parse($pasien->created_at)->format('H:i') }}</span>
                </div>

                <div class="flex">
                    <span class="w-40 font-semibold">Estimasi Kedatangan</span>
                    <span>:
                        {{ $pasien->estimasi_jam ? \Carbon\Carbon::parse($pasien->estimasi_jam)->format('H:i') : '-' }}</span>
                </div>

                <div class="flex">
                    <span class="w-40 font-semibold">No Identitas</span>
                    <span>: {{ $pasien->identity->identity_number ?? '-' }}</span>
                </div>

                <div class="flex">
                    <span class="w-40 font-semibold">Nama</span>
                    <span>: {{ $pasien->identity->name ?? '-' }}</span>
                </div>

                <div class="flex">
                    <span class="w-40 font-semibold">Kategori</span>
                    <span>: {{ ucfirst($pasien->identity->identity_type ?? '-') }}</span>
                </div>

                <div class="flex">
                    <span class="w-40 font-semibold">Tanggal Lahir</span>
                    <span>:
                        {{ $pasien->identity->birth_date ? \Carbon\Carbon::parse($pasien->identity->birth_date)->format('d M Y') : '-' }}</span>
                </div>

                <div class="flex">
                    <span class="w-40 font-semibold">Jenis Kelamin</span>
                    <span>: {{ $pasien->identity->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>

                <div class="flex">
                    <span class="w-40 font-semibold">No. Telepon</span>
                    <span>: {{ $pasien->identity->no_telp ?? '-' }}</span>
                </div>

                <div class="flex">
                    <span class="w-40 font-semibold">Alamat</span>
                    <span>: {{ $pasien->identity->address ?? '-' }}</span>
                </div>

                <div class="flex">
                    <span class="w-40 font-semibold">Poli</span>
                    <span>: 
                        @if($pasien->poli == 1)
                            Poli Umum
                        @endif
                    </span>
                </div>

                <div class="flex">
                    <span class="w-40 font-semibold">Tensi</span>
                    <span>: {{ $pasien->tensi ?? '-' }}</span>
                </div>

                <div class="flex">
                    <span class="w-40 font-semibold">Berat Badan</span>
                    <span>: {{ $pasien->berat_badan ? $pasien->berat_badan . ' kg' : '-' }}</span>
                </div>

                <div class="flex">
                    <span class="w-40 font-semibold">Tinggi Badan</span>
                    <span>: {{ $pasien->tinggi_badan ? $pasien->tinggi_badan . ' cm' : '-' }}</span>
                </div>

                <div class="flex col-span-2">
                    <span class="w-40 font-semibold">Keluhan</span>
                    <span>: {{ $pasien->keluhan ?? '-' }}</span>
                </div>

                <div class="flex">
                    <span class="w-40 font-semibold">Status</span>
                    <span>:
                        <span class="ml-1 px-3 py-1 text-xs rounded-full {{ $statusColor }}">
                            {{ ucfirst(str_replace('_', ' ', $pasien->status)) }}
                        </span>
                    </span>
                </div>

            </div>

            {{-- BUTTON KONFIRMASI --}}
            @if ($pasien->status === 'menunggu_konfirmasi')
                <div class="mt-6 bg-gray-50 p-6 rounded-lg border">

                    <h3 class="text-md font-semibold mb-4 text-gray-700">
                        Input Data Awal Pasien
                    </h3>

                    <form action="{{ route('pasien.konfirmasi', $pasien->id) }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-2 gap-4">

                            <div>
                                <label class="text-sm">Tensi</label>
                                <input name="tensi" placeholder="Contoh: 120/80"
                                    class="w-full px-3 py-2 border rounded-lg">
                            </div>

                            <div>
                                <label class="text-sm">Berat Badan (kg)</label>
                                <input type="number" name="berat_badan" class="w-full px-3 py-2 border rounded-lg">
                            </div>

                            <div>
                                <label class="text-sm">Tinggi Badan (cm)</label>
                                <input type="number" name="tinggi_badan" class="w-full px-3 py-2 border rounded-lg">
                            </div>

                            <div class="col-span-2">
                                <label class="text-sm">Keluhan</label>
                                <textarea name="keluhan" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan keluhan pasien"></textarea>
                            </div>

                        </div>

                        <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm transition">
                            ✔ Konfirmasi Kehadiran
                        </button>

                    </form>
                </div>
            @endif

        </div>

        {{-- TIMELINE STATUS --}}
        <div class="bg-white shadow rounded-lg px-8 py-16">
            <h2 class="text-xl font-semibold mb-10 text-purple-700 text-center">
                Status Pemeriksaan
            </h2>

            <div class="flex items-center justify-between relative">

                {{-- Garis utama --}}
                <div class="absolute top-4 left-0 w-full h-1 bg-gray-300"></div>

                @foreach ($steps as $index => $step)
                    <div class="relative flex flex-col items-center w-full">

                        {{-- Bulatan --}}
                        <div
                            class="z-10 flex items-center justify-center w-10 h-10 rounded-full
                        {{ $currentIndex >= $index ? 'bg-purple-600 text-white' : 'bg-gray-300 text-gray-600' }}">
                            {{ $index + 1 }}
                        </div>

                        {{-- Label --}}
                        <div class="mt-4 text-sm text-center">
                            {{ ucfirst(str_replace('_', ' ', $step)) }}
                        </div>

                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
