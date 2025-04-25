@extends('layouts.app')
@section('contenido')
<div class="divPrincipal">
    <div class="divExtendido">
        <h1 style="text-align: center">Ubicación No.{{$Ubicacion->id}}</h1>
        <div>
            <div>

                    <h2>Nombre: {{$Ubicacion->name}}</h2>

                    <h2>Perteneciente a la Gerencia</h2>

                        @foreach($G as $g)
                            {{$g}}
                        @endforeach
                    <h2>Zona a la que pertenece</h2>

                    {{$Ubicacion->zona->name}}

                    <h2>Enlaces en los que Participa: </h2>
                <div class="div-aling-center">
                    <table>
                        @foreach($Enlaces as $enlace)
                            <tr>
                                <td><h3>{{$enlace->enlace->name}} </h3></td>
                                <td><a href="{{route('estructura-enlace-resumen',$enlace->enlace->id)}}"><button>Ir a enlace</button></a></td>
                            <tr>
                        @endforeach
                    </table>
                </div>
            
                    <h2>Coordenadas</h2>
                    <h3>Latitud {{$Ubicacion->lat}}</h3>
                    <h3>Longitud {{$Ubicacion->lng}}</h3>

            </div>
            <div>
                <div>
                    <h2 style="text-align: center">Imagen</h2>
                </div>
                <div> 
                    <div id="map2"></div>
                </div>
                <h2>Direccion</h2>
                    <h3>{{$Ubicacion->direccion}}</h3>
            </div>
        </div>
        <br><br>
        <a href="{{route('ubicaciones-ver')}}"><button class="btn-regresar">Regresar</button></a>
    </div>  
</div>
<script type="text/javascript">
    var ubi = @JSON($Ubicacion);
    const ubicacion = {lat: parseFloat(ubi.lat), lng: parseFloat(ubi.lng)};

    async function initMap() {
        const { Maps } = await google.maps.importLibrary("maps");
        const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker");

        map = new google.maps.Map(document.getElementById("map2"), {
                zoom: 17,
                center: ubicacion,
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

        const pin = new PinElement({scale: 1,});
                new AdvancedMarkerElement({
                    position: ubicacion,
                    map,
                    content: pin.element,
                    title: "" + ubi.name,
                })
        window.initMap = initMap;
    }
</script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>
@endsection