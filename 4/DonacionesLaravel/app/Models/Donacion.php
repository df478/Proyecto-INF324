<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donacion extends Model
{
    use HasFactory;

    protected $table = 'donaciones';

    protected $fillable = [
        'donante_id',
        'campaña_id',
        'método_pago_id',
        'monto',
        'fecha',
    ];

    public function donante() {
        return $this->belongsTo(Donante::class);
    }

    public function campaña() {
        return $this->belongsTo(Campaña::class);
    }

    public function métodoPago() {
        return $this->belongsTo(MétodoPago::class);
    }
}

