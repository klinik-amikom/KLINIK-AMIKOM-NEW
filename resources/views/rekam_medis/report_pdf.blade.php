<!DOCTYPE html>
<html>

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

    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('landingpage/img/logo_amikom.png') }}" width="70">
            </td>

            <td class="title-cell">
                <b>LAPORAN REKAM MEDIS</b><br>
                <b>KLINIK AMIKOM YOGYAKARTA</b>
            </td>

            <td style="width:80px"></td>
        </tr>
    </table>
    <hr style="border:1px solid black; margin-bottom:15px;">
    <table>
        <thead class="text-center">
            <tr>
                <th>Kode Rekam</th>
                <th>Tanggal Periksa</th>
                <th>Pasien</th>
                <th>Poli</th>
                <th>Dokter</th>
                <th>Obat</th>
                <th>Diagnosis</th>
                <th>Resep</th>
                <th>Jumlah Obat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekamMedis as $rekam)
                <tr>
                    <td>{{ $rekam->kode_rekam_medis }}</td>
                    <td>{{ $rekam->tanggal_periksa }}</td>
                    <td>{{ $rekam->pasien->identity->name ?? '-' }}</td>
                    <td>{{ $rekam->pasien->poli ?? '-' }}</td> 

                    <td>{{ $rekam->dokter->name ?? '-' }}</td>

                    <td>
                        @foreach ($rekam->resepObat as $resep)
                            {{ $resep->obat->nama_obat ?? '-' }}<br>
                        @endforeach
                    </td>

                    <td>{{ $rekam->diagnosis ?? '-' }}</td>

                    <td>
                        @foreach ($rekam->resepObat as $resep)
                            {{ $resep->aturan_pakai ?? '-' }}<br>
                        @endforeach
                    </td>

                    <td>
                        @foreach ($rekam->resepObat as $resep)
                            {{ $resep->jumlah ?? '-' }}<br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
