<?php

namespace App\Exports;

use App\Lelang;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LelangCustomExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $from, $to;
    public function __construct($from, $to){
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        $query = Lelang::join('barangs', 'lelangs.id_barang', '=', 'barangs.id_barang')
                ->join('petugas', 'petugas.id_petugas', '=', 'lelangs.id_petugas')
                ->leftJoin('masyarakats', 'masyarakats.id_user', '=', 'lelangs.id_user')
                ->select('lelangs.id_lelang', 'barangs.nama_barang', 'lelangs.tgl_lelang', 'lelangs.start_lelang', 'lelangs.end_lelang', 'lelangs.harga_akhir', 'masyarakats.nama_lengkap', 'petugas.nama_petugas', 'lelangs.status')
                ->whereBetween('lelangs.tgl_lelang', [$this->from, $this->to])
                ->get();

        foreach($query as $data){
            if($data->end_lelang == null){
                $data->end_lelang = '-';
            }

            if($data->nama_lengkap == null){
                $data->nama_lengkap = 'Belum ada pemenang';
            }
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID Lelang',
            'Nama Barang',
            'Tanggal Entri Data',
            'Tanggal Mulai Lelang',
            'Tanggal Akhir Lelang',
            'Harga Akhir',
            'Terakhir Bid / Pemenang',
            'Penanggung Jawab',
            'Status'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
            },
        ];
    }
}
