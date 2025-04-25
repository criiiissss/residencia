<?php

namespace App\Http\Controllers\Maps;
use App\Http\Controllers\Controller;
use App\Models\Maps\Detalle;
use App\Models\Maps\Medicion;
use App\Models\Maps\Enlace;
use App\Http\Requests\StoreDetalleRequest;
use App\Http\Requests\UpdateDetalleRequest;
use Illuminate\Http\Request;

class DetalleController extends Controller
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
    public function create(Request $request)
    {
        $ayudas = $request->mediciones;
        $objeto = json_decode($ayudas);
        $i = 1;
       $idEnlace = Medicion::findorfail($request->idMedicion)->with('lineas')->get();
       $medkit = Medicion::findorfail($request->idMedicion);
    

        $mayor = 0;
        
        foreach ($objeto as $medicion) {
            $i = $i+1;
            $nuevaMedicion = new Detalle();
            $nuevaMedicion->idMedicions = $request->idMedicion;
            $nuevaMedicion->noFibra = $medicion->noFibra;
            $nuevaMedicion->estado = $medicion->estado;
            if($medicion->medicion == "SIN MEDIDAS ANTERIORES"){
                $nuevaMedicion->medicion = 0;
            }else {
                $nuevaMedicion->medicion = $medicion->medicion;
                if($mayor < $nuevaMedicion->medicion){
                    $mayor = $nuevaMedicion->medicion;
                }
                
            }
            $nuevaMedicion->comentario = $medicion->comentario;
            if($request->{'xor_'.$medicion->noFibra} !== null){
                $archivoxor = $request->file('xor_'.$medicion->noFibra);
                $nuevaMedicion->ubicacionXOR = asset('storage/'.$archivoxor->store());
              }
            $nuevaMedicion->save();
        }
        
        if ($mayor != 0) {
            $Medic = Medicion::findorfail($request->idMedicion);
            $Medic->atenuacionReal = $mayor;
            $Medic->save();
        }
        
        return redirect(route('medicion-ver'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDetalleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Detalle $detalle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Detalle $detalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $ayudas = $request->estructuras;
        $objeto = json_decode($ayudas);
        $medicionNueva = 0;
        $idEnlace = Medicion::with('lineas');
        
        foreach ($objeto as $fibraMedicion){
            $fibra = Detalle::findorfail($fibraMedicion->id);
            $fibra->estado = $fibraMedicion->estado;
            if($fibraMedicion->medicion == "NO TIENE MEDICION PASADA"){
                $fibra->medicion = 0;
            }else {
                $fibra->medicion = $fibraMedicion->medicion;
            }
            $fibra->comentario = $fibraMedicion->comentarios;
            $id = $fibra->idMedicions;
            $fibra->save();
        }
        return redirect(route('mediciones-detalles',$id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Detalle $detalle)
    {
        //
    }

    public function modificarDetalle($id){
        $estaMedicion = Medicion::findorfail($id);
        $MedicionFibras = Detalle::where('idMedicions',$id)->with('medicions.lineas')->get();
        $medicionPasada = Medicion::where('idLinea',$estaMedicion->idLinea)->orderBy('fecha','asc')->first();
        if($medicionPasada->id == $estaMedicion->id){
            $medicionPasada = null;
            $fibrasAnteriores = null;
        }else {
            $fibrasAnteriores = Detalle::where('idMedicions',$medicionPasada->id)->get();
        }
        return view('web.mod.maps.detalles.modificarDetalle',compact('MedicionFibras','medicionPasada','fibrasAnteriores'));
    }
}
