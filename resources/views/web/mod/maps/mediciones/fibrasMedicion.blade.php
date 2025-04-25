@extends('layouts.app')

@section('contenido')
<div class="divPrincipal">
    <div>
        <h2>Mediciones por Fibra</h2>
        <hr>
        <div class="tablaContainer2">
            <table id="tabla" class="tabla">
                <thead>
                <tr>
                    <td class="th-fibra">Número de Fibra</td>
                    <td>Estado</td>
                    <td class="th-medicion">Medición</td>
                    <td>Servicio o comentario</td>
                    <td>Archivo SOR</td>
                </tr>
                </thead>
                <tbody>
                @for ($i = 1; $i <= $lineas->noFibras; $i++)
                    <tr>
                        <td><input type="number" value="{{$i}}" readonly id="numero{{$i}}" name="numero" class="numero"></td>
                        <td>
                            <select name="estado" onchange="cambiarEstado(this,{{$i}})" id="estado{{$i}}" class="estado">
                                <option value="Disponible">Disponible</option>
                                <option value="Ocupado">Ocupado</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="medicion" class="medicion">
                        </td>
                        <td>
                            <input type="text" name="comentario" class="comentario">
                        </td>
                        <td>
                            <input type="file" name="xor" class="xor">
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
        <form action="{{route('detalle-crear')}}" method="POST" id="formMediciones" enctype="multipart/form-data">
            @csrf
            <input type="text" readonly name="idMedicion" value="{{$estaMedicion->id}}" hidden>
            <input type="text" readonly name="mediciones" id="mediciones" hidden> 
        </form>
        <div>
            <br><br>
            <form action="{{route('medicion-cancelar',$estaMedicion->id)}}" method="POST" name="eliminar">
                @csrf
                @method('DELETE')
            </form>
            <button class="btn-regresar" onclick="ConfirmarEliminacion('{{$estaMedicion->id}}')">Cancelar</button>   
            <button onclick="guardarValores()" class="btn-aceptar">Guardar</button>
        </div>
    </div>
</div>    


<script type="text/javascript">
    var medicionesAntiguas = @JSON($detallesPasado);
    var lineas = @JSON($lineas);
    var etiquetaMediciones = document.getElementById("mediciones");
    var Table = document.getElementById("tabla");
    var misMediciones = document.getElementById("formMediciones");

        function ConfirmarEliminacion(MedicionID){
            if(confirm('Estas seguro de eliminar esta medicion')){
                document.eliminar.submit();
                return true;
            }
            else{
                return false;
            }
        }

        function cambiarEstado(valor,numero){
            var fila = valor.parentNode.parentNode;
            
            if(fila.cells[1].children[0].value == "Disponible"){
                

                fila.cells[2].innerHTML = '<input type="number" value="" name="medicion" class="medicion">';
                fila.cells[4].innerHTML = '<input type="file" name="xor" class="xor">';
            }
            else{
                
                if(medicionesAntiguas[numero-1]=== undefined){
                    fila.cells[2].innerHTML = '<input type="text" name="medicion" value="SIN MEDIDAS ANTERIORES" class="medicion" readonly>';
                    fila.cells[3].innerHTML = '<input type="text" name="comentario" class="comentario" required>'
                    fila.cells[4].innerHTML =`
                                                <input type="file"
                                                        value="0"
                                                        readonly
                                                        name="xor"
                                                        class="xor"
                                                        hidden>
                    
                                                `;
                }
                else{
                    fila.cells[2].innerHTML = `
                                                <input type="text" 
                                                        name="medicion" 
                                                        value="${medicionesAntiguas[numero-1].medicion}" 
                                                        class="medicion" 
                                                        readonly>
                                                `;
                    fila.cells[3].innerHTML = '<input type="text" name="comentario" class="comentario">'
                    fila.cells[4].innerHTML =`
                                                <input type="file"
                                                        value="0"
                                                        readonly
                                                        name="xor"
                                                        class="xor"
                                                        hidden>
                    
                                                `;
                }
            }
        }

        function guardarValores(){
            let Estructura = [];
            var Vacio = false;
            var i=1;
            document.querySelectorAll('.tabla tbody tr').forEach(function(e){
            i=i+1;
            let fila = {
                noFibra: e.querySelector('.numero').value,
                estado: e.querySelector('.estado').value,
                medicion: e.querySelector('.medicion').value,
                comentario: e.querySelector('.comentario').value,
                xor: e.querySelector('.xor').files[0],
            };
                if(fila.medicion == ''){
                    Vacio = true;
                    alert('MEDICION VACIA EN LA FIBRA. '+ fila.noFibra);
                }


                Estructura.push(fila);
                
            
            });

            if(Vacio == false){
                etiquetaMediciones.value = JSON.stringify(Estructura);
                // Crea un nuevo input de tipo file y agrega el archivo seleccionado
                var archivos = document.querySelectorAll('.xor');
                for (var i = 0; i < archivos.length; i++) {
                var archivo = archivos[i].files[0];
                var input = document.createElement('input');
                input.type = 'file';
                input.name = 'xor_' + (i + 1);
                misMediciones.appendChild(input);
                // Agrega el archivo seleccionado al nuevo input
                var fileInput = misMediciones.querySelector('input[type="file"][name="xor_' + (i + 1) + '"]');
                fileInput.files = archivos[i].files;
                }
                misMediciones.submit();
            }
            
        }


    </script>
@endsection