<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Desain;

class DesainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Desain::create([
            'judul' => 'Desain Minimalis 1 Lantai',
            'luas' => '72 m²',
            'harga' => 150000000,
            'imageUrl' => 'upload/minimalis1.jpg',
        ]);

        Desain::create([
            'judul' => 'Desain Modern 2 Lantai',
            'luas' => '120 m²',
            'harga' => 300000000,
            'imageUrl' => 'upload/modern2lantai.jpg',
        ]);
    }
}
