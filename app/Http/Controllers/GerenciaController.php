<?php

namespace App\Http\Controllers;

use App\Models\Gerencia;
use App\Models\Zona;
use App\Http\Requests\StoreGerenciaRequest;
use App\Http\Requests\UpdateGerenciaRequest;

class GerenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Gerencias = Gerencia::all();
        $zonas = Zona::all();
        return view('web.mod.gerencia.ver',compact('Gerencias','zonas'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGerenciaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Gerencia $gerencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gerencia $gerencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGerenciaRequest $request, Gerencia $gerencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gerencia $gerencia)
    {
        //
    }
}
