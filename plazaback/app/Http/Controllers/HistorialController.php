<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Historial;
use App\Models\Recarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Historial::with('cliente')->get();

    }

    public function fhistorial(Request $request){
        return Historial::with('cliente')->whereDate('fecha',$request->fecha)->get();
    }

    public function imprimir(Request $request){
        $rep=DB::SELECT('select lugar,count(*) as cantidad,sum(monto) as total from historial where date(fecha)="'.$request->fecha.'" GROUP BY lugar');
        $cadena="
        <div>Fecha:$request->fecha</div>
        <div>
        <table>
        <thead><tr><th>LUGAR</th><th>CANTIDAD</th><th>TOTAL</th></tr></thead>
        <tbody>
        ";
        foreach ($rep as $row) {

            $cadena.="<tr><td>$row->lugar</td><td>$row->cantidad</td><td>$row->total</td></tr>";
        }
        $cadena.="</tbody>
        </table>

        </div>

        ";
        return $cadena;
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
     * @param  \App\Models\Historial  $historial
     * @return \Illuminate\Http\Response
     */
    public function show($ci)
    {
//        return $ci;
        return Cliente::where('ci',$ci)->with('historials')->with('recargas')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Historial  $historial
     * @return \Illuminate\Http\Response
     */
    public function edit(Historial $historial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Historial  $historial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Historial $historial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Historial  $historial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Historial $historial)
    {
        //
    }
}
