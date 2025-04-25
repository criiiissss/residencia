@extends('layouts.app')

@section('contenido')
<div class="divPrincipal">
    <div>
        <div>
        <h1>Ubicaciones</h1>
        <label>Selecciona la Gerencia: </label>
        <br>
        <select id="gerencia" onchange="modificarZonas(value)" class="select-input-long">
            <option selected value="all">Todas</option>
            @foreach ($gerencias as $gerencia)
                <option value="{{$gerencia->id}}">{{$gerencia->name}}</option>
            @endforeach
        </select>
        <br>
        <br>
        <label>Selecciona la Zona:</label>
        <br>
        <select id="zona" onchange="modificarTabla(value)" class="select-input-long">
            <option selected value="all">Todas</option>
        </select>
        <br><br>
        <table id="table" class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Abreviacion</th>
                    <th>Latitud</th>
                    <th>Longitud</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
        <br><br>
        <input type="text" id="rol" value="{{auth()->user()->rol}}" hidden>
        <a href="{{route('mod-maps')}}"><button class="btn-regresar">Regresar</button></a>
        <a href="{{route('ubicaciones-ver-crear')}}"><button class="btn-aceptar">Agregar Ubicación</button></a>
        
        
        </div>
    </div>
</div>
    <script type="text/javascript">
        var gerenciaSelect = document.getElementById("gerencia");
        var zonaSelect = document.getElementById("zona");
        var table = document.getElementById("table");
        var rol = document.getElementById("rol");
        var gerencias = @JSON($gerencias);
        var zonas = @JSON($zonas);
        var ubicaciones = @JSON($ubicaciones);
        var ubicacionesZonas = @JSON($ubicacionesZonas);
        var enlaceUbicaciones = @JSON($enlaceUbicacion);

        window.onload = function iniciarTabla(){
            modificarTabla("all");
        }

        function eliminarZonas(){
            zonaSelect.options.length = 0;
        }

        function eliminarTabla(){
            while(table.rows.length > 1){
                table.deleteRow(-1);
            }
        }

        function modificarZonas(idGerencia){
            eliminarZonas();
            var Op = document.createElement("OPTION");
            Op.text = "Todas";
            Op.value = "all";
            zonaSelect.add(Op);
            zonas.forEach(zona => {
                if(zona.idGerencia == idGerencia){
                    var Option = document.createElement("OPTION");
                    Option.text = zona.name;
                    Option.value = zona.id;
                    zonaSelect.add(Option);
                }
            });
            modificarTabla(zonaSelect.value);
        }

        function modificarTabla(idZona) {
            eliminarTabla();
            const ubicacionesUnicas = new Set();
            
            ubicacionesZonas.forEach(ubi => {
                const csrfToken = '{{ $csrfToken }}';
                if ((idZona == ubi.idZona) || (idZona == "all" && gerenciaSelect.value == "all") || (idZona == "all" && ubi.zona.idGerencia == gerenciaSelect.value)) {
                const ubicacionKey = `${ubi.name}-${ubi.abreviacion}`;
                if (!ubicacionesUnicas.has(ubicacionKey)) {
                    ubicacionesUnicas.add(ubicacionKey);
                    var id = ubi.id;
                    console.log(id);
                    table.insertRow(-1).innerHTML = `
                    <td>${ubi.name}</td>
                    <td>${ubi.abreviacion}</td>
                    <td>${ubi.lat}</td>
                    <td>${ubi.lng}</td>
                    <td><a href="/modulos/maps/ubicaciones/ver/detalle${id}"><button>Ver Detalles</button></a>
                        @if(auth()->user()->rol == "level2" || auth()->user()->rol == "level3")
                            <a href="/modulos/maps/ubicaciones/modificar${id}"><button>Modificar</button></a>
                            <form action="/modulos/maps/ubicaciones/eliminar${id}" method="POST" id="formulario${id}">
                                @method('DELETE')
                                <input type="hidden" name="_token" value="${csrfToken}">
                                </form>
                                <button type="submit" onclick="eliminarUbicacion(${id})">
                                    Eliminar
                                </button>
                        @endif
                            </td>
                    `;
                }
                }
            });
        }

        function eliminarUbicacion(idUbicacion){
            var UbicacionOcupada = 0;
            let nombreUbicacion;
            ubicaciones.forEach(ubi => {
                if(idUbicacion == ubi.id){
                    nombreUbicacion = ubi.name;
                    enlaceUbicaciones.forEach(enla => {
                        if(enla.ubicacion_id == ubi.id){
                            UbicacionOcupada = 1
                        }
                    });

                }
            });

            if(UbicacionOcupada == 0){
                window.confirm('Estas seguro de eliminar la ubicacion ' + nombreUbicacion);
                var formulario = document.getElementById("formulario"+idUbicacion);
                formulario.submit();
            }
            else{
                window.alert("La ubicacion esta siendo usada por un enlace")
            }
        }



    </script>
@endsection