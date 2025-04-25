@extends('layouts.app')

@section('contenido')
    <div class="divPrincipal">
        <div class="div-margin-top-1">
            <form action="{{route('enlace-agregar-modificar-conectores',$enlace->id)}}" method="POST" name="estructura" >
                @csrf
                @method('PUT')
                <div class="div-atenuacion-ideal">
                    <h1>Atenuacion ideal del Enlace {{$enlace->name}}</h1>
                </div>
                <table class="table-atenuacion">
                    <tr>
                        <td><h2>Km del enlace</h2></td>
                        <td></td>
                        <td><h2>Atenuacion por Km</h2></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><input type="number" id="km" name="km" onchange="mul()" required></td>
                        <td><h2>*</h2></td>
                        <td><h3>.22db</h3></td>
                        <td><h2>=</h2></td>
                        <td><input type="number"  name="aKm" id="aKm" readonly class="resultado"></td>
                    </tr>
                    <tr>
                        <td><h2>Cantidad de ODFs</h2></td>
                        <td></td>
                        <td><h2>Atenuacion por conector del ODF</h2></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><input type="number" id="ctor" name="ctor" onchange="mul2()" required></td>
                        <td><h2>*</h2></td>
                        <td><h3>0.35db</h3></td>
                        <td><h2>=</h2></td>
                        <td><input type="number" name="aCtor" id="aCtor" readonly class="resultado"></td>
                    </tr>
                    <tr>
                        <td><h2>Cajas de empalme en <br> trayectoria de la linea</h2></td>
                        <td></td>
                        <td><h2>Atenuacion por empalme</abbr></h2></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><input type="number" onchange="mul3()"  id="aCajas" name="cCajas" required></td>
                        <td><h2>*</h2></td>
                        <td><h3>0.025db</h3></td>
                        <td><h2>=</h2></td>
                        <td><input name="aCaja" id="aCaja" readonly class="resultado"></td>
                    </tr>
                </table>
                <div class="div-atenuacion-ideal">
                    <input type="number" id="atenuacionIdeal" name="atenuacionIdeal" class="atenuacion-ideal" readonly>
                </div>
            </form>
                           
            <form action="{{route('enlace-eliminar',$enlace->id)}}" method="POST" name="eliminar">
                @csrf
                @method('DELETE')
            </form>
            <input type="text" value="{{$enlace->name}}" id="nombreEnlace" hidden>
            <button type="submit" onclick="return ConfirmarEliminacion('{{$enlace->name}}')" class="btn-regresar">Cancelar</button>
            <button type="submit" class="btn-aceptar2" onclick="enviarEstructuras()">Guardar y Agregar Estructuras</button></a>
        </div>
    </div>

    <script type="text/javascript">
        var atIdeal = document.getElementById("atenuacionIdeal");
        var elementoImprimir = document.getElementById("aKm");
        var resultadoCtor = document.getElementById("aCtor");
        var resultadoCaja = document.getElementById("aCaja");
        var nombre = document.getElementById("nombreEnlace").value;
        
        var condicion1 = 0;
        var condicion2 = 0;
        var condicion3 = 0;

            function ConfirmarEliminacion(nombre){
                if (confirm('Estas seguro de eliminar el enlace '+ nombre)) {
                    document.eliminar.submit();
                    return true;
                }else{
                    
                    return false;
                }
            }
            function enviarEstructuras(){
                console.log("Condicion1"+condicion1);
                console.log("Condicion2"+condicion2);
                console.log("Condicion3"+condicion3);
                if(condicion1 == 1 && condicion2 == 1 && condicion3 == 1){
                document.estructura.submit();
                }
                else{
                    window.alert('Verifique que todos los campos esten llenados')
                }
            }


            function comprobarMul(){
                console.log(condicion1);
                console.log(condicion2);
                console.log(condicion3);
                if(condicion1 == 1 && condicion2 == 1 && condicion3 == 1){
                    atIdeal.value = ((parseFloat(elementoImprimir.value))+ (parseFloat(resultadoCaja.value))+ (parseFloat(resultadoCtor.value))).toFixed(3);
                }
                else{
                    atIdeal.value = "";
                }
            }
            
            
            function mul(){
                var elementoKm = document.getElementById("km").value;
                var multiplicar = ((parseFloat(elementoKm))*0.22).toFixed(3);
                elementoImprimir.value=multiplicar;
                
                if(elementoKm != "" ){
                    condicion1 = 1;
                }
                else{
                    condicion1 = 0;
                }
                comprobarMul(); 
            }

            function mul2(){
                var elementoCtor = document.getElementById("ctor").value;
                var multiplicar = ((parseFloat(elementoCtor))*0.35).toFixed(3);
                resultadoCtor.value = multiplicar;
                if(elementoCtor != "" ){
                    condicion2 = 1;
                }
                else{
                    condicion2 = 0;
                }
                comprobarMul();
            }

            function mul3(){
                var elementoCaja = document.getElementById("aCajas").value;
                var multiplicar = ((parseFloat(elementoCaja))*0.025).toFixed(3);
                resultadoCaja.value = multiplicar;
                if(elementoCaja != "" ){
                    condicion3 = 1;
                }
                else{
                    condicion3 = 0;
                }
                comprobarMul();
            }
            
            
    </script>
@endsection