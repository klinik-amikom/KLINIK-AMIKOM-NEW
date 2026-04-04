<!DOCTYPE html>
<html lang="id">
<head>
    <title>Laporan Rekam Medis</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
        }

        .header-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .logo-cell {
            width: 80px;
        }

        .title-cell {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
        }

        .header-title {
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            background-color: #6a1b9a;
            /* ungu */
            color: white;
            font-weight: bold;
            text-align: center;
        }

        td,
        th {
            border: 1px solid #f5f5f5;
            padding: 5px;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f4fb;
            /* putih keungu-unguan */
        }

        tbody tr:nth-child(odd) {
            background-color: white;
        }

        th {
            background-color: #6a1b9a;
            color: white;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- ================= HEADER ================= --}}
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('landingpage/img/logo_amikom.png') }}" width="70">
            </td>

            <td class="title-cell">
                <b>LAPORAN REKAM MEDIS</b><br>
                <b>KLINIK AMIKOM YOGYAKARTA</b>
            </td>

            <td align="right">
                <div>{{ \Carbon\Carbon::now()->format('d M Y') }}</div>
            </td>
        </tr>
    </table>

    {{-- ================= DATA PASIEN ================= --}}
    <table class="patient-info">
        <tr>
            <td width="120"><strong>Nama</strong></td>
            <td>: {{ $pasien->identity->name ?? '-' }}</td>
        </tr>
        <tr>
            <td width="120"><strong>Kode Pasien</strong></td>
            <td>: {{ $pasien->kode_pasien ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>NIK</strong></td>
            <td>: {{ $pasien->identity->identity_number ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Kategori</strong></td>
            <td>: {{ $pasien->identity->identity_type ?? '-' }}</td>
        </tr>
        <tr>
            <td width="120"><strong>Nomor Antrian</strong></td>
            <td>: {{ $pasien->queue_number ?? '-' }}</td>
        </tr>
        <tr>
            <td width="120"><strong>Berat Badan</strong></td>
            <td>: {{ $pasien->berat_badan ?? '-' }}</td>
        </tr>
        <tr>
            <td width="120"><strong>Tinggi Badan</strong></td>
            <td>: {{ $pasien->tinggi_badan ?? '-' }}</td>
        </tr>
        <tr>
            <td width="120"><strong>Tensi</strong></td>
            <td>: {{ $pasien->tensi ?? '-' }}</td>
        </tr>
        <tr>
            <td width="120"><strong>Jadwal Konsultasi</strong></td>
            <td>: {{ $pasien->estimasi_jam ?? '-' }}</td>
        </tr>
        <tr>
            <td width="120"><strong>Keluhan</strong></td>
            <td>: {{ $pasien->keluhan ?? '-' }}</td>
        </tr>
    </table>

    {{-- ================= TABEL ================= --}}
    <table class="table">
        <thead>
            <tr>
                <th width="10%">Tanggal</th>
                <th width="20%">Dokter</th>
                <th width="30%">Diagnosis</th>
                <th width="40%">Obat</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
                <tr>
                    <td align="center">
                        {{ \Carbon\Carbon::parse($item->tanggal_periksa)->format('d-m-Y') }}
                    </td>

                    <td>
                        {{ $item->dokter->name ?? '-' }}
                    </td>

                    <td>
                        {{ $item->diagnosis ?? '-' }}
                    </td>

                    <td>
                        @if ($item->resepObat->count() > 0)
                            @foreach ($item->resepObat as $resep)
                                • {{ $resep->obat->nama_obat ?? '-' }}
                                ({{ $resep->jumlah }} pcs)
                                <br>
                                <small style="color:#666;">
                                    {{ $resep->aturan_pakai ?? '-' }}
                                </small>
                                <br><br>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" align="center">
                        Data rekam medis tidak tersedia
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ================= FOOTER ================= --}}
    <div class="footer">
        Dicetak oleh sistem Klinik Amikom <br>
        {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
    </div>

</body>
</html>