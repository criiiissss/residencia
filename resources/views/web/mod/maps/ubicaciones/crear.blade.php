@extends('layouts.app')
@section('contenido')
<div class="divPrincipal">
    <div>
        <h1>Agregar Ubicación</h1>
        <div>
            <label>Seleccionar Gerencia: </label>
            <select id="gerencias" onchange="cambiarZonas(value)">
                @foreach ($Gerencias as $gerencia)
                    @if($gerencia->id == 8)
                        <option selected value="{{$gerencia->id}}">{{$gerencia->name}}</option>
                    @else
                        <option value="{{$gerencia->id}}">{{$gerencia->name}}</option>
                    @endif
                @endforeach
            </select>
            
            <br>
            <br>
            <form action="{{route('ubicaciones-crear')}}" method="POST" id="UbiForm">
                @csrf
                <label>Zonas:</label>
                <select id="zonaSelect" name="zona">
                    <option value="none" selected>Seleccione una Zona</option>
                </select>
        </div>
            <br>
        <div>
            <label>Nombre</label><br>
            <input type="text" name="name" required class="input-full-screen">
            <br>
            <label>Abreviacion</label><br>
            <input type="text" name="abrv" required class="input-full-screen">
            <br>
            <label>Latitud</label><br>
            <input type="number" name="lat" required class="input-full-screen">
            <br>
            <label>Longitud</label><br>
            <input type="number" name="lng" required class="input-full-screen">
            <br>
            <label>Direccion</label>
            <input type="text" name="direccion" required class="input-full-screen">
            <br>
            <input type="text" name="arreglo" id="inputArreglo" hidden class="input-full-screen">
            <br>
        </form>
        </div>
        <br>
        <br>
        <a href="{{route('ubicaciones-ver')}}"><button class="btn-regresar">Cancelar</button></a>
        <button onclick="insertarArreglo()" class="btn-aceptar">Guardar</button>
        
    </div>
</div>

<script type="text/javascript"> 
    var selectGerencias = document.getElementById("gerencias");
    var arreglo = document.getElementById("inputArreglo");
    var formZonas = document.getElementById("UbiForm");
    var zonaSelect = document.getElementById("zonaSelect");
    var zonas = @JSON($Zonas);


    window.onload = function iniciarTabla(){
            cambiarZonas(selectGerencias.value);
        }

    function eliminarZonas(){
        zonaSelect.options.length = 0;
    }

    function cambiarZonas(idGerencia){
        eliminarZonas();
        var opcionDefault = document.createElement("OPTION");
        opcionDefault.text = "Seleccione una zona";
        opcionDefault.value = "none";
        zonaSelect.add(opcionDefault);
        zonas.forEach(zona => {
            if(zona.idGerencia == idGerencia){
                var opcion = document.createElement("OPTION");
                opcion.text = zona.name;
                opcion.value = zona.id;
                zonaSelect.add(opcion);
            }
        });
    }

    function insertarArreglo(){
        
        UbiForm.submit();
    }





</script>
@endsection