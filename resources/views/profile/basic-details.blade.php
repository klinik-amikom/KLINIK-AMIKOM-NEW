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
                    <p>Nomor Antrian Anda: <strong class="text-lg">{{ $pasien->kode_pasien }}</strong></p>
                    <p class="text-sm text-gray-600 mb-4">Silakan simpan nomor ini untuk keperluan konsultasi.</p>

                    <hr class="my-4">

                    <h3 class="text-lg font-semibold mb-2">Detail Pendaftaran:</h3>
                    <ul class="space-y-1 text-gray-700">
                        <li><strong>Nama:</strong> {{ $pasien->nama_pasien }}</li>
                        <li><strong>Tanggal Lahir:</strong> {{ $pasien->tanggal_lahir }}</li>
                        <li><strong>Jenis Kelamin:</strong> {{ $pasien->jenis_kel }}</li>
                        <li><strong>Alamat:</strong> {{ $pasien->alamat }}</li>
                        <li><strong>No Telepon:</strong> {{ $pasien->no_telp }}</li>
                        <li><strong>Kategori:</strong> {{ $pasien->kategori }}</li>
                        <li><strong>Poli:</strong> {{ $pasien->poli }}</li>
                    </ul>
                </div>
                <div class="mt-4">
                    <a href="{{ route('pasien.download.pdf', $pasien->id) }}" target="_blank"
                        class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Download Bukti Pendaftaran (PDF)
                    </a>
                </div>

                <div class="mt-6">
                    <a href="{{ $linkWA }}" target="_blank"
                        class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                        Kirim ke WhatsApp
                    </a>
                </div>
            @else
                <h2 class="text-2xl font-semibold mb-6 text-center">Silakan isi formulir pendaftaran</h2>
               <form action="{{ route('pasien.store') }}" method="POST" class="space-y-6">
    @csrf

    {{-- Nama --}}
    <div>
        <label for="nama_pasien" class="block mb-1 font-medium">Nama Lengkap</label>
        <input type="text" id="nama_pasien" name="nama_pasien" required placeholder="Masukkan nama lengkap"
            class="w-full border rounded-md px-3 py-2" />
    </div>

    {{-- Tanggal Lahir --}}
    <div>
        <label for="tanggal_lahir" class="block mb-1 font-medium">Tanggal Lahir</label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir" required
            class="w-full border rounded-md px-3 py-2" />
    </div>

    {{-- Nomor Telepon --}}
    <div>
        <label for="no_telp" class="block mb-1 font-medium">Nomor Telepon</label>
        <div class="flex">
            <span class="inline-flex items-center px-3 bg-gray-100 border border-r-0 rounded-l-md text-gray-600">
                +62
            </span>
            <input type="tel" id="no_telp" name="no_telp" required pattern="[0-9]{9,13}" placeholder="81234567890"
                class="w-full border rounded-r-md px-3 py-2" />
        </div>
    </div>

    {{-- Jenis Kelamin --}}
    <div>
        <label for="jenis_kel" class="block mb-1 font-medium">Jenis Kelamin</label>
        <select id="jenis_kel" name="jenis_kel" required class="w-full border rounded-md px-3 py-2">
            <option value="" disabled selected>Pilih Jenis Kelamin</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
    </div>

    {{-- Kategori --}}
    <div>
        <label for="kategori" class="block mb-1 font-medium">Kategori</label>
        <select id="kategori" name="kategori" required class="w-full border rounded-md px-3 py-2">
            <option value="" disabled selected>Pilih Kategori</option>
            <option value="Mahasiswa">Mahasiswa</option>
            <option value="Dosen">Dosen</option>
            <option value="Karyawan">Karyawan</option>
        </select>
    </div>

    {{-- Poli --}}
    <div>
        <label for="poli" class="block mb-1 font-medium">Poli Tujuan</label>
        <select id="poli" name="poli" required class="w-full border rounded-md px-3 py-2">
            <option value="" disabled selected>Pilih Poli</option>
            <option value="Poli Umum">Poli Umum</option>
            <option value="Poli Gigi">Poli Gigi</option>
        </select>
    </div>

    {{-- Alamat --}}
    <div>
        <label for="alamat" class="block mb-1 font-medium">Alamat Lengkap</label>
        <textarea id="alamat" name="alamat" rows="3" required placeholder="Masukkan alamat lengkap"
            class="w-full border rounded-md px-3 py-2"></textarea>
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
