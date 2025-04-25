<?php

namespace App\Http\Controllers\Maps;
use App\Http\Controllers\Controller;
use App\Models\Maps\Medicion;
use App\Models\Maps\Estructura;
use App\Models\Maps\Enlace;
use App\Models\Maps\Detalle;
use App\Models\Ubicacion;
use App\Models\Gerencia;
use App\Models\Zona;
use App\Models\Maps\EnlaceUbicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreMedicionRequest;
use App\Http\Requests\UpdateMedicionRequest;

class MedicionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Gerencias = Gerencia::all();
        $Zonas = Zona::all();
        $Enlaces = Enlace::with('zona')->get();
        $Mediciones = Medicion::with('obtenerPuntaA','obtenerPuntaB','lineas.zona')->orderBy('fecha','desc')->get();
        return view('web.mod.maps.mediciones.verMedicion',compact('Mediciones','Zonas','Gerencias','Enlaces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $nuevaMedicion = new Medicion();
        $nuevaMedicion->idPuntaA = $request->puntaA;
        $nuevaMedicion->idPuntaB = $request->puntaB;
        $nuevaMedicion->idLinea = $request->sEnlace;
        $nuevaMedicion->fecha = $request->fecha;
        $archivoPDF = $request->file('pdffile');
        $archivoXLS = $request->file('xlsfile');
        
        $nuevaMedicion->ubicacionPDF = asset('storage/'.$archivoPDF->store());
        $nuevaMedicion->ubicacionXLS = asset('storage/'.$archivoXLS->store());
        $nuevaMedicion->save();

        $lineaTomada = Enlace::findorfail($request->sEnlace)->with('medic')->get();
        
        if($lineaTomada[0]->idMedicionUltima == null){
            $lineaTomada[0]->idMedicionUltima = $nuevaMedicion->id;
            $lineaTomada[0]->save();
            
        }else{
            $fechaMedicion = strtotime($request->fecha);
            $fechaUltima = strtotime($lineaTomada[0]->medic->fecha);

            if($fechaMedicion >= $fechaUltima){
                $lineaTomada[0]->idMedicionUltima = $nuevaMedicion->id;
                $lineaTomada[0]->save();
            }
        }

        

        
        return redirect(route('medicion-detallar',$nuevaMedicion->id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicion $medicion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicion $medicion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicionRequest $request, Medicion $medicion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function preDestroy($id){
        $estaMedicion = Medicion::findorfail($id);
        Storage::delete(basename($estaMedicion->ubicacionPDF));
        Storage::delete(basename($estaMedicion->ubicacionXLS));

        $enlace = Enlace::where('idMedicionUltima',$estaMedicion->id)->get();
        $estaMedicion->delete();
        if($enlace[0] != null){
            $enlace[0]->idMedicionUltima = null;
            $enlace[0]->save();

            //BUSCAR ULTIMA MEDICION

            $medicion = Medicion::where('idLinea',$enlace[0]->id)->orderby('fecha','desc')->first();
            $enlace[0]->idMedicionUltima = $medicion->id;
            $enlace[0]->save();
        }

        


        return redirect(route('medicion-ver'));
    }

    public function destroy($id)
    {
        $estaMedicion = Medicion::findorfail($id);
        $fibras = Detalle::where('idMedicions',$id)->get();
        Storage::delete(basename($estaMedicion->ubicacionPDF));
        Storage::delete(basename($estaMedicion->ubicacionXLS));
        foreach ($fibras as $fibra) {
            $estaFibra = Detalle::findorfail($fibra->id);
            $estaFibra->delete();
        }
        $estaMedicion->delete();
        return redirect(route('medicion-ver'));


    }

    public function tomarMediciones(){
        $Gerencias = Gerencia::all();
        $Zonas = Zona::all();
        $Enlaces = Enlace::with('zona')->get();
        $Ubicaciones = Ubicacion::with('enlaces')->get();
        return view('web.mod.maps.mediciones.tomarMedicion', compact('Enlaces','Ubicaciones','Zonas', 'Gerencias'));
    }

    

    public function detallar($id){

        $estaMedicion = Medicion::findorfail($id);
        $medicionPasada = Medicion::where('idLinea',$estaMedicion->idLinea)->orderBy('id','desc')->skip(1)->first();
        if($medicionPasada == null){
            $detallesPasado = 0;
        }
        else{
            $detallesPasado = Detalle::where('idMedicions',$medicionPasada->id)->orderBy('noFibra','asc')->get();
        }
        $lineas = Enlace::findorfail($estaMedicion->idLinea);

        return view('web.mod.maps.mediciones.fibrasMedicion',compact('estaMedicion','medicionPasada','detallesPasado','lineas'));

    }

    public function detalles($id){
        $fibras = Detalle::where('idMedicions',$id)->with('medicions')->get();
        $medicion = Medicion::findorfail($id);
        $estructuras = Estructura::where('idEnlace',$medicion->idLinea)->get();
        $enlace = Enlace::findorfail($medicion->idLinea);
        $mitadEstructura = count($estructuras);
        if ($mitadEstructura %2 == 1) {
            $mitadEstructura = ($mitadEstructura/2) + 0.5;
        }else{
            $mitadEstructura = $mitadEstructura / 2;
        }

        $puntaA = $enlace->ubicaciones[0];
        $puntaB = $enlace->ubicaciones[1];
        
        
        

        return view('web.mod.maps.mediciones.medicionDetalles', compact('fibras','medicion','estructuras','enlace','mitadEstructura','puntaA','puntaB'));
    }

    public function mostrarModificar($id){
        $MedicionModificar = Medicion::where('id',$id)->with('lineas','obtenerPuntaA','obtenerPuntaB','medicions')->get();
        $ubicacionMediciones = EnlaceUbicacion::where('enlace_id',$MedicionModificar[0]->idLinea)->with('ubicacion')->get();

        $existePuntaA = 0;
        $existePuntaB = 0;

        foreach ($ubicacionMediciones as $ubicaciones) {
            if($ubicaciones->ubicacion_id == $MedicionModificar[0]->idPuntaA){
                $existePuntaA = 1;
            }
            if($ubicaciones->ubicacion_id == $MedicionModificar[0]->idPuntaB){
                $existePuntaB = 1;
            }
        }
        return view('web.mod.maps.mediciones.medicionModificar',compact('MedicionModificar','ubicacionMediciones','existePuntaA','existePuntaB'));
    }

    public function modificarMediciones($id,Request $request){

        $medicionModificada = Medicion::findorfail($id);

        $medicionModificada->idPuntaA = $request->puntaA;
        $medicionModificada->idPuntaB = $request->puntaB;
        $medicionModificada->fecha = $request->fecha;       
        //Storage::delete(basename($medicionModificada->ubicacionPDF));
        //Storage::delete(basename($medicionModificada->ubicacionXLS));


        $archivoPDF = $request->file('pdf');
        $archivoXLS = $request->file('xls');

        if($archivoPDF == null){
            $medicionModificada->ubicacionPDF = $medicionModificada->ubicacionPDF;
        }
        else{
            Storage::delete(basename($medicionModificada->ubicacionPDF));
            $medicionModificada->ubicacionPDF = asset('storage/'.$archivoPDF->store());
        }
        if($archivoXLS == null){
            $medicionModificada->ubicacionXLS = $medicionModificada->ubicacionXLS;
        }
        else{
            Storage::delete(basename($medicionModificada->ubicacionXLS));
            $medicionModificada->ubicacionXLS = asset('storage/'.$archivoXLS->store());
        }
        $medicionModificada->save();

        return redirect(route('medicion-ver'));
    }
}
