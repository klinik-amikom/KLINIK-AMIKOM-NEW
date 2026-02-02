<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rekam Medis</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        .header img {
            position: absolute;
            top: 0;
            left: 0;
            height: 60px;
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
            background-color: #6a1b9a; /* ungu */
            color: white;
            font-weight: bold;
            text-align: center;
        }

        td, th {
            border: 1px solid #333;
            padding: 5px;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f4fb; /* putih keungu-unguan */
        }

        tbody tr:nth-child(odd) {
            background-color: white;
        }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ asset('landingpage')}}/img/logo_amikom.png" alt="Logo Amikom" style="width: 120px; height: auto;">
    <div class="header-title">
        Laporan Rekam Medis Klinik Amikom Yogyakarta
    </div>
</div>

<table>
    <thead class="text-center">
    <tr>
        <th>Kode Rekam</th>
        <th>Tanggal Periksa</th>
        <th>Pasien</th>
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
                <td>{{ $rekam->pasien->nama_pasien ?? '-' }}</td>
                <td>{{ $rekam->user->nama ?? '-' }}</td>
                <td>{{ $rekam->obat->nama_obat ?? '-' }}</td>
                <td>{{ $rekam->diagnosis }}</td>
                <td>{{ $rekam->resep }}</td>
                <td>{{ $rekam->jumlah_obat }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>