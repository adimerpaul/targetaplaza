<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable=[
        'ci',
        'nombre',
        'apellido',
        'fechanac',
        'direccion',
        'celular',
        'foto',
        'saldo',
        'codigo',
        'fecha',
    ];
    protected $table='cliente';
    public $timestamps=false;
}
