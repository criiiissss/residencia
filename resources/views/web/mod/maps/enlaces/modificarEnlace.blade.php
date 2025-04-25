@extends('layouts.app')
@section('contenido')
<div class="divPrincipal">
    <div class="div-margin-top-2">
        <div class="divModificar">
            <h1 id="fadein">Enlace No.{{$thisEnlace->id}}</h1>
        </div>
        <hr id="fadeLineaLNG">
        <div class="divModificar">
            <h2 id="fadein">Nombre actual del enlace: {{$thisEnlace->name}}</h2>
            <h2 id="fadein">Tensión {{$thisEnlace->tipo}}</h2> 
        </div>
        <hr id="fadeLineaLNG">
        <div>
            <h2 id="fadein">Gerencia</h2>
            <select id="gerencias" onload="insertarZonas(value)" onchange="cambiarZonas(value)" class="select-input-long">
                @foreach ($gerencias as $gerencia)
                    @if($gerencia->id == $thisEnlace->zona->gerencia->id)
                        <option selected value="{{$gerencia->id}}">{{$gerencia->name}}</option>
                    @else
                        <option value="{{$gerencia->id}}">{{$gerencia->name}}</option>
                    @endif
                @endforeach
            </select>
            <input type="hidden" value="{{$thisEnlace->zona->id}}" id="zonaEnlace">
            <form method="POST" action="{{route('enlace-modificar',$id)}}" class="form-nombre-enlace" name="modificar">
                @csrf
                @method('PUT')
                <h2 id="fadein">Zona</h2>
                <select name="zona" id="zona" onchange="cambiarUbicaciones(value)" required>
                </select>
        </div>
            <br>
            <br>
        <div class="form-nombre-enlace2">
            <div>
                <div>
                    <label>Punta A</label>
                    <label>Tensión</label>
                    <label>Punta B</label>
                </div>
                <div>
                    <select id="selec1" onchange="cambiarValor1(value)" required>
                    </select>
                    <select name="tipo" id="tipo" onchange="cambiarNombre(value)" name="tipo" required>
                        @foreach ($tipos as $tipo)
                            @if ($tipo == $thisEnlace->tipo)
                                <option value="{{$tipo}}" selected>{{$tipo}}</option>
                            @else
                                <option value="{{$tipo}}">{{$tipo}}</option>
                            @endif
                        @endforeach
                    </select>
                    <select id="selec2" onchange="cambiarValor2(value)" required>
                    </select>
                    <br>
                    <br>
                </div>
                <div>
                    @if($thisEnlace->tipo == "Subterraneo")
                        <input type="hidden" value="{{$ubicacionEnlace[0]->abreviacion}}" readonly id="in1" name="izq">
                        <input type="hidden" value="{{$type}}" id="in2" readonly name="medio">
                        <input type="hidden" value="{{$nombre}}" id="in3" maxlength="3" name="medio2">
                        <input type="hidden" value="{{$ubicacionEnlace[1]->abreviacion}}" readonly id="in4" name="drcho">
                        <input type="text" id="subte" name="subte" maxlength="30" minlength="10" value="{{$thisEnlace->name}}"><br>
                    @else
                        <input type="text" value="{{$ubicacionEnlace[0]->abreviacion}}" readonly id="in1" name="izq" class="input-no-editable">
                        <input type="text" value="{{$type}}" id="in2" readonly name="medio" class="input-no-editable">
                        <input type="text" value="{{$nombre}}" id="in3" maxlength="3" name="medio2" class="input-editable">
                        <input type="text" value="{{$ubicacionEnlace[1]->abreviacion}}" readonly id="in4" name="drcho" class="input-no-editable">
                        <input type="hidden" id="subte" name="subte" maxlength="30" minlength="10"><br>
                    @endif
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <hr>
        <h1 class="h2-text">Atenuacion ideal</h2>
            <table class="table-atenuacion">
                <tr>
                    <td><h2>KM</h2></td>
                    <td></td>
                    <td><h2>Atenuacion por cada KM</h2></td>
                    <td></td>
                    <td><h2>Atenuación Total de KM</h2></td>
                </tr>
                <tr>
                    <td><input type="number" value="{{$thisEnlace->km}}" id="c1" onchange="calcularAtenuacionIdeal()" name="km"></td>
                    <td><h3>*</h3></td>
                    <td><h2>0.22db</h2></td>
                    <td>=</td>
                    <td><input type="text" value="{{$thisEnlace->atenuacionKm}}" id="c2" readonly name="atenuacionKm"></td>
                </tr>
                <tr>
                    <td><h2>Conectores OHDF</h2></td>
                    <td></td>
                    <td><h2>Atenuacion por cada Conector</h2></td>
                    <td></td>
                    <td><h2>Atenuación Total por Conectores</h2></td>
                </tr>
                <tr>
                    <td><input type="number" value="{{$thisEnlace->conectores}}" id="c3" onchange="calcularAtenuacionIdeal()" name="conectores"></td>
                    <td>*</td>
                    <td><h2>0.35db</h2></td>
                    <td>=</td>
                    <td><input type="text" value="{{$thisEnlace->atenuacionConectores}}" id="c4" readonly name="atenuacionConectores"></td>
                </tr>
                <tr>
                    <td><h2>No de Cajas de Empalme</h2></td>
                    <td></td>
                    <td><h2>Atenuacion por cada caja</h2></td>
                    <td></td>
                    <td><h2>Atenuacion Total por Cajas</h2></td>
                </tr>
                <tr>
                    <td><input type="number" value="{{$thisEnlace->cajasEmpalme}}" id="c5" onchange="calcularAtenuacionIdeal()" name="cajas"></td>
                    <td><h3>*</h3></td>
                    <td><h2>0.05db</h2></td>
                    <td>=</td>
                    <td><input type="text" value="{{$thisEnlace->atenuacionCajas}}" id="c6" readonly name="atenuacioncajas"></td>
                </tr>
            </table> 
            <div class="div-atenuacion-ideal">
                <input type="text" value="{{$thisEnlace->atenuacionIdeal}}" id="c7" readonly name="atenuacionIdeal" class="atenuacion-ideal">
            </div> 
        </form>
        
        <a href="{{route('estructura-enlace-resumen', $thisEnlace->id)}}"><button class="btn-regresar">Cancelar</button></a>
        <button type="submit" class="btn-aceptar" onclick="enviarForm()">Guardar</button>
    </div>
