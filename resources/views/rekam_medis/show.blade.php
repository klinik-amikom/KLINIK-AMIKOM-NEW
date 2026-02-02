@extends('layouts.app')

@section('content')
<div class="p-6 bg-white rounded-lg shadow">
    <h2 class="text-lg font-bold mb-4">Detail Rekam Medis</h2>

    <div class="space-y-2">
        <p><strong>Nama Pasien:</strong> {{ $rekamMedis->pasien->nama ?? '-' }}</p>
        <p><strong>Dokter Pemeriksa:</strong> {{ $rekamMedis->dokter->nama ?? '-' }}</p>
        <p><strong>Tanggal Periksa:</strong> {{ $rekamMedis->created_at->format('d M Y') }}</p>
        <p><strong>Diagnosa:</strong> {{ $rekamMedis->diagnosa ?? '-' }}</p>
        <p><strong>Keluhan:</strong> {{ $rekamMedis->keluhan ?? '-' }}</p>
        <p><strong>Obat Diberikan:</strong> {{ $rekamMedis->obat->nama_obat ?? '-' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($rekamMedis->status) }}</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.rekam-medis.index') }}" class="text-blue-500 hover:underline">← Kembali</a>
    </div>
</div>
@endsection
