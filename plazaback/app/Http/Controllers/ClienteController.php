<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Recarga;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cliente::orderBy('id','DESC')->get();
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
//        Cliente::create($re)
//        return $request;
        $cliente = new Cliente();
        $cliente->ci = $request->ci;
        $cliente->nombre = $request->nombre;
        $cliente->apellido = $request->apellido;
        $cliente->fechanac = $request->fechanac;
        $cliente->direccion = $request->direccion;
        $cliente->celular = $request->celular;
        $cliente->foto = '';
        $cliente->saldo = 0;
        $cliente->codigo = $request->codigo;
        $cliente->fecha = date('Y-m-d');
        $cliente->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
//        $cliente->update($request->all());
//        return $cliente->id;
        $cliente->saldo=$cliente->saldo+$request->monto;
        $cliente->save();
        $recarga=new Recarga();
        $recarga->fecha=date('Y-m-d');
        $recarga->hora=date('H:i:s');
        $recarga->monto=$request->monto;
        $recarga->cliente_id=$request->cliente_id;
        $recarga->user_id=$request->user()->id;
        $recarga->save();

$text="<style>
*{
  padding: 0px;
  margin: 0px;
  border: 0px;
}
</style>
<table style='width: 100%'>
<tr>
<td align='center'>Fecha</td>
<td align='center'>Hora</td>
<td align='center'>Ubicacion</td>
</tr>
<tr>
<td align='center'>".date('Y-m-d')."</td>
<td align='center'>".date('H:i:s')."</td>
<td align='center'>Multicines plaza</td>
</tr>
<tr><td align='center' colspan='3'>Codigo  ".substr($cliente->codigo,0,5)." ********</td></tr>
<tr><td align='center' colspan='3'>Monto  ******** ".$request->monto." Bs</td></tr>
<tr><td align='center' colspan='3'>Saldo  ******** ".$cliente->saldo." Bs</td></tr>
<tr><td align='center' colspan='3'>GRACIAS POR USAR</td></tr>
<tr><td align='center' colspan='3'>NUESTRA</td></tr>
<tr><td align='center' colspan='3'>RED DE ENLACE</td></tr>
</table>
";
return $text;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
    }

    public function clienteEstado(Request $request){
        $cliente=Cliente::find($request->id);
        if($cliente->estado=='ACTIVO')
            $cliente->estado='INACTIVO';
        else
            $cliente->estado='ACTIVO';
        $cliente->save();
    }
}
