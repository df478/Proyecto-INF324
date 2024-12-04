<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\MétodoPago;

class MétodosPagoSeeder extends Seeder
{
    public function run()
    {
        MétodoPago::create(['nombre' => 'Tarjeta de Crédito']);
        MétodoPago::create(['nombre' => 'Transferencia Bancaria']);
        MétodoPago::create(['nombre' => 'Efectivo']);
    }
}
