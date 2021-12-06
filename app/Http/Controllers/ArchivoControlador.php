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
        $datos = Archivo::all();
        return $datos;
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
        $dato = new Archivo();
        $dato->nombre = $request->nombre;
        $dato->ref = $request->ref;
        $dato->titulo = $request->titulo;
        $dato->comentario = $request->comentario;

        $archivo = $request->file('archivo');
        $nombre = date('YmdHis') . '.' . $archivo->getClientOriginalExtension();
        $archivo->move('assets/', $nombre);
        $dato->archivo = $nombre;

        $dato->save();
        return $dato;
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
        $dato = Archivo::find($id);
        return $dato;
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
        $dato = Archivo::find($id);
        $dato->nombre = $request->nombre;
        $dato->ref = $request->ref;
        $dato->titulo = $request->titulo;
        $dato->comentario = $request->comentario;

        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombre = date('YmdHis') . '.' . $archivo->getClientOriginalExtension();
            $archivo->move('assets/', $nombre);

            $path = 'assets/' . $dato->archivo;

            if (File::exists($path)) {
                File::delete($path);
            }
            
            $dato->archivo = $nombre;
        }

        $dato->save();
        return $dato;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dato = Archivo::find($id);

        $path = 'assets/' . $dato->archivo;

        if (File::exists($path)) {
            File::delete($path);
        }

        $dato->delete();
        return $id;
    }

    public function obtenerPorRef($ref)
    {
        $datos = Archivo::where('ref', $ref)->get();
        return $datos;
    }
}
