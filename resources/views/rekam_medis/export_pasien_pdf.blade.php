<!DOCTYPE html>
<html lang="id">
<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        color: #333;
    }

    .header {
        text-align: center;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .header img {
        width: 70px;
        margin-bottom: 5px;
    }

    .title {
        font-size: 16px;
        font-weight: bold;
        margin-top: 5px;
    }

    .subtitle {
        font-size: 13px;
    }

    .section {
        margin-bottom: 15px;
    }

    .section-title {
        font-weight: bold;
        margin-bottom: 5px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 3px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td {
        padding: 4px;
        vertical-align: top;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #000;
        padding: 6px;
    }

    .table-bordered th {
        background-color: #f2f2f2;
        text-align: center;
    }

    .footer {
        margin-top: 30px;
        text-align: right;
    }
</style>

{{-- ================= HEADER ================= --}}
<div style="border-bottom:2px solid #000; padding-bottom:10px; margin-bottom:15px;">
    
    <table width="100%" style="border-collapse:collapse;">
        <tr>
            {{-- LOGO --}}
            <td width="15%" style="vertical-align:middle; text-align:left;">
                <img src="{{ public_path('landingpage/img/logo_amikom.png') }}" width="70">
            </td>

            {{-- TEXT --}}
            <td width="70%" style="text-align:center; vertical-align:middle;">
                <div style="font-size:18px; font-weight:bold; letter-spacing:1px;">
                    KLINIK AMIKOM
                </div>
                <div style="font-size:11px; margin-top:4px;">
                    Jl. Ring Road Utara, Ngringin, Condongcatur, Kec. Depok, Sleman, DIY 55281
                </div>
                <div style="font-size:11px; margin-top:2px;">
                    Telp: (0274) 884201
                </div>
            </td>

            {{-- TANGGAL --}}
            <td width="15%" style="text-align:right; vertical-align:top;">
                <div style="font-size:11px;">
                    {{ \Carbon\Carbon::now()->format('d M Y') }}
                </div>
            </td>
        </tr>
    </table>

</div>

{{-- ================= JUDUL ================= --}}
<h3 style="text-align:center; margin-bottom:20px;">
    LAPORAN REKAM MEDIS PASIEN
</h3>

{{-- ================= DATA PASIEN ================= --}}
<div class="section">
    <div class="section-title">Data Pasien</div>

    <table>
        <tr>
            <td width="20%">Nama</td>
            <td>: {{ $rekam->pasien->identity->name ?? '-' }}</td>

            <td width="20%">Kode Pasien</td>
            <td>: {{ $rekam->pasien->kode_pasien ?? '-' }}</td>
        </tr>

        <tr>
            <td>NIK</td>
            <td>: {{ $rekam->pasien->identity->identity_number ?? '-' }}</td>

            <td>Poli</td>
            <td>:
                @if($rekam->pasien->poli == 1)
                    Poli Umum
                @endif
            </td>
        </tr>

        <tr>
            <td>Tanggal Periksa</td>
            <td>: {{ \Carbon\Carbon::parse($rekam->tanggal_periksa)->format('d-m-Y H:i') }}</td>

            <td>Status</td>
            <td>: {{ ucfirst(str_replace('_', ' ', $rekam->pasien->status ?? '-')) }}</td>
        </tr>

        <tr>
            <td>Nomor Antrian</td>
            <td>: {{ $rekam->pasien->queue_number ?? '-' }}</td>

            <td>Estimasi Jam</td>
            <td>: {{ \Carbon\Carbon::parse($rekam->pasien->estimasi_jam)->format('H:i') }} WIB</td>
        </tr>

        <tr>
            <td>Berat / Tinggi</td>
            <td>: {{ $rekam->pasien->berat_badan ?? '-' }} kg / {{ $rekam->pasien->tinggi_badan ?? '-' }} cm</td>

            <td>Tensi</td>
            <td>: {{ $rekam->pasien->tensi ?? '-' }}</td>
        </tr>

        <tr>
            <td>Tanggal Kunjungan</td>
            <td colspan="3">
                : {{ \Carbon\Carbon::parse($rekam->pasien->visit_date)->format('d M Y H:i') ?? '-' }}
            </td>
        </tr>

        <tr>
            <td>Keluhan</td>
            <td colspan="3">: {{ $rekam->pasien->keluhan ?? '-' }}</td>
        </tr>
    </table>
</div>

{{-- ================= DATA MEDIS ================= --}}
<div class="section">
    <div class="section-title">Informasi Medis</div>

    <p><strong>Dokter:</strong> {{ $rekam->dokter->name ?? '-' }}</p>

    <p><strong>Diagnosis:</strong><br>
        {{ $rekam->diagnosis ?? '-' }}
    </p>
</div>

{{-- ================= RESEP OBAT ================= --}}
<div class="section">
    <div class="section-title">Resep Obat</div>

    @if ($rekam->resepObat->count() > 0)
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Aturan Pakai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekam->resepObat as $i => $resep)
                    <tr>
                        <td style="text-align:center;">{{ $i + 1 }}</td>
                        <td>{{ $resep->obat->nama_obat ?? '-' }}</td>
                        <td style="text-align:center;">{{ $resep->jumlah }}</td>
                        <td>{{ $resep->aturan_pakai ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>- Tidak ada resep obat -</p>
    @endif
</div>

{{-- ================= FOOTER / TTD ================= --}}
<div class="footer">
    <p>Yogyakarta, {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
    <br><br><br>
    <p><strong>{{ $rekam->dokter->name ?? 'Dokter' }}</strong></p>
    <p>Dokter Pemeriksa</p>
</div>