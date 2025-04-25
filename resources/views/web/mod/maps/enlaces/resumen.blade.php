@extends('layouts.app')

@section('contenido') 
    <div class="divPrincipal">
        <div class="divExtendido">   
            <div>
                <div>
                    <h1 id="fadein">Nombre del enlace:<br> {{$enlaceMostrado->name}}</h1>
                    <div id="map"></div>
                    
                </div>
                <div>
                    <div class="cajas">
                        <h2 class="aIdealVSaActual">Atenuacion ideal: <br>{{bcdiv($enlaceMostrado->atenuacionIdeal,'1',2)}}</h2>
                        <hr id="fadeLinea">
                        @if ($enlaceMostrado->medic == NULL)
                            <h2 class="aIdealVSaActual">No se cuenta con una medicion anterior</h2>  
                        @else
                            <h2 class="aIdealVSaActual">Atenuación real: <br>{{bcdiv($enlaceMostrado->medic->atenuacionReal,'1',2)}}</h2>
                        @endif
                            
                    </div>
                </div>
            </div>
            <div>
                <hr>
                <h2>Tensión :{{$enlaceMostrado->tipo}}</h2>
                <hr>
            </div>
            <div>
                <div>
                    <table>
                        <tr>
                            <td>Kilometros:</td>
                            <td><h2>{{bcdiv($enlaceMostrado->km,'1',2)}} Km</h2></td>
                        </tr>
                        <tr>
                            <td>Atenuacion del <br>total de Kilometros:</td>
                            <td><h2>{{bcdiv($enlaceMostrado->atenuacionKm,'1',2)}} dB</h2></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table>
                        <tr>
                            <td>Cantidad de conectores:</td>
                            <td><h2>{{$enlaceMostrado->conectores}}</h2></td>
                        </tr>
                        <tr>
                            <td>Atenuación del <br>total de conectores: </td>
                            <td><h2>{{bcdiv($enlaceMostrado->atenuacionConectores,'1',2)}} dB</h2></td>
                        </tr>
                    </table>                                     
                </div>
                <div>
                    <table>
                        <tr>
                            <td>Cantidad de cajas de empalme</td>
                            <td><h2>{{$enlaceMostrado->cajasEmpalme}}</h2></td>
                        </tr>
                        <tr>
                            <td>Atenuación del <br> total de cajas de empalme:</td>
                            <td><h2>{{bcdiv($enlaceMostrado->atenuacionCajas,'1',2)}} dB</h2></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div>
                @if(auth()->user()->rol == 'level3')
                    <form action="{{route('enlace-eliminar',$enlaceMostrado->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Estas seguro de eliminar el enlace {{$enlaceMostrado->name}}')" class="btn-regresar2">Eliminar</button>
                    </form>
                @endif
                <a href="{{route('mod-maps')}}"><button class="btn-aceptar">Continuar</button></a>
            </div>
            <div>
                @if(auth()->user()->rol == 'level2' || auth()->user()->rol == 'level3')
                    <a href="{{route('enlace-verModificar',$enlaceMostrado->id)}}"><button class="btn-aceptar2">Modificar Enlace</button></a>
                @endif    
                <input type="text" value="{{$mitadEstructura}}" id="es" hidden>
            </div>
            <div>
                <hr>
                <h2>ESTRUCTURAS</h2>
                <hr>
                @if(auth()->user()->rol == 'level2' || auth()->user()->rol == 'level3')
                <a href="{{route('estructuras-agregar-pantalla',$enlaceMostrado->id)}}"><button class="btn-aceptar3">Agregar Estructuras</button></a>
                @endif
            </div>
            <div>
                <div>
                    <div>
                    <table class="tablaCustom">
                        <thead>
                            <tr class="trTitulo">
                                <th>No</th>
                                <th>Nombre</th>
                                <th>Cuenta con <br>caja de empalme</th>
                                <th>Latitud</th>
                                <th>Longitud</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="tablaContainer">      
                        <table class="tablaCustom" id="table">
                            <tbody> 
                                <input hidden value="{{$count = 0}}">
                                @foreach ($estructurasMostrado as $est)
                                <tr>
                                    <td>{{$count = $count + 1}}</td>
                                    <td>{{$est->name}}</td>
                                    <td>{{$est->cajaEmpalme}}</td>
                                    <td>{{$est->lat}}</td>
                                    <td>{{$est->lng}}</td>
                                    @if (auth()->user()->rol == 'level2' || auth()->user()->rol == 'level3')
                                        <td><a href="/modulos/maps/enlace/crear/agregarEstructuras/modificar{{$est->id}}"><button>Modificar</button></a>
                                        <form action="{{ route('estructuras-eliminar', $est->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Seguro que quieres eliminar la estructura {{$est->name}}?')">Eliminar</button>
                                        </form>
                                    </td>
                                @endif
                                    </tr>
                                    <tr>
                                    <td colspan="7"><hr></td>
                                    </tr>
                                @endforeach
                            </tbody> 
                        </table>
                        <br>
                        <br>
                        <br>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    

