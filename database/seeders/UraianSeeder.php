<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Uraian;

class UraianSeeder extends Seeder
{
    public function run(): void
    {
        $uraians = [
            // Kode 52
            ['kode'=>'521111','nama'=>'Belanja Keperluan Perkantoran'],
            ['kode'=>'521114','nama'=>'Belanja Pengiriman Surat Dinas Pos Pusat'],
            ['kode'=>'521115','nama'=>'Belanja Honor Operasional Satuan Kerja'],
            ['kode'=>'521119','nama'=>'Belanja Barang Operasional Lainnya'],
            ['kode'=>'521211','nama'=>'Belanja Bahan'],
            ['kode'=>'521213','nama'=>'Belanja Honor Output Kegiatan'],
            ['kode'=>'521219','nama'=>'Belanja Barang Non Operasional Lainnya'],
            ['kode'=>'521811','nama'=>'Belanja Barang Persediaan Barang Konsumsi'],
            ['kode'=>'521832','nama'=>'Belanja Barang Persediaan Lainnya'],
            ['kode'=>'522111','nama'=>'Belanja Langganan Listrik'],
            ['kode'=>'522112','nama'=>'Belanja Langganan Telepon'],
            ['kode'=>'522113','nama'=>'Belanja Langganan Air'],
            ['kode'=>'522119','nama'=>'Belanja Langganan Daya dan Jasa Lainnya'],
            ['kode'=>'522131','nama'=>'Belanja Jasa Konsultan'],
            ['kode'=>'522141','nama'=>'Belanja Sewa'],
            ['kode'=>'522151','nama'=>'Belanja Jasa Profesi'],
            ['kode'=>'522191','nama'=>'Belanja Jasa Lainnya'],
            ['kode'=>'523111','nama'=>'Belanja Pemeliharaan Gedung dan Bangunan'],
            ['kode'=>'523121','nama'=>'Belanja Pemeliharaan Peralatan dan Mesin'],
            ['kode'=>'523199','nama'=>'Belanja Pemeliharaan Lainnya'],
            ['kode'=>'524111','nama'=>'Belanja Perjalanan Dinas Biasa'],
            ['kode'=>'524113','nama'=>'Belanja Perjalanan Dinas Dalam Kota'],
            ['kode'=>'524114','nama'=>'Belanja Perjalanan Dinas Paket Meeting Luar Kota'],
            ['kode'=>'524119','nama'=>'Belanja Perjalanan Dinas Paket Meeting Luar Kota'],

            // Kode 51
            ['kode'=>'511111', 'nama'=>'Belanja Gaji Pokok PNS'],
            ['kode'=>'511119', 'nama'=>'Belanja Pembulatan Gaji PNS'],
            ['kode'=>'511121', 'nama'=>'Belanja Tunj. Suami/Istri PNS'],
            ['kode'=>'511122', 'nama'=>'Belanja Tunj. Anak PNS'],
            ['kode'=>'511123', 'nama'=>'Belanja Tunj. Struktural PNS'],
            ['kode'=>'511124', 'nama'=>'Belanja Tunj. Fungsional PNS'],
            ['kode'=>'511125', 'nama'=>'Belanja Tunj. PPh PNS'],
            ['kode'=>'511126', 'nama'=>'Belanja Tunj. Beras PNS'],
            ['kode'=>'511129', 'nama'=>'Belanja Uang Makan PNS'],
            ['kode'=>'511151', 'nama'=>'Belanja Tunjangan Umum PNS'],
            ['kode'=>'511611', 'nama'=>'Belanja Gaji Pokok PPPK'],
            ['kode'=>'511619', 'nama'=>'Belanja Pembulatan Gaji PPPK'],
            ['kode'=>'511621', 'nama'=>'Belanja Tunjangan Suami/Istri PPPK'],
            ['kode'=>'511622', 'nama'=>'Belanja Tunjangan Anak PPPK'],
            ['kode'=>'511624', 'nama'=>'Belanja Tunjangan Fungsional PPPK'],
            ['kode'=>'511625', 'nama'=>'Belanja Tunjangan Beras PPPK'],
            ['kode'=>'511628', 'nama'=>'Belanja Uang Makan PPPK'],
            ['kode'=>'512111', 'nama'=>'Belanja Uang Honor Tetap'],
            ['kode'=>'512211', 'nama'=>'Belanja Uang Lembur'],
            ['kode'=>'512212', 'nama'=>'Belanja Uang Lembur PPPK'],
            ['kode'=>'512411', 'nama'=>'Belanja Pegawai (Tunjangan Khusus/Kegiatan/Kinerja)'],
            ['kode'=>'512414', 'nama'=>'Belanja Pegawai Tunjangan Khusus/Kegiatan/Kinerja PPPK'],

            // Kode 53
            ['kode'=>'532111', 'nama'=>'Belanja Modal Peralatan dan Mesin'],
            ['kode'=>'533121', 'nama'=>'Belanja Penambahan Nilai Gedung dan Bangunan'],
        ];

        foreach ($uraians as $u) {
            Uraian::firstOrCreate(['kode' => $u['kode']], ['nama' => $u['nama']]);
        }
    }
}