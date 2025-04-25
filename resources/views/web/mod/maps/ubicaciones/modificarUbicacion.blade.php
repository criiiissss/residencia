@extends('layouts.app')
@section('contenido')
<div class="divPrincipal">
    <div>
        <div>
        <h1>{{$estaUbicacion[0]->name}}</h1>
        <br><br>
        <label>Gerencia: </label>
        <select id="selectGerencia" onchange="cambiarZona(value)">
            @foreach ($gerencias as $gerencia)
                @if ($gerencia->id == $estaUbicacion[0]->zona->idGerencia)
                    <option selected value="{{$gerencia->id}}">{{$gerencia->name}}</option>
                @else
                    <option value="{{$gerencia->id}}">{{$gerencia->name}}</option>
                @endif
            @endforeach
        </select>
        <br><br>
        <label>Zona: </label>
        <select id="selectZonas">
            @foreach ($zonas as $zona)
                @if ($zona->id == $estaUbicacion[0]->idZona)
                    <option selected value="{{$zona->id}}">{{$zona->name}}</option>
                @else
                    <option value="{{$zona->id}}">{{$zona->name}}</option>
                @endif
            @endforeach
        </select>
        </div>
        <br><br>
        <form id="formulario" method="POST" action="{{route('ubicacion-modificar',$estaUbicacion[0]->id)}}">
            @csrf
            @method('PUT')
            <input type="number" required hidden name="idZona" id="inputZona">
            <label>Nombre: </label><br>
            <input type="text" required value="{{$estaUbicacion[0]->name}}" name="name" class="input-full-screen">
            <br><br>
            <label>Abreviacion: </label>
            <input type="text" required value="{{$estaUbicacion[0]->abreviacion}}" name="abreviacion" class="input-full-screen">
            <br><br>
            <label>Latitud: </label>
            <input type="number" required value="{{$estaUbicacion[0]->lat}}" name="lat" class="input-full-screen">
            <br><br>
            <label>Longitud: </label>
            <input type="number" required value="{{$estaUbicacion[0]->lng}}" name="lng" class="input-full-screen">
            <br><br>
            <label>Direccion: </label>
            <input type="text" required value="{{$estaUbicacion[0]->direccion}}" name="direccion" class="input-full-screen">
        </form>
            <br><br>
            <button onclick="enviarFormulario()" class="btn-aceptar">Modificar</button><br>
            <a href="{{route('ubicaciones-ver')}}"><button class="btn-regresar">Cancelar</button></a>
    </div>
</div>
<script type="text/javascript">
        var SelectGerencias = document.getElementById("selectGerencia");
        var SelectZonas = document.getElementById("selectZonas");
        var formulario = document.getElementById("formulario");
        var inputZona = document.getElementById("inputZona");
        var Gerencias = @JSON($gerencias);
        var Zonas = @JSON($zonas);
        var ubicacionesEnlaces = @JSON($enlaceUbicacion);

        function cambiarZona(idGerencia){
            borrarZonas();
            Zonas.forEach(zona => {
                if(zona.idGerencia == SelectGerencias.value){
                    var Option = document.createElement("OPTION");
                        Option.text = zona.name;
                        Option.value = zona.id;
                        SelectZonas.add(Option);
                        
                }
            }); 
        }

        function borrarZonas(){
            SelectZonas.options.length=0;
        }

        function enviarFormulario(){
            if(ubicacionesEnlaces == ""){
                inputZona.value = SelectZonas.value;
                formulario.submit();
            }else{
                window.alert('No se puede modificar esta ubicacion debido a que se encuentra en uso por parte de otro enlace');
            }
        }
    </script>
@endsection