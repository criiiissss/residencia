@extends('layouts.app')
@section('contenido')
<div class="divPrincipal">
    <div class="divExtendido">
        <h1><span class="font">Medicion de la linea : {{$MedicionModificar[0]->lineas->name}}</span></h1>
        <div>
            <div>
                <h1><span class="font">Medicion con el id: {{$MedicionModificar[0]->id}}</span></h1>
                <form action="{{route('mediciones-modificar',$MedicionModificar[0]->id)}}" method="POST" id="modificarForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <h1><span class="font">Medicion desde la Punta A</span></h1>
                    <select id="puntaA" onchange="cambiarPuntaB()" name="puntaA">
                        @if($existePuntaA == 1)
                            @foreach($ubicacionMediciones as $ubi)
                                @if($ubi->ubicacion_id == $MedicionModificar[0]->idPuntaA)
                                    <option selected value="{{$ubi->ubicacion_id}}">{{$ubi->ubicacion->name}}</option>
                                @else
                                    <option value="{{$ubi->ubicacion_id}}">{{$ubi->ubicacion->name}}</option>
                                @endif
                            @endforeach
                        @else
                            <option selected value="{{$MedicionModificar[0]->idPuntaA}}">{{$MedicionModificar[0]->obtenerPuntaA->name}}</option>
                            @foreach($ubicacionMediciones as $ubi)
                                <option value="{{$ubi->ubicacion_id}}">{{$ubi->ubicacion->name}}</option>
                            @endforeach
                        @endif
                    </select>
                    <h1><span class="font">Medicion desde la Punta B</span></h1>
                    <select id="puntaB" name="puntaB">
                        @if($existePuntaB == 1)
                            @foreach($ubicacionMediciones as $ubi)
                                @if($ubi->ubicacion_id == $MedicionModificar[0]->idPuntaB)
                                    <option selected value="{{$ubi->ubicacion_id}}">{{$ubi->ubicacion->name}}</option>
                                @else
                                    <option value="{{$ubi->ubicacion_id}}">{{$ubi->ubicacion->name}}</option>
                                @endif
                            @endforeach
                        @else
                            <option selected value="{{$MedicionModificar[0]->idPuntaB}}">{{$MedicionModificar[0]->obtenerPuntaB->name}}</option>
                            @foreach($ubicacionMediciones as $ubi)
                                <option value="{{$ubi->ubicacion_id}}">{{$ubi->ubicacion->name}}</option>
                            @endforeach
                        @endif
                    </select>
            </div>
            <div>
                    <h1><span class="font">Realizado en la fecha</span></h1>
                    <input type="date" value="{{$MedicionModificar[0]->fecha}}" name="fecha">
                    <h1><span class="font">Archivo en PDF</span></h1>
                    <input type="file"  name="pdf">
                    <h1><span class="font">Archivo en XLS</span></h1>
                    <input type="file"  name="xls">
                </form>
            </div>
        </div>
        <br>
        <br>
        <br>
        <button onclick="enviarFormulario()" class="btn-aceptar">Modificar</button>
        <a href="{{route('medicion-ver')}}"><button class="btn-regresar">Cancelar</button></a>
    </div>
</div>


<script type="text/javascript">
        var medicionModificar = @JSON($MedicionModificar);
        var ubicacion = @JSON($ubicacionMediciones);
        var puntaA = document.getElementById("puntaA");
        var puntaB = document.getElementById("puntaB");
        var formMedicion = document.getElementById("modificarForm");


        window.onload = function iniciarTabla(){
            cambiarPuntaB();
        }

        function cambiarPuntaB(){
            var valorA = puntaA.value;
            ubicacion.forEach(ubi => {
                console.log(ubi.ubicacion.id)
                if(ubi.ubicacion.id == valorA){
                    let option = puntaB.querySelector(`option[value="${ubi.ubicacion.id}"]`);
                    option.disabled = true;
                }
                else{
                    let option2 = puntaB.querySelector(`option[value="${ubi.ubicacion.id}"]`);
                    if(option2 != null){
                        option2.disabled = false;
                        if (valorA == puntaB.value){
                            option2.selected = true;
                        }
                    }
                }
            });
        }



        function enviarFormulario(){
            formMedicion.submit();
        }
    </script>

@endsection