<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donante extends Model
{
    use HasFactory;

    protected $table = 'donantes';

    protected $fillable = ['nombre', 'correo', 'teléfono'];

    public function donaciones() {
        return $this->hasMany(Donación::class);
    }
}
