@extends('layouts.app')

@section('contenido')
    <div class="divPrincipal">
        <div class="div-margin-top-2">
            <h1><span class="font">Enlace {{$enlace->name}}</h1>
            <div class="tablaContainer">
                <table class="table" id="table">
                    <thead>
                    <tr>
                        <th scope="col"><span class="font">No</span></th>
                        <th scope="col"><span class="font">No. Estructura</span></th>
                        <th scope="col"><span class="font">Latitud</span></th>
                        <th scope="col"><span class="font">Longitud</span></th>
                        <th scope="col"><span class="font">¿Cuenta con de Empalme?</span></th>
                        <th scope="col"><span class="font">Distancia Respecto al anterior (KM)</span></th>
                        <th>⬇️</th>
                    </tr>
                    <tr>
                        <td><label>0</label></td>
                        @if ($pass == 1)
                            <td>{{$estructur->name}}</td>
                            <td>{{$estructur->lat}}</td>
                            <td>{{$estructur->lng}}</td>
                            <td>{{$estructur->cajaEmpalme}}</td>
                            <td>{{$estructur->km}}</td>
                            <td></td>
                        @else
                            <td colspan="7" class="td-bahia">BAHIA</td>
                        @endif
                    </tr>    
                    </thead>
                    <tbody>
                    <tr>
                        <td><label>1</label></td>
                        <td><input type="text" value="" class="name" id="name" placeholder="número">   </td>
                        <td><input type="number" value="" class="Lat" id="lat" placeholder="grados en decimales">  </td>
                        <td><input type="number" value="" class="Lng" id="lng" placeholder="grados en decimales">  </td>
                        <td>
                            <select id="tipo" name="cajaEmpalme" class="tipo   ">
                                <option value="No">No</option>
                                <option value="Si">Si</option>
                            </select>
                        <td><input type="number" class="Distancia" id="distancia">  </td>
                        <td><button onclick="limpiarRow(this)">Borrar datos</button></td>
                    </tr>             
                    </tbody>
                </table>
            </div>
            <br>
            
            <form name="enviaEstructuras" id="enviaEstructuras" method="POST" action="{{route("estructuras-añadir",$enlace->id)}}">
                @csrf
                <input type="text" name="estructuras" id="estructuras" hidden>
            </form>
            
            <button type="button" onclick="agregarFila()" class="btn-aceptar"> Agregar estructura</button>
            <button type="button" onclick="eliminarFila()"  id="elim" class="btn-regresar2"> Eliminar estructura</button>
            

            @if ($pass != 1)
            <button type="button" onclick="ConfirmarEliminarEnlace('{{$enlace->name}}')" class="btn-regresar3">Cancelar creación de Enlace</button>             
            @else
                <a href="{{route('estructura-enlace-resumen',$enlace->id)}}"><button type="button" class="btn-regresar">Regresar</button></a>
            @endif
            <button type="button" onclick="guardarValores()" class="btn-aceptar2">Guardar Estructuras</button>
            <br>
            <form action="{{route('enlace-preEliminar',$enlace->id)}}" name="eliminar" method="POST">
                @csrf
                @method('DELETE')
            </form>
            
    
        </div>
    </div>
    
<script type="text/javascript">
        var coordenadas = @json($coordinatesArray);
        var myTable = document.querySelector("table"); 
        
        function ConfirmarEliminarEnlace(nombre){
            if (confirm('Deseas eliminar el enlace '+nombre)) {
                document.eliminar.submit();
                return true;
            } else {
                return false;
            }
        }

        function agregarFila()
        { 
            var row = myTable.insertRow(myTable.rows.length);
            var cell0 = row.insertCell(0);
            var cell1 = row.insertCell(1);
            var cell2 = row.insertCell(2);
            var cell3 = row.insertCell(3);
            var cell4 = row.insertCell(4);
            var cell5 = row.insertCell(5);
            var cell6 = row.insertCell(6);
            
            var anterior = (myTable.rows.length)-2;
            

            cell0.innerHTML = '<label></label>';
            cell1.innerHTML = '<input type="text" class="name" id="name">';
            cell2.innerHTML = '<input type="number" class="Lat" id="lat">';;
            cell3.innerHTML = '<input type="number" class="Lng" id="lng">';;
            cell4.innerHTML = '<select id="tipo" class="tipo" name="cajaEmpalme"><option value="Si">Si</option><option value="No" selected>No</option></select>';;
            cell5.innerHTML = '<input type="number" class="Distancia" id=distancia>';;
            cell6.innerHTML = '<button onclick="limpiarRow(this)">Borrar datos</button>'

            var MiTabla = document.getElementById("table");
            
            var Leibel = MiTabla.rows[anterior+1].cells[0];
            Leibel.innerHTML = anterior;        
        }


        function eliminarFila()
        {
            var rowCount = myTable.rows.length;
            if(rowCount <= 3) {
            alert('No se puede eliminar');
            } else {
            myTable.deleteRow(rowCount -1);
            }
        }

        function guardarValores(){
            let Estruct = [];
            var Vacio = false;
            document.querySelectorAll('.table tbody tr').forEach(function(e){
            let fila = {
                name: e.querySelector('.name').value,
                lat: e.querySelector('.Lat').value,
                lng: e.querySelector('.Lng').value,
                tipo: e.querySelector('.tipo').value,
                distancia: e.querySelector('.Distancia').value
            };
            if(fila.name == "" || fila.lat=="" || fila.lng=="" || fila.tipo=="" || fila.distancia==""){
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
                    document.enviaEstructuras.submit();
                    

                    
                    
            }

            
        }




        

        function limpiarRow(thisRow){
            
            var fila = thisRow.parentNode.parentNode
            fila.cells[1].innerHTML = '<input type="text" class="name" id="name" value="">';
            fila.cells[2].innerHTML = '<input type="text" class="Lat" id="lat" value="">';
            fila.cells[3].innerHTML = '<input type="text" class="Lng" id="lng" value="">';
            fila.cells[4].innerHTML = '<select id="tipo" class="tipo" name="cajaEmpalme"><option value="No">No</option><option value="Si">Si</option></select>';
            fila.cells[5].innerHTML = '<input type="text" class="Distancia" id="distancia" value="">';
            
            
            
        }

        function valorDeFila(thisRow){
            var fila = thisRow.parentNode.parentNode;
            var valor = fila.cells[5].querySelector('.Distancia').value;
            console.log(valor);
        }

        




    </script>


@endsection