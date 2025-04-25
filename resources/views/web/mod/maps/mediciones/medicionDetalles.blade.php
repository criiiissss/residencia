@extends('layouts.app')

@section('contenido')
<div class="divPrincipal">
    <div class="divExtendido">
        <h1>MEDICION - {{$fibras[0]->medicions->lineas->name}}</h1>
        <div>
            <div class="divMediciones">
                <div class="divMediciones2">
                    <div>
                        <h2>No - {{$fibras[0]->idMedicions}}</h2>
                        <h2>Punta A : {{$fibras[0]->medicions->obtenerPuntaA->name}} </h2>
                        <h2>Punta B : {{$fibras[0]->medicions->obtenerPuntaB->name}}</h2>
                        <a href="{{asset($fibras[0]->medicions->ubicacionPDF)}}"><button class="btn-descargar"><img src={{asset('image/pdf.png')}} class="img-btn-descargar">&nbsp;&nbsp;Descargar Archivo PDF</button></a>
                        <br>
                        <a href="{{asset($fibras[0]->medicions->ubicacionXLS)}}"><button class="btn-descargar"><img src={{asset('image/excel.png')}} alt="archivoExcel" class="img-btn-descargar">Descargar Archivo Excel</button></a>
                        <br>
                        <br>
                        <a href="{{route('mod-maps')}}"><button class="btn-regresar">Regresar</button></a>
                        <a href="{{route('medicion-mostrar-modificar',$fibras[0]->medicions->id)}}"><button class="btn-aceptar">Modificar Medición</button></a>
                    </div>
                </div>
                <div>
                    <div id="map"></div>
                </div>
            </div>
        </div>
        
        <div>
            <div>
                <h2>Tabla de Mediciones por Fibra</h2>
                <div class="tablaContainer2"> 
                    <table class="tablaMxF">
                        <thead>
                            <tr>
                                <td>No. Fibra</td>
                                <td>Medicion</td>
                                <td>Estado</td>
                                <td>Comentario</td>
                                <td>Archivo</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fibras as $fibra)
                                <tr>
                                    <td>{{$fibra->noFibra}}</td>
                                    <td>{{$fibra->medicion}}</td>
                                    <td>{{$fibra->estado}}</td>
                                    <td>{{$fibra->comentario}}</td>
                                    @if ($fibra->ubicacionXOR!=0)
                                        <td><a href="{{asset($fibra->ubicacionXOR)}}"><button>Descargar Archivo de Traza</button></a></td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
        <br>
        
        <form action="{{route('medicion-eliminar',$fibras[0]->medicions->id)}}" method="POST" name="eliminar">
            @csrf
            @method('DELETE')
        </form>
        <button onclick="eliminarr()" class="btn-regresar2">Eliminar</button>
        <a href="{{route('detalle-modificar',$fibras[0]->medicions->id)}}"><button class="btn-regresar1">Modificar Medicion en Fibras</button></a>
        <input value="{{$mitadEstructura}}" id="mitad" hidden>
    </div>
</div>
<script type="text/javascript">
    var Medicion = @JSON($medicion);
    var Estructuras = @JSON($estructuras);
    var Enlace = @JSON($enlace);
    var Fibras = @JSON($fibras);
    var mitad = document.getElementById("mitad").value;
    var puntaA = @JSON($puntaA);
    var puntaB = @JSON($puntaB)


    function eliminarr(){
            if(confirm('¿Seguro de eliminar esta medicin?')){
                document.eliminar.submit();
                return true;
            }
            else{
                return false;
            }
        }
        
    
    
    async function initMap() {
            const { Maps } = await google.maps.importLibrary("maps");
            const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker");
            const centro = {lat: parseFloat(Estructuras[mitad-1].lat), lng: parseFloat(Estructuras[mitad-1].lng)};
            map = new google.maps.Map(document.getElementById("map"),{
                zoom: 9,
                center: centro,
                mapTypeId: 'satellite',
                mapId: "MAPA",
                disableDefaultUI: true,
                scaleControl: true,
                //MAP TYPE CONTROLS
                mapTypeControl: true,
                mapTypeControlOptions:{ 
                    position: google.maps.ControlPosition.UP_LEFT,
                },
    
    
                fullscreenControl:true,
    
                fullscreenControlOptions:{
                    position: google.maps.ControlPosition.BOTTOM_LEFT,
                },
    
    
                zoomControl:true,
            });

        //GENERAR ARREGLO
        let arregloRutas = [];
            //PUNTA A
                
                const pin1 = new PinElement({
                        scale: 1,
                });
                var ubiA = {lat: parseFloat(puntaA.lat), lng: parseFloat(puntaA.lng)};
                arregloRutas.push(ubiA);
                new AdvancedMarkerElement({
                        position: ubiA,
                        map,
                        content: pin1.element,
                        title: "" + puntaA.name,
                    })

            //RESTO DE ESTRUCTURAS
                Estructuras.forEach(estructura => {
                    const pin2 = new PinElement({
                        scale: 0.5,
                    });

                    var ubicacion = {lat: parseFloat(estructura.lat), lng: parseFloat(estructura.lng)};
                    arregloRutas.push(ubicacion);

                    new AdvancedMarkerElement({
                            position: ubicacion,
                            map,
                            content: pin2.element,
                            title: "" + estructura.name,
                    })
                });

            //PUNTA B
                    const pin3 = new PinElement({
                            scale: 1,
                    });

                    
                    var ubiB = {lat: parseFloat(puntaB.lat), lng: parseFloat(puntaB.lng)};
                    arregloRutas.push(ubiB);
                    new AdvancedMarkerElement({
                                position: ubiB,
                                map,
                                content: pin3.element,
                                title: "" + puntaB.name,
                    })
            console.log(arregloRutas);
        
        //SELECCIONAR COLOR DE LA RUTA:


                var medidaAdecuada = 1;
                var medidaMedia = 0;
                var medidaBaja = 0;

                Fibras.forEach(medida => {
                    if (parseFloat(medida.medicion) > parseFloat(Enlace.atenuacionIdeal)) {
                        medidaBaja = 1;
                        medidaAdecuada = 0;
                    } else if(parseFloat(medida.medicion) >= ((parseFloat(Enlace.atenuacionIdeal)/8)*7)){
                        medidaAdecuada = 0;
                        medidaMedia = 1;
                    }
                });


            //COLOCAMOS EL COLOR DEL MAPA
                let color;
                if(medidaAdecuada == 1){
                    color = '#0ea612';
                }else{
                    if(medidaBaja == 1){
                        color = '#e40c10';
                    }else if(medidaMedia == 1){
                        color = '#f1e109';
                    }
                }
        //DIBUJAR RUTA

            rutaDibujada = new google.maps.Polyline({
                path: arregloRutas,
                geodesic:true,
                strokeColor: color,
                storkeOpacity: 1.0,
                strokeWeight: 5,
            });

        rutaDibujada.setMap(map);


    }
    window.initMap = initMap;
    </script>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>
@endsection