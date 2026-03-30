<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran Klinik</title>

    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            margin: 0;
            padding: 0;
            background: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background: #b3a3ba;
            padding: 20px;
            text-align: center;
            color: white;
        }

        .content {
            padding: 30px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }

        .label {
            width: 40%;
            font-weight: bold;
        }

        .queue-box {
            text-align: center;
            margin: 30px 0;
        }

        .queue-number {
            display: inline-block;
            padding: 15px 40px;
            border: 2px solid #0d6efd;
            border-radius: 8px;
            font-size: 28px;
            font-weight: bold;
            color: #0d6efd;
        }

        .footer {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }

        @media print {
            body {
                background: white;
            }

            .container {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- HEADER -->
        <div class="header">
            <h2 style="margin:0;">KLINIK AMIKOM</h2>
            <p style="margin:5px 0 0; font-size:13px;">
                Bukti Pendaftaran Pasien
            </p>
        </div>

        <!-- CONTENT -->
        <div class="content">

            <p>
                Yth. <strong>{{ $pasien->identity->name }}</strong>,
            </p>

            <p style="font-size:14px; line-height:1.6;">
                Pendaftaran Anda di <strong>Klinik Amikom</strong> telah berhasil.
                Berikut detail data Anda:
            </p>

            <!-- DATA PASIEN -->
            <table class="table">
                <tr>
                    <td class="label">Nama</td>
                    <td>{{ $pasien->identity->name }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Lahir</td>
                    <td>{{ \Carbon\Carbon::parse($pasien->identity->birth_date)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Jenis Kelamin</td>
                    <td>{{ $pasien->identity->gender }}</td>
                </tr>
                <tr>
                    <td class="label">No Telepon</td>
                    <td>{{ $pasien->identity->no_telp }}</td>
                </tr>
                <tr>
                    <td class="label">Alamat</td>
                    <td>{{ $pasien->identity->address }}</td>
                </tr>
                <tr>
                    <td class="label">Kategori</td>
                    <td>{{ ucfirst($pasien->identity->identity_type) }}</td>
                </tr>
                <tr>
                    <td class="label">Poli</td>
                    <td>{{ $pasien->poli }}</td>
                </tr>
                <tr>
                    <td class="label">Estimasi Kedatangan</td>
                    <td>
                        <strong style="color:#0d6efd;">
                            {{ $pasien->estimasi_jam 
                                ? \Carbon\Carbon::parse($pasien->estimasi_jam)->format('H:i') . ' WIB'
                                : '-' 
                            }}
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td class="label">Kode Pasien</td>
                    <td>{{ $pasien->kode_pasien }}</td>
                </tr>
            </table>

            <!-- NOMOR ANTRIAN -->
            <div class="queue-box">
                <div class="queue-number">
                    {{ $pasien->queue_number ?? '-' }}
                </div>
                <p style="font-size:12px; margin-top:5px;">
                    Nomor Antrian Anda
                </p>
            </div>

            <p style="font-size:13px; color:#555; line-height:1.6;">
                Silakan datang 15 menit sebelum jadwal pelayanan dan tunjukkan bukti ini kepada petugas.
            </p>

            <p style="margin-top:30px; font-size:14px;">
                Hormat kami,<br>
                <strong>Manajemen Klinik Amikom</strong>
            </p>

        </div>

        <!-- FOOTER -->
        <div class="footer">
            © {{ date('Y') }} Klinik Amikom. Seluruh hak cipta dilindungi.
        </div>

    </div>

</body>

</html>
