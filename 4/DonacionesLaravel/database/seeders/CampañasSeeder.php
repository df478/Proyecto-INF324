<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Campaña;

class CampañasSeeder extends Seeder
{
    public function run()
    {
        Campaña::create(['nombre' => 'Ayuda Escolar', 'meta_recaudación' => 5000.00]);
        Campaña::create(['nombre' => 'Recolección de Alimentos', 'meta_recaudación' => 3000.00]);
    }
}
