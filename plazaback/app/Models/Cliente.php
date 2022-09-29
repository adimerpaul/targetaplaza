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
        'estado',
    ];
    protected $table='cliente';
    public $timestamps=false;
    public function recargas(){
        return $this->hasMany(Recarga::class);
    }
    public function historials(){
        return $this->hasMany(Historial::class);
    }
}
