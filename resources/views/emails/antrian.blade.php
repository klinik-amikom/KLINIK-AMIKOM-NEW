<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Antrian Klinik</title>
</head>
<body style="margin:0; padding:0; background-color:#f2f2f2; font-family: Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:20px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden;">

                    <!-- HEADER -->
                    <tr>
                        <td align="center" style="background:#b3a3ba; padding:20px;">
                            <h2 style="color:#ffffff; margin:0;">
                                KLINIK AMIKOM
                            </h2>
                            <p style="color:#e0e0e0; font-size:13px; margin:5px 0 0;">
                                Pelayanan Kesehatan Profesional & Terpercaya
                            </p>
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:30px;">

                            <p style="font-size:14px; color:#333;">
                                Yth. <strong>{{ $pasien->identity->name }}</strong>,
                            </p>

                            <p style="font-size:14px; color:#333; line-height:1.6;">
                                Dengan hormat, kami informasikan bahwa pendaftaran Anda di 
                                <strong>Klinik Amikom</strong> telah berhasil diproses dengan rincian sebagai berikut:
                            </p>

                            <table width="100%" cellpadding="8" cellspacing="0" style="margin-top:15px; border-collapse:collapse;">
                                <tr>
                                    <td width="40%" style="border-bottom:1px solid #ddd;"><strong>Poli</strong></td>
                                    <td style="border-bottom:1px solid #ddd;">{{ $pasien->poli }}</td>
                                </tr>
                                <tr>
                                    <td style="border-bottom:1px solid #ddd;"><strong>Nomor Antrian</strong></td>
                                    <td style="border-bottom:1px solid #ddd;">{{ $pasien->queue_number }}</td>
                                </tr>
                                <tr>
                                    <td style="border-bottom:1px solid #ddd;"><strong>Status</strong></td>
                                    <td style="border-bottom:1px solid #ddd;">
                                        {{ ucfirst(str_replace('_',' ', $pasien->status)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-bottom:1px solid #ddd;"><strong>Tanggal Kunjungan</strong></td>
                                    <td style="border-bottom:1px solid #ddd;">
                                        {{ \Carbon\Carbon::parse($pasien->tanggal_kunjungan)->translatedFormat('d F Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-bottom:1px solid #ddd;"><strong>Estimasi Jam</strong></td>
                                    <td style="border-bottom:1px solid #ddd; color:#0d6efd; font-weight:bold;">
                                        {{ \Carbon\Carbon::parse($pasien->estimasi_jam)->format('H:i') }} WIB
                                    </td>
                                </tr>
                            </table>

                            <div style="margin:25px 0; text-align:center;">
                                <div style="display:inline-block; padding:15px 30px; 
                                            border:2px solid #0d6efd; 
                                            border-radius:6px; 
                                            font-size:24px; 
                                            font-weight:bold; 
                                            color:#0d6efd;">
                                    {{ $pasien->queue_number }}
                                </div>
                            </div>

                            <p style="font-size:13px; color:#555; line-height:1.6;">
                                Mohon untuk datang <strong>10-15 menit sebelum pukul {{ \Carbon\Carbon::parse($pasien->estimasi_jam)->format('H:i') }} WIB</strong> 
                                agar proses pelayanan berjalan dengan lancar.
                            </p>

                            <p style="font-size:13px; color:#555; line-height:1.6;">
                                Atas perhatian dan kepercayaan Anda, kami ucapkan terima kasih.
                            </p>

                            <p style="margin-top:30px; font-size:14px;">
                                Hormat kami,<br>
                                <strong>Manajemen Klinik Amikom</strong>
                            </p>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td align="center" style="background:#f8f9fa; padding:15px; font-size:12px; color:#888;">
                            © {{ date('Y') }} Klinik Amikom. Seluruh hak cipta dilindungi.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>