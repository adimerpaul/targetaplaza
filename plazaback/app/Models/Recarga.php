<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recarga extends Model
{
    use HasFactory;
    protected $fillable=[
        'fecha',
        'hora',
        'monto',
        'cliente_id',
        'user_id'
    ];
    protected $table="recarga";
    public $timestamps=false;
    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
