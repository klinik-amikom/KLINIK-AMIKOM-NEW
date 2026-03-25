<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Pendaftaran Klinik Amikom</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('landingpage') }}/img/logo_amikom.png" rel="icon">
    <link href="{{ asset('landingpage') }}/img/apple-touch-icon.png" rel="apple-touch-icon">

    <style>
        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #76508e;
            box-shadow: 0 0 0 3px rgba(118, 80, 142, 0.3);
        }
    </style>
</head>

@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4">
    {{ session('error') }}
</div>
@endif

<body class="bg-gray-100 text-gray-900 font-sans">
    <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-semibold mb-6 flex items-center space-x-2 text-black font-sans">
            <span class="text-3xl">🏥</span>
            <span>Form Pendaftaran Konsultasi</span>
        </h1>
        <a href="{{ url('/') }}"
            class="inline-flex items-center px-4 py-2 text-white text-sm font-semibold rounded transition"
            style="background-color: #76508e;">
            Kembali ke Halaman Utama
        </a>
    </header>

    <main class="flex justify-center py-10 px-4">
        <section class="w-full max-w-2xl bg-white rounded-lg shadow-md p-8">
            @if (isset($pasien))
                {{-- ALERT BERHASIL --}}
                <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-4 rounded mb-6">
                    <h2 class="text-xl font-bold mb-2">🎉 Pendaftaran Berhasil!</h2>
                    <p>Nomor Antrian Anda: <strong class="text-lg">{{ $pasien->queue_number }}</strong></p>
                    <p class="text-sm text-gray-600 mb-4">Silakan simpan nomor ini untuk keperluan konsultasi.</p>
                    <p class="text-sm text-gray-700 mb-2">
                        Tanggal Kunjungan:
                        <strong>
                            {{ \Carbon\Carbon::parse($pasien->tanggal_kunjungan)->translatedFormat('d F Y') }}
                        </strong>
                    </p>

                    <p class="text-sm text-gray-700 mb-4">
                        Estimasi Jam Pemeriksaan:
                        <strong class="text-blue-600">
                            {{ \Carbon\Carbon::parse($pasien->estimasi_jam)->format('H:i') }} WIB
                        </strong>
                    </p>
                    <hr class="my-4">

                    <h3 class="text-lg font-semibold mb-2">Detail Pendaftaran:</h3>
                    <ul class="space-y-1 text-gray-700">
                        <li><strong>Nama:</strong> {{ $pasien->identity->name }}</li>
                        <li><strong>Tanggal Lahir:</strong> {{ $pasien->identity->birth_date }}</li>
                        <li><strong>Jenis Kelamin:</strong>
                            {{ $pasien->identity->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </li>
                        <li><strong>Alamat:</strong> {{ $pasien->identity->address }}</li>
                        <li><strong>No Telepon:</strong> {{ $pasien->identity->no_telp }}</li>
                        <li><strong>Kategori:</strong> {{ ucfirst($pasien->identity->identity_type) }}</li>
                        <li><strong>Poli:</strong> {{ $pasien->poli }}</li>
                    </ul>
                </div>
                <div class="mt-4">
                    <a href="{{ route('pasien.download.pdf', $pasien->id) }}" target="_blank"
                        class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Download Bukti Pendaftaran (PDF)
                    </a>
                </div>
                <p class="text-xs text-gray-500 italic">
                    *Harap datang 10-15 menit sebelum waktu pemeriksaan.
                </p>
            @else
                <h2 class="text-2xl font-semibold mb-6 text-center">Silakan isi formulir pendaftaran</h2>
                <form action="{{ route('pasien.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- NIK / Identity Number --}}
                    <div>
                        <label for="nik" class="block mb-1 font-medium">NIK</label>
                        <input type="text" id="nik" name="identity_number"
                            placeholder="Masukan Nomor Induk Kependudukan (16 digit angka)"
                            class="w-full border rounded-md px-3 py-2">
                    </div>

                    {{-- Nama --}}
                    <div>
                        <label for="nama_pasien" class="block mb-1 font-medium">Nama Lengkap</label>
                        <input type="text" id="nama_pasien" name="nama_pasien" placeholder="Nama Lengkap"
                            class="w-full border rounded-md px-3 py-2"
                            style="background-color:#e5e7eb; cursor:not-allowed;" readonly>
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label for="tanggal_lahir" class="block mb-1 font-medium">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                            class="w-full border rounded-md px-3 py-2"
                            style="background-color:#e5e7eb; cursor:not-allowed;" readonly>
                    </div>

                    {{-- Nomor Telepon --}}
                    <div>
                        <label for="no_telp" class="block mb-1 font-medium">Nomor Telepon</label>
                        <div class="flex">
                            <input type="tel" id="no_telp" name="no_telp"
                                class="w-full border rounded-r-md px-3 py-2"
                                style="background-color:#e5e7eb; cursor:not-allowed;" readonly>
                        </div>
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label for="jenis_kel" class="block mb-1 font-medium">Jenis Kelamin</label>
                        <div class="flex">
                            <input type="text" id="jenis_kel" name="gender" placeholder="Jenis Kelamin Pasien"
                                class="w-full border rounded-r-md px-3 py-2"
                                style="background-color:#e5e7eb; cursor:not-allowed;" readonly>
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label for="kategori" class="block mb-1 font-medium">Kategori</label>
                        <div class="flex">
                            <input type="text" id="kategori" name="identity_type" placeholder="Kategori Pasien"
                                class="w-full border rounded-r-md px-3 py-2"
                                style="background-color:#e5e7eb; cursor:not-allowed;" readonly>
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label for="alamat" class="block mb-1 font-medium">Alamat Lengkap</label>
                        <textarea id="alamat" name="alamat" rows="3" placeholder="Alamat lengkap"
                            class="w-full border rounded-md px-3 py-2" style="background-color:#e5e7eb; cursor:not-allowed;" readonly></textarea>
                    </div>

                    {{-- Poli --}}
                    <div>
                        <label for="poli" class="block mb-1 font-medium">Poli Tujuan</label>
                        <select id="poli" name="poli" class="w-full border rounded-md px-3 py-2">
                            <option value="">Pilih Poli</option>
                            <option value="Poli Umum">Poli Umum</option>
                            <option value="Poli Gigi">Poli Gigi</option>
                        </select>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full bg-[#76508e] hover:bg-[#5e3d71] text-white font-semibold py-2 rounded-md transition">
                        Kirim Formulir
                    </button>
                </form>
            @endif
        </section>
    </main>
</body>

</html>
<script>
    document.getElementById('nik').addEventListener('keyup', function() {
        const nik = this.value;

        if (nik.length === 16) {
            fetch(`/cek-nik/${nik}`)
                .then(res => res.json())
                .then(res => {
                    if (res.status) {
                        document.getElementById('nama_pasien').value = res.data.name;
                        document.getElementById('tanggal_lahir').value = res.data.birth_date;
                        document.getElementById('alamat').value = res.data.address;
                        document.getElementById('no_telp').value = res.data.no_telp;

                        // Gender mapping L/P → Laki-laki/Perempuan
                        document.getElementById('jenis_kel').value =
                            res.data.gender;

                        // Kategori
                        document.getElementById('kategori').value =
                            res.data.identity_type;
                    } else {
                        alert(
                            '❌ NIK tidak terdaftar!\n\nAnda belum termasuk civitas akademik AMIKOM.\nSilakan hubungi admin di nomor: 0123456789');

                        // kosongkan field biar tidak misleading
                        document.getElementById('nama_pasien').value = '';
                        document.getElementById('tanggal_lahir').value = '';
                        document.getElementById('alamat').value = '';
                        document.getElementById('no_telp').value = '';
                        document.getElementById('jenis_kel').value = '';
                        document.getElementById('kategori').value = '';
                    }
                })
                .catch(() => {
                    alert('Terjadi kesalahan saat mengambil data');
                });
        }
    });

    document.querySelector('form').addEventListener('submit', function(e) {
        const nik = document.getElementById('nik').value;
        const nama = document.getElementById('nama_pasien').value;
        const tgl = document.getElementById('tanggal_lahir').value;
        const telp = document.getElementById('no_telp').value;
        const gender = document.getElementById('jenis_kel').value;
        const kategori = document.getElementById('kategori').value;
        const alamat = document.getElementById('alamat').value;
        const poli = document.getElementById('poli').value;

        if (!nik || !nama || !tgl || !telp || !gender || !kategori || !alamat || !poli) {
            e.preventDefault();
            alert('⚠️ Mohon lengkapi semua data terlebih dahulu!');
        }
    });
</script>
