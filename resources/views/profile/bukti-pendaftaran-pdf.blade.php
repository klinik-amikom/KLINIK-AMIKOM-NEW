<!DOCTYPE html>
<html>
<head>
    <title>Bukti Pendaftaran</title>
    <style>
        body { font-family: sans-serif; }
        h2 { text-align: center; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        td, th { border: 1px solid #000; padding: 8px; }
    </style>
</head>
<body>

    <h2>Bukti Pendaftaran Pasien</h2>

    <table>
        <tr>
            <th>Nama</th>
            <td>{{ $pasien->identity->name }}</td>
        </tr>
        <tr>
            <th>Tanggal Lahir</th>
            <td>{{ $pasien->identity->birth_date }}</td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td>{{ $pasien->identity->gender }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $pasien->identity->address }}</td>
        </tr>
        <tr>
            <th>No Telepon</th>
            <td>{{ $pasien->identity->no_telp }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $pasien->identity->identity_type }}</td>
        </tr>
        <tr>
            <th>Poli</th>
            <td>{{ $pasien->poli }}</td>
        </tr>
        <tr>
            <th>Kode Pasien</th>
            <td>{{ $pasien->kode_pasien }}</td>
        </tr>
    </table>

    <p style="margin-top: 30px;">Silakan tunjukkan bukti ini saat datang ke klinik.</p>

</body>
</html>