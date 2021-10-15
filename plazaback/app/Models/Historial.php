<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;
    protected $fillable=[
        'fecha',
        'lugar',
        'numero',
        'cliente_id',
        'hora',
    ];
    public $timestamps=false;
    protected $table="historial";
    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
