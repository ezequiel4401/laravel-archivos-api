<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ArchivoControlador extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $elementos = Archivo::all();
        return $elementos;
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
        $elemento = new Archivo();
        $elemento->nombre = $request->nombre;
        $elemento->ref = $request->ref;
        $elemento->titulo = $request->titulo;
        $elemento->comentario = $request->comentario;

        $archivo = $request->file('archivo');
        $nombre = date('YmdHis') . '.' . $archivo->getClientOriginalExtension();
        $archivo->move('assets/', $nombre);
        $elemento->archivo = $nombre;

        $elemento->save();
        return $elemento;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $elemento = Archivo::find($id);
        return $elemento;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $elemento = Archivo::find($id);
        $elemento->nombre = $request->nombre;
        $elemento->ref = $request->ref;
        $elemento->titulo = $request->titulo;
        $elemento->comentario = $request->comentario;

        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombre = date('YmdHis') . '.' . $archivo->getClientOriginalExtension();
            $archivo->move('assets/', $nombre);

            $path = 'assets/' . $elemento->archivo;

            if (File::exists($path)) {
                File::delete($path);
            }
            
            $elemento->archivo = $nombre;
        }

        $elemento->save();
        return $elemento;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $elemento = Archivo::find($id);

        $path = 'assets/' . $elemento->archivo;

        if (File::exists($path)) {
            File::delete($path);
        }

        $elemento->delete();
        return $id;
    }

    public function obtenerPorRef($ref)
    {
        $elementos = Archivo::where('ref', $ref)->get();
        return $elementos;
    }
}
