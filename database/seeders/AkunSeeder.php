<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Akun;

class AkunSeeder extends Seeder
{
    public function run(): void
    {
        $akuns = [
            ['kode'=>'A','nama'=>'Penyelenggaraan Pendidikan dan Pelatihan'],
            ['kode'=>'B','nama'=>'Kerjasama Pendidikan dan Pelatihan'],
            ['kode'=>'C','nama'=>'Perencanaan dan Pengembangan Program Pelatihan'],
            ['kode'=>'D','nama'=>'Persiapan Sertifikasi Pendidikan dan Pelatihan'],
            ['kode'=>'E','nama'=>'Publikasi Pendidikan dan Pelatihan'],
            ['kode'=>'F','nama'=>'Penjaminan Mutu Layanan Pendidikan dan Pelatihan'],
            ['kode'=>'G','nama'=>'Evaluasi Pendidikan dan Pelatihan'],

            // Tambahan kode
            ['kode'=>'A','nama'=>'Layanan Dukungan Manajemen Internal'],
            ['kode'=>'A','nama'=>'Perencanaan dan Penganggaran Internal Pusdiklat'],
            ['kode'=>'A','nama'=>'Pengelolaan Keuangan Pusdiklat'],
            ['kode'=>'B','nama'=>'Pengelolaan Kinerja'],
            ['kode'=>'A','nama'=>'Layanan Manajemen Ortala & RB'],
            ['kode'=>'B','nama'=>'Layanan Manajemen SDM Pusdiklat'],
            ['kode'=>'A','nama'=>'Layanan BMN'],
            ['kode'=>'B','nama'=>'Layanan Umum dan Perlengkapan'],
            ['kode'=>'C','nama'=>'Layanan Koordinasi Internal dan Eksternal'],
            ['kode'=>'A','nama'=>'Layanan Perkantoran'],
            ['kode'=>'A','nama'=>'Layanan Sarana Internal'],
            ['kode'=>'A','nama'=>'Belanja Penambahan Nilai Gedung dan Bangunan'],
            

        ];

        foreach($akuns as $a){
            Akun::firstOrCreate(['kode'=>$a['kode'], 'nama'=>$a['nama']]);
        }
    }
}
