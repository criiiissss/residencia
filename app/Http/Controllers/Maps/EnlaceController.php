<?php

namespace App\Http\Controllers\Maps;
use App\Http\Controllers\Controller;
use App\Models\Maps\Enlace;
use App\Models\Maps\Estructura;
use App\Models\Ubicacion;
use App\Models\Maps\EnlaceUbicacion;
use App\Models\Zona;
use App\Models\Gerencia;
use App\Models\EnlaceZona;
use App\Http\Requests\StoreEnlaceRequest;
use App\Http\Requests\UpdateEnlaceRequest;
use Illuminate\Http\Request;

class EnlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('web.mod.maps.main');
    }

    public function crear(){

        $ubicaciones = Ubicacion::all();
        $zonas = Zona::with('gerencia')->get();
        $gerencias = Gerencia::all();
        $enlaces = Enlace::all();
        return view('web.mod.maps.enlaces.nombreEnlace',compact('ubicaciones','enlaces','gerencias','zonas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $nuevoEnlae = new Enlace();
       
        $nuevoEnlae->tipo = $request->tipo;
        if($request->tipo == "Subterraneo"){
            $nuevoEnlae->name = $request->sub;
        }
        else{
            $nuevoEnlae->name = ("{$request->izq}-{$request->centro}{$request->centro2}-{$request->dcho}");
        }
        
        $nuevoEnlae->noFibras = $request->noFibras;
        $nuevoEnlae->save();

        $nuevaUbicacion = new EnlaceUbicacion();
        $nuevaUbicacion->enlace_id = $nuevoEnlae->id;
        $nuevaUbicacion->ubicacion_id = $request->ubi1;
        $nuevaUbicacion->punta = 'a';
        $nuevaUbicacion->save();

        $OtraUbicacion = new EnlaceUbicacion();
        $OtraUbicacion->ubicacion_id = $request->ubi2;
        $OtraUbicacion->enlace_id= $nuevoEnlae->id;
        $OtraUbicacion->punta = 'b';
        $OtraUbicacion->save();
        $nuetroId = $nuevoEnlae->id;


        $enlaceZona = new EnlaceZona();
        $enlaceZona->enlace_id = $nuevoEnlae->id;
        $enlaceZona->zona_id = $request->zonaA;
        $enlaceZona->save();

        $enlaceZona2 = new EnlaceZona();
        $enlaceZona2->enlace_id = $nuevoEnlae->id;
        $enlaceZona2->zona_id = $request->zonaB;
        $enlaceZona2->save();

        
        return redirect(route('enlace-atenuacion',$nuetroId));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEnlaceRequest $request)
    {
        //
    }

    public function modificarEnlace($id, Request $request){

        $enlaceModificado = Enlace::findorfail($id);
       
        $enlaceModificado->km = $request->km;
        $enlaceModificado->atenuacionKm = $request->aKm;
        $enlaceModificado->conectores = $request->ctor;
        $enlaceModificado->atenuacionConectores = $request->aCtor;
        $enlaceModificado->cajasEmpalme = $request->cCajas;
        $enlaceModificado->atenuacionCajas = $request->aCaja;
        $enlaceModificado->atenuacionIdeal = $request->atenuacionIdeal;
        $enlaceModificado->save();

        

        return redirect(route('estructuras-agregar-pantalla',$enlaceModificado->id));
    }

    /**
     * Display the specified resource.
     */
    public function show(Enlace $enlace)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enlace $enlace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEnlaceRequest $request, Enlace $enlace)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function preDestroy($id){
        $esteEnlace = Enlace::findorfail($id);
        $esteEnlace->delete();
        return redirect(route('mod-maps'));
    }
    
    public function destroy($id)
    {
        $esteEnlace = Enlace::findorfail($id);
        $estasEstructuras = Estructura::where('idEnlace', $id)->get();
        if($estasEstructuras != null){
            foreach($estasEstructuras as $estructuras){
                $estructuras->delete();
            }
        }
        $esteEnlace->delete();

        return redirect(route('mod-maps'));
    }

    public function atenuacionIdeal($id){
        $enlace = enlace::findorfail($id);
        return view('web.mod.maps.enlaces.atenuacionIdeal', compact('enlace'));
    }

    public function ver(){
        $enlaces =  Enlace::with('zona')->get();
        $gerencias = Gerencia::all();
        $zonas = Zona::with('gerencia')->get();
        $estructuras = Estructura::all()->groupBy('idEnlace');
        return view('web.mod.maps.enlaces.verEnlaces',compact('enlaces','gerencias','zonas','estructuras'));
    }

    public function verModificar($id){
        $thisEnlace = Enlace::findorfail($id);
        $ubi = Ubicacion::all();
        $ubicacionEnlace = $thisEnlace->ubicaciones()->orderBy('punta','asc')->get();

        if($thisEnlace->tipo == '400KV'){
            $type = 'A3';
        }
        elseif($thisEnlace->tipo == '230KV'){
            $type = '93';
        }   
        elseif($thisEnlace->tipo == '115KV'){
            $type = '73';
        }
        elseif($thisEnlace->tipo == '13.8KV'){
            $type = '40';
        }else{
            $type = '';
        }

        $tipos = ['400KV','230KV','115KV','13.8KV','Subterraneo'];
        $zonas = Zona::all();
        $gerencias = Gerencia::all();
        $zonaUbi = Ubicacion::all();
        if($thisEnlace->tipo == "Subterraneo"){
            $nombre = $thisEnlace->name;
        }else{
            $nombre2 = explode("-",$thisEnlace->name);
            $nombre = substr($nombre2[1],2);
        }
        return view('web.mod.maps.enlaces.modificarEnlace',compact('thisEnlace','ubi','ubicacionEnlace','type','nombre','id','tipos','zonas','gerencias','zonaUbi'));
    }

    public function reescribirEnlace($id, Request $request){
        $enlaceReescribir = Enlace::findorfail($id);
        if($request->tipo == "Subterraneo"){
            $enlaceReescribir->name = $request->subte;
        }
        else{
            $enlaceReescribir->name = ("{$request->izq}-{$request->medio}{$request->medio2}-{$request->drcho}");
        }

        $enlaceReescribir->tipo = $request->tipo;
        $enlaceReescribir->km = $request->km;
        $enlaceReescribir->atenuacionKm = $request->atenuacionKm;
        $enlaceReescribir->conectores = $request->conectores;
        $enlaceReescribir->atenuacionConectores = $request->atenuacionConectores;
        $enlaceReescribir->atenuacionIdeal = $request->atenuacionIdeal;
        $enlaceReescribir->idZona = $request->zona;
        $enlaceReescribir->cajasEmpalme = $request->cajas;
        $enlaceReescribir->atenuacionCajas = $request->atenuacioncajas;

        $abreviacionIZQ = $request->izq;
        $abreviacionDRCHO = $request->drcho;
        $idEnlace = $enlaceReescribir->id;
        $ubicaciones = EnlaceUbicacion::where('enlace_id',$idEnlace)->get();
        $puntaA = Ubicacion::where('abreviacion',$abreviacionIZQ)->get();
        $puntaB = Ubicacion::where('abreviacion',$abreviacionDRCHO)->get();

        foreach ($ubicaciones as $ubi) {
            if($ubi->punta == "a"){
                $ubi->ubicacion_id = $puntaA[0]->id;
            }
            else{
                $ubi->ubicacion_id = $puntaB[0]->id;
            }

            $ubi->save();
            
        }
        $enlaceReescribir->save();

        
        return redirect(route('estructura-enlace-resumen', $id));
    }
    public function verTabla(){
        $enlaces = Enlace::with('medic','ubicaciones')->get();
        $ubicaciones = Ubicacion::with('enlaces.medic')->get();
        return view('web.mod.maps.tabla',compact('enlaces','ubicaciones'));
    }

    public function decisionKMZ($id){
        $enlace = Enlace::findorfail($id);
        return view('web.mod.maps.enlaces.subirArchivoKMZ',compact('enlace'));
    }

    public function leerKMZL(Request $request, $id)
{
    // Verificar los datos que llegan al controlador
    $enlace = Enlace::findOrFail($id);
    $archivo = $request->file('archivo');
    
    // Validar que el archivo es un KMZ
    $request->validate([
        'archivo' => 'required|file|mimes:zip',  // Validar solo archivos KMZ
    ]);
    
    // Obtener el nombre del archivo y guardarlo
    $nombreArchivo = time() . '-' . $archivo->getClientOriginalName();
    $rutaArchivo = $archivo->storeAs('kmz/', $nombreArchivo);  // Guardar en storage/app/public/kmz
    
    // Obtener la ruta completa del archivo KMZ
    $kmzPath = storage_path('app/public/kmz/' . $nombreArchivo);
    
    // Verificar si el archivo existe
    if (!file_exists($kmzPath)) {
        return redirect()->to('/')->withErrors('El archivo KMZ no se encuentra en la ruta: ' );
    }
    

    // Crear el directorio de extracción si no existe
    $extractPath = storage_path('app/public/kmz-extract/' . pathinfo($nombreArchivo, PATHINFO_FILENAME));
    if (!file_exists($extractPath)) {
        mkdir($extractPath, 0755, true);
    }

    // Descomprimir el archivo KMZ (es un archivo ZIP)
    $zip = new \ZipArchive();
    if ($zip->open($kmzPath) === true) {
        $zip->extractTo($extractPath);
        $zip->close();
    } else {
        return redirect()->to('/')->withErrors('No se pudo descomprimir el archivo KMZ');
    }


    /////////////////////////////////////////////////

    // Buscar el archivo KML dentro del directorio extraído
    $kmlFiles = glob("$extractPath/*.kml");

    if (empty($kmlFiles)) {
        return redirect()->route('modulos')->withErrors('No se encontró un archivo KML en el KMZ');
    }

    $kmlFile = $kmlFiles[0];

    $kmlContent = file_get_contents($kmlFile);

    // Mostrar el contenido para depuración
    dd($kmlContent);

    ////////////////////////////////////////////////

    // Procesar el archivo KML
    $kmlContent = file_get_contents($kmlFile);
    $xml = simplexml_load_string($kmlContent, "SimpleXMLElement", LIBXML_NOCDATA);

    // Verificar los namespaces disponibles en el KML
    $namespaces = $xml->getNamespaces(true);

    // Acceder al espacio de nombres vacío
    $kml = $xml->children($namespaces['']);  // Usar el espacio de nombres vacío

    // Extraer coordenadas y datos
    $coordinatesArray = [];
    foreach ($kml->Document->Placemark as $placemark) {
        $data = [
            'coordenadas' => [],
            'caja_empalme' => false,
            'numero' => null,
        ];

        // Extraer coordenadas
        if (isset($placemark->Point->coordinates)) {
            $coordinates = trim((string)$placemark->Point->coordinates);
            $data['coordenadas'] = explode(',', $coordinates);
        }

        // Extraer número del <name>
        if (isset($placemark->name)) {
            $data['numero'] = (int)(string)$placemark->name;
        }

        // Verificar si tiene "CAJA DE EMPALME"
        if (isset($placemark->description) && stripos((string)$placemark->description, 'CAJA DE EMPALME') !== false) {
            $data['caja_empalme'] = true;
        }

        $coordinatesArray[] = $data;
    }

    // Ordenar por número en <name>
    usort($coordinatesArray, function ($a, $b) {
        return $a['numero'] <=> $b['numero'];
    });

    // Eliminar archivos temporales
    unlink($kmzPath);
    array_map('unlink', glob("$extractPath/*.*"));
    rmdir($extractPath);

    // Verificar si ya existe una estructura relacionada
    $estructur = Estructura::where('idEnlace', $id)->latest()->first();
    $pass = ($estructur != null) ? 1 : 0;

    // Retornar la vista con los datos
    return view('web.mod.maps.enlaces.agregarEstructuras', compact('enlace', 'pass', 'estructur', 'coordinatesArray'));
}
 

    
}

