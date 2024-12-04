<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaña extends Model
{
    use HasFactory;


    protected $table = 'campañas';
    protected $fillable = ['nombre', 'meta_recaudación'];

    public function donaciones() {
        return $this->hasMany(Donación::class);
    }
}

