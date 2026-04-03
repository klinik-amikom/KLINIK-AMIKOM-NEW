<h2 style="text-align:center;">Rekam Medis Pasien</h2>

<hr>

<p><strong>Nama:</strong> {{ $rekam->pasien->identity->name }}</p>
<p><strong>NIK:</strong> {{ $rekam->pasien->identity->identity_number }}</p>
<p><strong>Kategori:</strong> {{ $rekam->pasien->identity->identity_type }}</p>
<p><strong>Tanggal:</strong> {{ $rekam->tanggal_periksa }}</p>

<hr>

<p><strong>Dokter:</strong> {{ $rekam->dokter->name ?? '-' }}</p>
<p><strong>Diagnosis:</strong> {{ $rekam->diagnosis }}</p>

<h4>Obat</h4>
<ul>
    @foreach ($rekam->resepObat as $resep)
        <li>
            {{ $resep->obat->nama_obat }} ({{ $resep->jumlah }}) <br>
            <small>{{ $resep->aturan_pakai }}</small>
        </li>
    @endforeach
</ul>

<br>

<p>Terima kasih telah menggunakan layanan kami.</p>
