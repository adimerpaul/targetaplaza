<?php

namespace App\Http\Controllers;

use App\Models\Recarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Recarga::with('user')->with('cliente')->get();
    }

    public function listRecarga(){
        return DB::SELECT("SELECT r.fecha,r.hora,r.monto,c.nombre,c.apellido,u.name 
        from recarga r inner join cliente c on r.cliente_id=c.id inner join users u on r.user_id=u.id");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recarga  $recarga
     * @return \Illuminate\Http\Response
     */
    public function show(Recarga $recarga)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recarga  $recarga
     * @return \Illuminate\Http\Response
     */
    public function edit(Recarga $recarga)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recarga  $recarga
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recarga $recarga)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recarga  $recarga
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recarga $recarga)
    {
        //
    }
}
