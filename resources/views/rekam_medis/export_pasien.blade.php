<h2 style="text-align:center;">Rekam Medis Pasien</h2>

<p><strong>Nama:</strong> {{ $pasien->identity->name }}</p>
<p><strong>NIK:</strong> {{ $pasien->identity->identity_number }}</p>
<p><strong>Kategori:</strong> {{ $pasien->identity->identity_type }}</p>

<hr>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Dokter</th>
            <th>Diagnosis</th>
            <th>Obat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ $item->tanggal_periksa }}</td>
                <td>{{ $item->dokter->name ?? '-' }}</td>
                <td>{{ $item->diagnosis }}</td>
                <td>
                    @foreach ($item->resepObat as $resep)
                        - {{ $resep->obat->nama_obat }} ({{ $resep->jumlah }}) <br>
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>