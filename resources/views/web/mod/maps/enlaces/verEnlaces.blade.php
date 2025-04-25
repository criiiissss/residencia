@extends('layouts.app')

@section('contenido')
<div class="divPrincipal">
    <div class="div-margin-top-2">
        <h1>Ver Enlaces</h1>
        <div class="div-margin-bottom-2">
            <label>Selecciona la Gerencia</label>
            <select id="gerencia" onchange="movergerencia(value)" class="select-input-long">
                <option value="all">Todas</option>
                @foreach ($gerencias as $gerencia)
                    @if($gerencia->id == 8)
                        <option value="{{$gerencia->id}}" selected>{{$gerencia->name}}</option>
                    @else
                        <option value="{{$gerencia->id}}">{{$gerencia->name}}</option>
                    @endif

                @endforeach

            </select>
        </div>

        <div class="div-margin-bottom-2">
            <label>Selecciona la zona</label>
            <select id="zona" onchange="modificarTabla()" class="select-input-long">
                <option value="all" selected>Todas</option>
                @foreach ($zonas as $zona)
                    @if($zona->idGerencia  == 8)
                        <option value="{{$zona->id}}">{{$zona->name}}</option>
                    
                    @endif
                @endforeach
            </select>
        </div>


        <div class="tablaContainer">
            <table id="tabla" class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo de Enlace</th>
                        <th>Kilometraje</th>
                        <th>No de <br>Conectores</th>
                        <th>No de <br>Cajas de Empalme</th>
                        <th>Cantidad de <br>Estructuras</th>
                        <th>Atenuacion Ideal del Enlace</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div>
            <a href="{{route('mod-maps')}}"><button class="btn-regresar">Regresar</button></a>
        </div>
    </div>
</div>
    <script type="text/javascript">
        var zone = document.getElementById("zona");
        var geren = document.getElementById("gerencia");
        var table = document.getElementById("tabla");
        var estructuras = @JSON($estructuras);
        var enlaces = @JSON($enlaces);
        var gerencias = @JSON($gerencias);
        var zonas = @JSON($zonas);
        
        
        window.onload = function iniciarTabla(){
            modificarTabla();
            
        }

        function modificarTabla(){
        const enlacesMostrados = new Set();
        console.log(enlaces);
            eliminarTabla();
            enlaces.forEach(enlace => {
                enlace.zona.forEach(zones => {
                    if(zones.id == zone.value && !enlacesMostrados.has(enlace.id)){
                        createFila(enlace.id,enlace);
                        enlacesMostrados.add(enlace.id);
                    }
                    else if(zone.value == "all" && zones.idGerencia == geren.value && !enlacesMostrados.has(enlace.id)){
                        createFila(enlace.id,enlace);
                        enlacesMostrados.add(enlace.id);
                    }
                    else if(geren.value == "all" && zone.value == "all" && !enlacesMostrados.has(enlace.id)){
                    createFila(enlace.id,enlace);
                    enlacesMostrados.add(enlace.id);
                    }
                    
                });
            });

            
        }

        function createFila(id,enlace){
            var enlaceId = id;
            var miAtenuacion = parseFloat(enlace.atenuacionIdeal);
            var miKilometro = parseFloat(enlace.km);
                        table.insertRow(-1).innerHTML = "<td>"+enlace.name+
                                                    "</td><td>"+enlace.tipo+
                                                    "</td><td>"+miKilometro.toFixed(2)+
                                                    " Km</td><td>"+enlace.conectores+
                                                    "</td><td>"+enlace.cajasEmpalme+
                                                    "</td><td>"+estructuras[enlace.id].length+ 
                                                    "</td><td>"+miAtenuacion.toFixed(2)+
                                                    " dB</td><td><a href=\"" + "/modulos/maps/enlace/mostrarResumen/enlace" + enlaceId + "\"><button>Ver Enlace " + enlaceId + "</button></a></td>"
        }

        function eliminarTabla(){
            while(table.rows.length > 1){
                table.deleteRow(-1);
            }
        }

        function eliminarZonas(){
            zone.options.length = 0;
        }

        function movergerencia(valor){
            eliminarZonas();
            var op = document.createElement("option");
            op.text = 'Todas';
            op.value = 'all';
            zone.add(op);
            console.log(valor)
            zonas.forEach(zona => {
                if(valor == zona.idGerencia){
                    var option = document.createElement("option");
                    option.text = zona.name;
                    option.value = zona.id;
                    zone.add(option);
                    console.log(option)
                }
            });
            modificarTabla();
        }

    </script>
@endsection