<script type="text/javascript">
    var estructura = @JSON($estructurasMostrado);
    var mitad = document.getElementById("es").value;
    var puntas = @JSON($puntas);

    var enlace = @JSON($enlaceMostrado);
    let map;
    let arregloRuta = [];
    


    console.log(parseFloat(enlace.atenuacionIdeal));
    async function initMap() {
            const { Maps } = await google.maps.importLibrary("maps");
            const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker");
            const centro = {lat: parseFloat(estructura[mitad-1].lat), lng: parseFloat(estructura[mitad-1].lng)};
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 11,
                center: centro,
                mapTypeId: 'satellite',
                mapId: "MAPA",
                disableDefaultUI: true,
                scaleControl: false,
    
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
            

            //CREAR ARREGLO
                
                var puntaA = puntas[0].ubicacion;
                var puntaB = puntas[1].ubicacion;
                //COLOCAR PUNTA A
                    const pin1 = new PinElement({
                        scale: 1,
                    });


                    var ubiA = {lat: parseFloat(puntaA.lat), lng: parseFloat(puntaA.lng)};
                    var ubiB= {lat: parseFloat(puntaB.lat), lng: parseFloat(puntaB.lng)};
                    arregloRuta.push(ubiA);
                    new AdvancedMarkerElement({
                        position: ubiA,
                        map,
                        content: pin1.element,
                        title: "" + puntaA.name,
                    })
                //COLOCAR ESTRUCTURAS
                    estructura.forEach(est => {
                        var posicion = {lat: parseFloat(est.lat), lng: parseFloat(est.lng)}
                        arregloRuta.push(posicion);
                        const pin2 = new PinElement({
                        scale: 0.5,
                        });
                        new AdvancedMarkerElement({
                            position: posicion,
                            map,
                            content: pin2.element,
                            title: "" + est.name,
                        })
                    });

                //COLOCAR PUNTA B
                    const pin3 = new PinElement({
                            scale: 1,
                    });
                    arregloRuta.push(ubiB);
                    new AdvancedMarkerElement({
                                position: ubiB,
                                map,
                                content: pin3.element,
                                title: "" + puntaB.name,
                    })

                console.log(arregloRuta);

            //COMPROBAMOS SI EXISTE ALGUNA FIBRA CON UNA ATENUACION MAYOR A X
                
                var medidaAdecuada = 1;
                var medidaMedia = 0;
                var medidaBaja = 0;

            //COLOREAR LA LINEA DEPENDIENDO DE SU ATENUACION
            
                    //UTILIZANDO MEDIC



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
            
                
            
            //DIBUJAMOS LA RUTA
            
                rutaDibujada = new google.maps.Polyline({
                        path: arregloRuta,
                        geodesic:true,
                        strokeColor: color,
                        storkeOpacity: 1.0,
                        strokeWeight: 5,
                });

            //LO COLOCAMOS EN EL MAPA
                rutaDibujada.setMap(map);
            
    
            
        }


        window.initMap = initMap;
   
</script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>
@endsection