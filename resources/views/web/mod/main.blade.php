@extends('layouts.app')

@section('contenido')
    <div class="principal-fullscreen">
        <div class="div-principal-fullscreen">
            <div>
                <h1 id="fadein">Bienvenido a la plataforma</h1>
            </div>
            <div id="map3">  
            
            
        </div>
    </div>
    


<script type="text/javascript">
    var enlaces = @json($enlace);
    var ubicaciones = @json($ubicacion);
    var ubicacionesA = @json($ubicacionSoloA);

    console.log(ubicacionesA);

    console.log(ubicaciones);
    window.onload = function iniciarTabla(){
            @if($errors->any())
                window.alert('{{ $errors->first() }}');
            @endif
        }
        window.setTimeout(function(){
            location.reload();
        },1000000);

    
    //SCRIPT PARA HACER EL MAPA PRINCIPAL
    async function initMap() {
        const { Maps } = await google.maps.importLibrary("maps");
        const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker");
        const centro = {lat:17.163562646405808, lng:-94.92223315372371};

        map = new google.maps.Map(document.getElementById("map3"),{
            zoom: 7,
            center: centro,
            mapTypeId: 'satellite',
            mapId: "MAPA",
            disableDefaultUI: true,
            scaleControl: false,

            mapTypeControl:true,
            mapTypeControlOptions:{
                position: google.maps.ControlPosition.UP_LEFT,
            },

            fullscreenControl:true,

            fullscreenControlOptions:{
                position: google.maps.ControlPosition.BOTTOM_LEFT,
            },

            zoomControl:true,
        });


        enlaces.forEach(enlace => {
            let ruta = [];
            var UbicacionA = {lat: parseFloat(enlace.ubicaciones[0].lat) ,lng: parseFloat(enlace.ubicaciones[0].lng)};
            var UbicacionB = {lat: parseFloat(enlace.ubicaciones[1].lat) ,lng: parseFloat(enlace.ubicaciones[1].lng)};

            const pin1 = new PinElement({
                        scale: 1,
                    });
            new AdvancedMarkerElement({
                        position: UbicacionA,
                        map,
                        content: pin1.element,
                        title: "" + enlace.ubicaciones[0].name,
                    })

            ruta.push(UbicacionA);

            enlace.enlaces.forEach(estructura => {
                var Estructura = {lat: parseFloat(estructura.lat), lng: parseFloat(estructura.lng)};
                ruta.push(Estructura);

                const pin3 = new PinElement({
                        scale: 0.4,
                    });
                new AdvancedMarkerElement({
                        position: Estructura,
                        map,
                        content: pin3.element,
                        title: "" + estructura.name,
                    });


            });
            
            ruta.push(UbicacionB);
            const pin2 = new PinElement({
                        scale: 1,
                    });
            new AdvancedMarkerElement({
                        position: UbicacionB,
                        map,
                        content: pin2.element,
                        title: "" + enlace.ubicaciones[1].name,
                    })
            

            rutaDibujada = new google.maps.Polyline({
                        path: ruta,
                        geodesic:true,
                        strokeColor:'#f1e109',
                        storkeOpacity: 1.0,
                        strokeWeight: 5,
                });

            //LO COLOCAMOS EN EL MAPA
                rutaDibujada.setMap(map);
                console.log(enlace.medic.atenuacionReal);
        });


    }

    window.initMap = initMap;
</script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>
@endsection

