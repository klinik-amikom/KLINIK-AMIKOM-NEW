<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

use Maatwebsite\Excel\Events\AfterSheet;

class RekamMedisExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return [
            'Kode Rekam',
            'Tanggal Periksa',
            'Pasien',
            'Poli',
            'Dokter',
            'Obat',
            'Diagnosis',
            'Resep',
            'Jumlah Obat'
        ];
    }

    public function collection()
    {
        return $this->data->map(function ($rekam) {

            $obat = $rekam->resepObat->map(function ($resep) {
                return $resep->obat->nama_obat ?? '-';
            })->implode("\n");

            $resep = $rekam->resepObat->map(function ($resep) {
                return $resep->aturan_pakai ?? '-';
            })->implode("\n");

            $jumlah = $rekam->resepObat->map(function ($resep) {
                return $resep->jumlah ?? '-';
            })->implode("\n");

            return [
                $rekam->kode_rekam_medis,
                $rekam->tanggal_periksa,
                $rekam->pasien->identity->name ?? '-',
                $rekam->pasien->poli ?? '-',
                $rekam->dokter->name ?? '-',
                $obat,
                $rekam->diagnosis ?? '-',
                $resep,
                $jumlah
            ];
        });
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // Tambah 3 baris kosong di atas
                $sheet->insertNewRowBefore(1, 3);

                // Judul utama
                $sheet->mergeCells('A1:I1');
                $sheet->setCellValue('A1', 'LAPORAN REKAM MEDIS');

                // Sub judul
                $sheet->mergeCells('A2:I2');
                $sheet->setCellValue('A2', 'KLINIK AMIKOM YOGYAKARTA');

                // Style judul
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal('center');

                // STYLE HEADER BARIS 4
                $sheet->getStyle('A4:I4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => '6B46C1']
                    ]
                ]);
            }
        ];
    }
}