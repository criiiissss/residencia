@extends('layouts.app')
@section('contenido')
<div class="divPrincipal">
    <div>
        <h1>Mediciones del Enlace {{$MedicionFibras[0]->medicions->lineas->name}}</h1>
        <h2>No de Medicion {{$MedicionFibras[0]->medicions->id}}</h2>
        <h2>Fecha de Medicion {{$MedicionFibras[0]->medicions->fecha}}</h2>

        <table id="table" class="table">
            <thead>
                <tr>
                    <td></td>
                    <td>No</td>
                    <td>Estado</td>
                    <td>Medicion</td>
                    <td>Comentario</td>
                    <td>Archivo XOR</td>
                </tr>
            </thead>
            <tbody>
                @foreach($MedicionFibras as $fibra)
                    <tr>
                        <td colspan="-1"><input type="id" value="{{$fibra->id}}" class="id" hidden></td>
                        <td><input type="number" value="{{$fibra->noFibra}}" class="no" readonly></td>
                        <td>
                            <select id="estado{{$fibra->noFibra}}" onchange="mostrarAnterior(value,{{$fibra->noFibra}},this)" class="estado">
                                @if($fibra->estado == "Disponible")
                                    <option value="Disponible" selected>Disponible</option>
                                    <option value="Ocupado">Ocupado</option>
                                @else
                                    <option value="Disponible">Disponible</option>
                                    <option value="Ocupado" selected>Ocupado</option>
                                @endif
                            </select>
                        </td>
                        <td><input type="number" value="{{$fibra->medicion}}" id="fibraMedicion{{$fibra->noFibra}}" class="medicion"></td>
                        <td><input type="text" value="{{$fibra->comentario}}" id="fibraComentario{{$fibra->noFibra}}" class="comentarios"></td>
                        <td><input type="file" class="xor" name="xor" id="xor{{$fibra->noFibra}}"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <form id="form" method="POST" action="{{route('detalle-reescribir')}}">
            @csrf
            @method('PUT')
            <input readonly id="estructuras" name="estructuras" hidden>
        </form>
        <button onclick="guardarAyudas()" class="btn-aceptar">Modificar</button><br>
        <a href="{{route('mediciones-detalles',$MedicionFibras[0]->medicions->id)}}"><button class="btn-regresar">Cancelar</button></a>
    </div>
</div>


<script type="text/javascript">
    var form = document.getElementById("form");
    var FibrasAnteriores = @JSON($fibrasAnteriores);
    var MedicionFibras = @JSON($MedicionFibras);
    var myTable = document.querySelector("table"); 
    console.log(FibrasAnteriores);

    window.onload = function iniciarTabla() {
        var rows = myTable.rows;
        for (var i = 1; i < rows.length; i++) {
            var cells = rows[i].cells;
            var estado = document.getElementById("estado"+i)
            var medicion = document.getElementById("fibraMedicion"+i)
            cambiarXor(estado,i);
            if (estado.value === "Ocupado") {
                console.log("OCUPADO")
                medicion.readOnly = true;

            }
        }
    }

    function cambiarXor(valor,noFibra){
        console.log(valor.parentNode.parentNode);
        console.log(valor.value);
        var fila = valor.parentNode.parentNode;
        var xorInput = document.getElementById("xor"+noFibra);
        if (valor.value == "Ocupado"){
            xorInput.hidden = true;
        }
        else{
            xorInput.hidden = false;
        }
        
    }

    function mostrarAnterior(valor, fibraId,xor){
        cambiarXor(xor,fibraId);
        if(valor != "Disponible"){
            var com = document.getElementById("fibraMedicion"+fibraId);
            if(FibrasAnteriores == null){
                com.type = "text";
                com.value = "NO TIENE MEDICION PASADA";
                com.readOnly = true;
            }else{
                com.value = (FibrasAnteriores[fibraId-1].medicion);
                com.readOnly = true;
            }
        }else{
            var com2 = document.getElementById("fibraMedicion"+fibraId);
            com2.type = "number";
            com2.value = (MedicionFibras[fibraId-1].medicion);
            com2.readOnly = false;

        }

        

    }

    function guardarAyudas(){
            let Estruct = [];
            var Vacio = false;
            document.querySelectorAll('.table tbody tr').forEach(function(e){
            let fila = {
                id: e.querySelector('.id').value,
                no: e.querySelector('.no').value,
                estado: e.querySelector('.estado').value,
                medicion: e.querySelector('.medicion').value,
                comentarios: e.querySelector('.comentarios').value,
            };
            if(fila.medicion == ""){
                alert('ESPACIO SIN RELLENAR EN LA FILA NO. '+ (e.rowIndex-1));
                Vacio = true;
            }
            else{
                Estruct.push(fila);
                
            }
            });

            if(Vacio == false)
            {
                    //PASAR ESTRUCT A UN INPUT
                    var Etiqueta = document.getElementById("estructuras");
                    var Estruct2 = Object.values(Estruct)
                    console.log(Estruct2);
                    Etiqueta.value = JSON.stringify(Estruct);
                    form.submit();
                    

                    
                    
            }

            
        }

</script>

@endsection