<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hasil Rekam Medis</title>
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
                                Yth. <strong>{{ $rekam->pasien->identity->name }}</strong>,
                            </p>

                            <p style="font-size:14px; color:#333; line-height:1.6;">
                                Dengan hormat, kami informasikan bahwa pemeriksaan Anda di 
                                <strong>Klinik Amikom</strong> telah <strong>selesai</strong>.
                            </p>

                            <p style="font-size:14px; color:#333; line-height:1.6;">
                                Silakan melihat <strong>lampiran PDF</strong> untuk detail lengkap rekam medis Anda.
                            </p>

                            <div style="margin:25px 0; padding:12px; background:#f8f9fa; border-radius:6px; font-size:13px; color:#555; text-align:center;">
                                📄 Rekam medis Anda terlampir pada email ini
                            </div>

                            <p style="font-size:13px; color:#555; line-height:1.6;">
                                Terima kasih atas kepercayaan Anda kepada kami.
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
                            © {{ date('Y') }} Klinik Amikom
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>