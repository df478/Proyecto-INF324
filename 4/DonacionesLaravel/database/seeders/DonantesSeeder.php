<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Donante;

class DonantesSeeder extends Seeder
{
    public function run()
    {
        Donante::create(['nombre' => 'Juan Pérez', 'correo' => 'juan.perez@example.com', 'teléfono' => '555-1234']);
        Donante::create(['nombre' => 'María López', 'correo' => 'maria.lopez@example.com', 'teléfono' => '555-5678']);
        Donante::create(['nombre' => 'Carlos García', 'correo' => 'carlos.garcia@example.com', 'teléfono' => '555-9012']);
    }
}
