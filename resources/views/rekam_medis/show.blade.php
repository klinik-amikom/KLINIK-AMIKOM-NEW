@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">Detail Rekam Medis</h2>

    <p><strong>Nama:</strong>
        {{ $rekam->pasien->identity->name ?? '-' }}
    </p>

    <p><strong>NIK:</strong>
        {{ $rekam->pasien->identity->identity_number ?? '-' }}
    </p>

    <p><strong>Tanggal:</strong> {{ $rekam->tanggal_periksa }}</p>

    <form method="POST" action="{{ route('rekammedis.update', $rekam->id) }}">
        @csrf
        @method('PUT')

        {{-- DIAGNOSIS --}}
        <div class="mt-4">
            <label class="font-semibold">Diagnosis</label>
            <textarea name="diagnosis"
                class="w-full border p-2"
                placeholder="Tuliskan diagnosa untuk pasien..."
                required>{{ old('diagnosis', $rekam->diagnosis) }}</textarea>
        </div>

        {{-- RESEP OBAT --}}
        <div class="mt-6">
            <label class="font-semibold">Resep Obat</label>

            <div id="resep-container">

                <div class="resep-item grid grid-cols-12 gap-2 mt-2">

                    {{-- Dropdown Obat --}}
                    <div class="col-span-4">
                        <select name="obat_id[]"
                            class="w-full border p-2"
                            required>
                            <option value="">-- Pilih Obat --</option>
                            @foreach($obats as $obat)
                                <option value="{{ $obat->id }}">
                                    {{ $obat->nama_obat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jumlah --}}
                    <div class="col-span-3">
                        <input type="number"
                            name="jumlah[]"
                            class="w-full border p-2"
                            placeholder="Jumlah"
                            min="1"
                            required>
                    </div>

                    {{-- Aturan Pakai --}}
                    <div class="col-span-4">
                        <input type="text"
                            name="aturan_pakai[]"
                            class="w-full border p-2"
                            placeholder="Aturan pakai (3x sehari sesudah makan)">
                    </div>

                    {{-- Tombol Hapus --}}
                    <div class="col-span-1 flex items-center">
                        <button type="button"
                            onclick="removeResep(this)"
                            class="text-red-600 text-xl">
                            &times;
                        </button>
                    </div>

                </div>
            </div>

            {{-- Tombol Tambah --}}
            <button type="button"
                onclick="addResep()"
                class="mt-3 bg-green-600 text-white px-3 py-1 rounded">
                + Tambah Obat
            </button>
        </div>

        <button type="submit"
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
</script>

@endsection