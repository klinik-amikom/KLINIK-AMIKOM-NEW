@extends('layouts.app')

@section('title', 'Data Pasien')

@section('page-title', 'Kelola Pasien')

@section('content')
@php
    $steps = ['terdaftar', 'diperiksa', 'diobati', 'selesai'];
@endphp

<div class="max-w-7xl mx-auto px-4 py-6">
    {{-- Informasi Pasien --}}
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-purple-700">Data Pasien</h2>
        <ul class="grid grid-cols-2 gap-4 text-sm">
            <li><strong>Kode Pasien:</strong> {{ $pasien['kode_pasien'] }}</li>
            <li><strong>Nama:</strong> {{ $pasien['nama_pasien'] }}</li>
            <li><strong>Tanggal Lahir:</strong> {{ \Carbon\Carbon::parse($pasien['tanggal_lahir'])->format('d M Y') }}</li>
            <li><strong>Jenis Kelamin:</strong> {{ $pasien['jenis_kel'] }}</li>
            <li><strong>Alamat:</strong> {{ $pasien['alamat'] }}</li>
            <li><strong>No. Telepon:</strong> {{ $pasien['no_telp'] }}</li>
            <li><strong>Kategori:</strong> {{ ucfirst($pasien['kategori']) }}</li>
            <li><strong>Poli:</strong> {{ $pasien['poli'] }}</li>
        </ul>
    </div>

    {{-- Timeline Status --}}
    <div class="bg-white shadow rounded-lg px-8 py-16">
        <h2 class="text-xl font-semibold mb-6 text-purple-700">Status Pemeriksaan</h2>

        <div class="flex items-center justify-between w-full">
            @foreach($steps as $index => $step)
                <div class="flex items-center w-full relative ">
                    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 
                            bg-purple-600">
                        </div>
                    {{-- Garis penghubung --}}
                    @if($index !== 0)
                        <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 
                            {{ array_search($pasien['status'], $steps) >= $index ? 'bg-purple-600' : 'bg-gray-300' }}">
                        </div>
                    @endif

                    {{-- Bulatan status --}}
                    <div class="z-10 flex items-center justify-center w-8 h-8 rounded-full 
                        {{ array_search($pasien['status'], $steps) >= $index ? 'bg-purple-600 text-white' : 'bg-gray-300 text-gray-600' }}">
                        {{ $index + 1 }}
                    </div>

                    {{-- Label --}}
                    <div class="absolute top-10 text-sm text-center w-24 -ml-8">
                        {{ ucfirst($step) }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection