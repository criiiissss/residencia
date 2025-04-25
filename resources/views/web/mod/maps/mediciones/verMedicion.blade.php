@extends('layouts.app')
@section('contenido')
<div class="divPrincipal">
    <div>
        <h1><span class="font"> MEDICIONES</span> </h1>
        <div>
            <label><span class="font">Selecciona la Gerencia</span></label>
            <select id="gerencia" onchange="modificarZonas(value)">
                <option value="all">Todas</option>
                @foreach ($Gerencias as $gerencia)
                    @if($gerencia->id == 8)
                        <option value="{{$gerencia->id}}" selected>{{$gerencia->name}}</option>
                    @else
                        <option value="{{$gerencia->id}}">{{$gerencia->name}}</option>
                    @endif

                @endforeach
            </select>
            <br>
            <br>

            <label><span class="font">Selecciona la zona</span></label>
            <select id="zona" onchange="modificarEnlaces(value)">
                <option value="all" selected>Todas</option>
                @foreach ($Zonas as $zona)
                    @if($zona->idGerencia  == 8)
                        <option value="{{$zona->id}}">{{$zona->name}}</option>
                    @endif
                @endforeach
            </select>

            <br>
            <br>
            <label><span class="font">Selecciona el enlace</span></label>
            <select id="enlaces" onchange="modificarTabla(value)">
                <option value="all">Todas</option>
            </select>

            <br>
            <br>
        </div>
        <table id="tabla" class="table">
            <thead>
                <tr>
                    <th><span class="font">ID</span></th>
                    <th><span class="font">Punta A</span></th>
                    <th><span class="font">Punta B</span></th>
                    <th><span class="font">Linea</span></th>
                    <th><span class="font">Fecha</span></th>
                    <th><span class="font">Acciones</span></th>
                </tr>
            </thead>
        </table>
        <br><br><br>
        <a href="{{route('mod-maps')}}"><button class="btn-regresar" >Regresar</button></a>
    </div>
</div>

<script type="text/javascript">
        var zone = document.getElementById("zona");
        var geren = document.getElementById("gerencia");
        var enla = document.getElementById("enlaces");
        var table = document.getElementById("tabla");
        var all = "all";
        var enlaces = @JSON($Enlaces);
        var mediciones = @JSON($Mediciones);
        var gerencias = @JSON($Gerencias);
        var zonas = @JSON($Zonas);
        

        window.onload = function iniciarTabla(){
            modificarEnlaces(all);
            
        }

        function eliminarTabla(){
            while(table.rows.length > 1){
                table.deleteRow(-1);
            }
        }

        function eliminarZonas(){
            zone.options.length = 0;
        }

        function eliminarEnlaces(){
            enla.options.length = 0;
        }

        function modificarZonas(valor){
            eliminarZonas();
            eliminarEnlaces();
            var tod = document.createElement("OPTION");
            tod.text ="Todas";
            tod.value = "all";
            enla.add(tod);
            var op = document.createElement("OPTION");
            op.text = "Todas";
            op.value = "all";
            zone.add(op);
            console.log(valor);
            zonas.forEach(zona => {
                if(zona.idGerencia == valor || valor == "all"){
                    var opcion = document.createElement("OPTION");
                    opcion.text = zona.name;
                    opcion.value = zona.id;
                    zone.add(opcion);
                }
            });
            modificarTabla(enla.value);
        }

        function modificarEnlaces(valor){
            eliminarEnlaces();
            var Op = document.createElement("OPTION");
            Op.text = "Todas";
            Op.value = "all";
            enla.add(Op);
            const enlacesMostrados = new Set();
            enlaces.forEach(enlace => {

                enlace.zona.forEach(zones => {
                    if((zones.id == valor && !enlacesMostrados.has(enlace.id))|| (valor == "all" && zones.idGerencia == geren.value && !enlacesMostrados.has(enlace.id))){
                        var op = document.createElement("OPTION");
                        op.text = enlace.name;
                        op.value = enlace.id;
                        enlacesMostrados.add(enlace.id);
                        enla.add(op);
                    }
                });
                
            });
            
            modificarTabla(enla.value);
        }

        function modificarTabla(valor){
            eliminarTabla();
            const MedicionesMostradas = new Set();
             mediciones.forEach(medicion => {
                console.log(medicion.lineas.zona);
                medicion.lineas.zona.forEach(zonitas => {
                    if((medicion.idLinea == valor && !MedicionesMostradas.has(medicion.id)) || (valor == "all" && zone.value =="all" && geren.value == "all" && !MedicionesMostradas.has(medicion.id)) || (geren.value == zonitas.idGerencia && zone.value == "all" && enla.value == "all" && !MedicionesMostradas.has(medicion.id)) || (geren.value == zonitas.idGerencia && zone.value == zonitas.id && enla.value == "all")){
                    var medicionId= medicion.id;
                    table.insertRow(-1).innerHTML = "<td>"+medicion.id+
                                                    "</td><td>"+medicion.obtener_punta_a.name+
                                                    "</td><td>"+medicion.obtener_punta_b.name+
                                                    "</td><td>"+medicion.lineas.name+
                                                    "</td><td>"+medicion.fecha+
                                                    "</td><td><a href=\"" + "/modulos/maps/mediciones/ver/medicion" + medicionId + "\"><button>Ver Medicion " + medicionId + "</button></a></td>"
                                                    
                    }
                    MedicionesMostradas.add(medicion.id);

                });                
            });
        }


    </script>
@endsection