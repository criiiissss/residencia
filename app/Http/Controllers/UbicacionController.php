<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Ubicacion;
use App\Models\Gerencia;
use App\Models\Zona;
use App\Models\Maps\EnlaceUbicacion;
use App\Http\Requests\StoreUbicacionRequest;
use App\Http\Requests\UpdateUbicacionRequest;
use Illuminate\Http\Request;


class UbicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gerencias = Gerencia::all();
        $zonas = Zona::all();
        $ubicaciones = Ubicacion::all();
        $ubicacionesZonas = Ubicacion::with('zona')->get();
        $csrfToken = csrf_token();
        $enlaceUbicacion = EnlaceUbicacion::all();


        return view('web.mod.maps.ubicaciones.verUbi',compact('ubicaciones','gerencias','zonas','ubicacionesZonas','csrfToken','enlaceUbicacion'));
    }
    

    public function verCreate(){
        $Gerencias = Gerencia::all();
        $Zonas = Zona::all();
        return view('web.mod.maps.ubicaciones.crear', compact('Gerencias','Zonas'));
    }
    public function create(Request $request)
    {
        $nuevaUbicacion = new Ubicacion();
        $nuevaUbicacion->name = $request->name;
        $nuevaUbicacion->abreviacion = $request->abrv;
        $nuevaUbicacion->idZona = $request->zona;
        $nuevaUbicacion->lat = $request->lat;
        $nuevaUbicacion->lng = $request->lng;
        $nuevaUbicacion->direccion = $request->direccion;
        $nuevaUbicacion->save();

        return redirect(route('ubicaciones-ver'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUbicacionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ubicacion $ubicacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ubicacion $ubicacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUbicacionRequest $request, Ubicacion $ubicacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ubicacion = Ubicacion::findorfail($id);
        $ubicacion->delete();
        return redirect(route('ubicaciones-ver'));
    }

    public function verDetalle($id){
        $G = [];
        $Gerencias = Gerencia::all();
        $Zonas = Zona::all();
        $Enlaces = EnlaceUbicacion::where('Ubicacion_id', $id)->with('enlace')->get();
        $ubiZonas = Ubicacion::with('zona.gerencia')->where('id',$id)->get();
        $Ubicacion = Ubicacion::findorfail($id);

        foreach ($ubiZonas as $ubi) {
            if(in_array($ubi->zona->gerencia->name, $G)){
                
            }else{
                array_push($G,$ubi->zona->gerencia->name);
            }
        }
        
        return view('web.mod.maps.ubicaciones.ubicacionDetalles',compact('Gerencias','Zonas','ubiZonas','Ubicacion','Enlaces','G'));
    }

    public function modificarUbicacion($id){
        $estaUbicacion = Ubicacion::with('zona')->where('id',$id)->get();
        $gerencias = Gerencia::all();
        $zonas = Zona::all();
        $enlaceUbicacion = EnlaceUbicacion::where('ubicacion_id',$id)->get();
        return view('web.mod.maps.ubicaciones.modificarUbicacion',compact('estaUbicacion','gerencias','zonas','enlaceUbicacion'));
    }

    public function reescribirUbicacion(Request $request,$id){
        $estaUbicacion = Ubicacion::findorfail($id);
        $estaUbicacion->idZona = $request->idZona;
        $estaUbicacion->name = $request->name;
        $estaUbicacion->lat = $request->lat;
        $estaUbicacion->lng = $request->lng;
        $estaUbicacion->abreviacion = $request->abreviacion;
        $estaUbicacion->direccion = $request->direccion;
        $estaUbicacion->save();
        return redirect(route('ubicaciones-ver'));
    }
}
