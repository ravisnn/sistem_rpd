<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kegiatan;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['kode' => '3365'],
            ['kode' => '3375'],
            ['kode' => '3376'],
            ['kode' => '3377'],
        ];

        foreach ($items as $it) {
            Kegiatan::updateOrCreate(['kode' => $it['kode']], $it);
        }
    }
}
