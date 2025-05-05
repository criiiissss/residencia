<?php

namespace App\Http\Controllers\Maps;
use App\Http\Controllers\Controller;
use App\Models\Maps\Estructura;
use App\Models\Maps\Enlace;
use App\Models\Maps\Medicion;
use App\Models\Maps\EnlaceUbicacion;
use App\Models\Maps\Detalle;
use App\Models\Zona;
use App\Http\Requests\StoreEstructuraRequest;
use App\Http\Requests\UpdateEstructuraRequest;
use Illuminate\Http\Request;

class EstructuraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreEstructuraRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Estructura $estructura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estructura $estructura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstructuraRequest $request, Estructura $estructura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $estaEstructura = Estructura::findorfail($id);        
        $estaEstructura->delete();
        return back()->with('Estructura Eliminada Correctamente');
    }

    public function mostrarAgregar($id){
        $enlace = Enlace::findorfail($id);
        $estructur = Estructura::where('idEnlace',$id)->get()->last();
        if($estructur != null){
            $pass = 1;
        }
        else{
            $pass = 0;
        }

        $coordinatesArray = [];
        return view('web.mod.maps.enlaces.agregarEstructuras',compact('enlace','pass','estructur','coordinatesArray'));
    }

    public function agregarEstructuras($id, Request $request)
    {
    $estructuras = $request->input('estructuras');

    foreach ($estructuras as $data) {
        $estructura = new Estructura();
        $estructura->name = $data['name'];
        $estructura->lat = $data['lat'];
        $estructura->lng = $data['lng'];
        $estructura->cajaEmpalme = $data['tipo'];
        $estructura->distancia = $data['distancia'];
        $estructura->idEnlace = $id;
        $estructura->save();
    }

    return redirect()->route('estructura-enlace-resumen', $id);
    }

    public function modificarEstructuras($id){
        $estaEstructura = Estructura::findorfail($id);


        $tipoEstructura = $estaEstructura->cajaEmpalme;
        if($tipoEstructura == "si"){
            $otroTipo = "no";

        }
        else{
            $otroTipo = "si";
        }


        return view('web.mod.maps.enlaces.modificarEstructura',compact('estaEstructura','otroTipo','tipoEstructura'));
    }

    public function mostrarEnlaceResumen($id){
        $enlaceMostrados = Enlace::findorfail($id)->with('medic')->get();
        $estructurasMostrado = Estructura::where('idEnlace',$id)->get();
        
        foreach ($enlaceMostrados as $enlace) {
            if($enlace->id == $id){
                $enlaceMostrado = $enlace;
            }
        }
       
        //BUSCAR ESTRUCTURA CENTRAL
            $mitadEstructura = count($estructurasMostrado);
            if ($mitadEstructura %2 == 1) {
                $mitadEstructura = ($mitadEstructura/2) + 0.5;
            }else{
                $mitadEstructura = $mitadEstructura / 2;
            }
        //BUSCAR PUNTAS
            $puntas = EnlaceUbicacion::where('enlace_id',$id)->with('ubicacion')->orderBy('punta','asc')->get();
        
            
        return view('web.mod.maps.enlaces.resumen',compact('enlaceMostrado','estructurasMostrado','mitadEstructura','puntas'));
    }

    public function reescribirEstructuras($id, Request $request){
        $estaEstructura = Estructura::findorfail($id);
        $estaEstructura->name = $request->name;
        $estaEstructura->lat = $request->lat;
        $estaEstructura->lng = $request->lng;
        $estaEstructura->cajaEmpalme = $request->tipo;
        $estaEstructura->save();
        return redirect(route('estructura-enlace-resumen',$estaEstructura->idEnlace));
        
    }


}
