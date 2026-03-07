@extends('layouts.app')

@section('title', 'Data Rekam Medis')

@section('page-title', 'Kelola Rekam Medis')

@section('content')

    {{-- ================= ALERT ================= --}}
    @if (session('success'))
        <div class="mb-4 bg-purple-100 border border-purple-400 text-purple-700 px-4 py-3 rounded">
            <strong>Berhasil!</strong>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <strong>Error!</strong>
            {{ session('error') }}
        </div>
    @endif


    {{-- ================= HEADER ================= --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            Kelola Rekam Medis
        </h2>
        <p class="text-gray-600 dark:text-gray-400">
            Daftar seluruh rekam medis pasien
        </p>
    </div>


    {{-- ================= TABLE ================= --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl border overflow-hidden">

        <div class="p-4 border-b dark:border-gray-700">
            <h3 class="font-semibold text-gray-900 dark:text-white">
                Daftar Rekam Medis
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">NIK</th>
                        <th class="px-4 py-3">Nama Pasien</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Dokter</th>
                        <th class="px-4 py-3">Obat</th>
                        <th class="px-4 py-3">Diagnosis</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y dark:divide-gray-700">

                    @forelse ($dataRekamMedis as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">

                            <td class="px-4 py-3">{{ $loop->iteration }}</td>

                            <td class="px-4 py-3 font-semibold text-purple-600">
                                {{ $item->kode_rekam_medis }}
                            </td>

                            {{-- NIK --}}
                            <td class="px-4 py-3">
                                {{ $item->pasien->identity->identity_number ?? '-' }}
                            </td>

                            {{-- Nama Pasien --}}
                            <td class="px-4 py-3">
                                {{ $item->pasien->identity->name ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ \Carbon\Carbon::parse($item->tanggal_periksa)->format('d-m-Y') }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $item->dokter->name ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                @if ($item->resepObat->count() > 0)
                                    <ul class="space-y-1">
                                        @foreach ($item->resepObat as $resep)
                                            <li class="text-xs bg-gray-100 px-2 py-1 rounded">
                                                <strong>{{ $resep->obat->nama_obat ?? '-' }}</strong>
                                                ({{ $resep->jumlah }} pcs)
                                                <br>
                                                <span class="text-gray-500">
                                                    {{ $resep->aturan_pakai ?? '-' }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                {{ $item->diagnosis ?? '-' }}
                            </td>

                            {{-- STATUS BADGE --}}
                            <td class="px-4 py-3">
                                @if ($item->status == 'menunggu_pemeriksaan')
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">
                                        Menunggu Pemeriksaan
                                    </span>
                                @elseif($item->status == 'diperiksa')
                                    <span class="px-2 py-1 text-xs bg-purple-100 text-purple-700 rounded">
                                        Sedang Diperiksa
                                    </span>
                                @elseif($item->status == 'menunggu_obat')
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">
                                        Menunggu Obat
                                    </span>
                                @elseif($item->status == 'selesai')
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                        Selesai
                                    </span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end space-x-3">

                                    {{-- DETAIL --}}
                                    <a href="{{ route('rekammedis.show', $item->id) }}"
                                        class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- ================= MULAI PERIKSA (KHUSUS DOKTER) ================= --}}
                                    @if (auth()->user()->role == 'dokter' && $item->status == 'menunggu_pemeriksaan')
                                        <form action="{{ route('rekammedis.mulai', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-yellow-500 text-white text-xs px-2 py-1 rounded hover:bg-yellow-600">
                                                Mulai Periksa
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Hapus --}}
                                    <form action="{{ route('rekammedis.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-8 text-gray-500">
                                Data rekam medis belum tersedia
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>


    {{-- ================= EXPORT ================= --}}
    <div class="flex justify-end mt-4 space-x-2">
        <a href="{{ route('rekammedis.export.pdf') }}"
            class="bg-red-600 text-white px-4 py-2 text-sm rounded hover:bg-red-700">
            Export PDF
        </a>

        <a href="{{ route('rekammedis.export.excel') }}"
            class="bg-green-600 text-white px-4 py-2 text-sm rounded hover:bg-green-700">
            Export Excel
        </a>
    </div>

@endsection