</div>




<script type="text/javascript">
        var opciones = @JSON($ubi);
        var zonas = @JSON($zonas);
        var ubicacion1 = @JSON($ubicacionEnlace[0]);
        var ubicacion2 = @JSON($ubicacionEnlace[1]);
        var zonaYubicacion = @JSON($zonaUbi);
        var seleccion1 = document.getElementById("selec1");
        var seleccion2 = document.getElementById("selec2");
        var seleccionTipo = document.getElementById("tipo");
        var input1 = document.getElementById("in1");
        var input2 = document.getElementById("in2");
        var input3 = document.getElementById("in3");
        var input4 = document.getElementById("in4");
        var sub = document.getElementById("subte");
        var campo1 = document.getElementById("c1");
        var campo2 = document.getElementById("c2");
        var campo3 = document.getElementById("c3");
        var campo4 = document.getElementById("c4");
        var campo5 = document.getElementById("c5");
        var campo6 = document.getElementById("c6");
        var campo7 = document.getElementById("c7");
        var zonaEnlace = document.getElementById("zonaEnlace");
        var gerenciaSelect = document.getElementById("gerencias");
        var zonasSelect = document.getElementById("zona");

        function enviarForm(){
            document.modificar.submit();
        }

        document.addEventListener("DOMContentLoaded", function(){
            insertarZonas(gerenciaSelect);
            insertarUbicaciones(zonasSelect.value);  
        });

        window.onload = function iniciarTabla(){
            calcularAtenuacionIdeal();
        }

        
        function borrarZonas(){
            zonasSelect.options.length = 0;
        }

        function borrarUbicaciones(){
            seleccion1.options.length = 0;
            seleccion2.options.length = 0;
        }

        function insertarUbicaciones(idZonas){
                zonaYubicacion.forEach(zyc => {
                        if(zyc.idZona == idZonas){
                            let op = document.createElement("OPTION");
                            op.text = zyc.name;
                            op.value = zyc.abreviacion;

                            let op2 = document.createElement("OPTION");
                            op2.text = zyc.name;
                            op2.value = zyc.abreviacion;

                                if(zyc.id == ubicacion1.id){
                                    op.selected = true;

                                }else if(zyc.id == ubicacion2.id){
                                    op2.selected = true;
                                }

                            seleccion1.add(op);
                            seleccion2.add(op2);
                        }
                });
            
        }

        function insertarZonas(idGerencia){
            console.log(idGerencia.value)
            zonas.forEach(zona => {
                console.log(zona.idGerencia)
                if(zona.idGerencia == idGerencia.value){
                    var op = document.createElement("OPTION");
                    op.text = zona.name;
                    op.value = zona.id;
                    if(zona.id == zonaEnlace.value){
                        op.selected = true;
                    }
                    console.log(op)
                    console.log(zonaEnlace)
                    zonasSelect.add(op);
                }
            });
        }

        function cambiarZonas(idGerencia){
            borrarZonas()
            zonas.forEach(zona => {
                if(zona.idGerencia == idGerencia){
                    let op = document.createElement("OPTION");
                    op.text = zona.name;
                    op.value = zona.id;
                    zonasSelect.add(op);
                }
            });
        }

        function cambiarUbicaciones(idZona){
            borrarUbicaciones();
            insertarUbicaciones(idZona);
            input1.value = seleccion1.value;
            input4.value = seleccion2.value;
            
        }

        function cambiarNombre(valor){
                if(valor == "400KV"){
                    input1.setAttribute("type", "text");
                    input2.setAttribute("type", "text");
                    input3.setAttribute("type", "text");
                    input4.setAttribute("type", "text");
                    sub.setAttribute("type", "hidden");
                    input2.value = "A3";
                }
                else if(valor == "230KV"){
                    input1.setAttribute("type", "text");
                    input2.setAttribute("type", "text");
                    input3.setAttribute("type", "text");
                    input4.setAttribute("type", "text");
                    sub.setAttribute("type", "hidden");
                    input2.value = "93";
                }
                else if(valor == "115KV"){
                    input1.setAttribute("type", "text");
                    input2.setAttribute("type", "text");
                    input3.setAttribute("type", "text");
                    input4.setAttribute("type", "text");
                    sub.setAttribute("type", "hidden");
                    input2.value = "73";
                }
                else if(valor == "13.8KV"){
                    input1.setAttribute("type", "text");
                    input2.setAttribute("type", "text");
                    input3.setAttribute("type", "text");
                    input4.setAttribute("type", "text");
                    sub.setAttribute("type", "hidden");
                    input2.value = "40";
                }
                else if(valor == "Subterraneo"){
                    input1.setAttribute("type", "hidden");
                    input2.setAttribute("type", "hidden");
                    input3.setAttribute("type", "hidden");
                    input4.setAttribute("type", "hidden");
                    sub.setAttribute("type", "text");
                    sub.value="";
                }
        }


        function cambiarValor1(valor){
            if(valor == seleccion2.value){
                seleccion2.value = "";
                input4.value = "";
            }
            opciones.forEach(op => {
                if(op.abreviacion == valor){
                    let option = seleccion2.querySelector(`option[value="${op.abreviacion}"]`);
                    input1.value = valor;
                    option.disabled = true;
                }
                else{
                    let option = seleccion2.querySelector(`option[value="${op.abreviacion}"]`);
                    if(option != null){
                        option.disabled = false;
                    }
                }
            });
        }

        function cambiarValor2(valor){
            input4.value = valor;
            if(valor == seleccion1.value){
                seleccion2.value = "";
                input4.value = "";
            }
        }

        function financial(x) {
            return Number.parseFloat(x).toFixed(2);
        }

        function calcularAtenuacionIdeal(){
            var atenuacionEnKM = (financial(campo1.value) * 0.22);
                campo2.value = financial(atenuacionEnKM);
            var atenuacionEnCnt = (financial(campo3.value) * 0.35);
                campo4.value = financial(atenuacionEnCnt);
            var atenuacionEnCj = (financial(campo5.value) * 0.05);
                campo6.value = financial(atenuacionEnCj);
                
                campo7.value = financial(atenuacionEnCj + atenuacionEnCnt + atenuacionEnKM);


        }


        

    

    </script>
@endsection