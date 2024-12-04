<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MétodoPago extends Model
{
    use HasFactory;

    protected $table = 'metodospago';
    
    protected $fillable = ['nombre'];

    public function donaciones() {
        return $this->hasMany(Donación::class);
    }
}