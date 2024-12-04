<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Donacion;

class DonacionesSeeder extends Seeder
{
    public function run()
    {
        Donacion::create(['donante_id' => 1, 'campaña_id' => 1, 'método_pago_id' => 1, 'monto' => 100.00, 'fecha' => '2024-12-01']);
        Donacion::create(['donante_id' => 2, 'campaña_id' => 1, 'método_pago_id' => 2, 'monto' => 200.00, 'fecha' => '2024-12-02']);
        Donacion::create(['donante_id' => 3, 'campaña_id' => 2, 'método_pago_id' => 3, 'monto' => 50.00, 'fecha' => '2024-12-03']);
        Donacion::create(['donante_id' => 1, 'campaña_id' => 2, 'método_pago_id' => 1, 'monto' => 150.00, 'fecha' => '2024-12-03']);
    }
}
