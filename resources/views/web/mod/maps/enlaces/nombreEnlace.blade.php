@extends('layouts.app')

@section('contenido')
<div class="divPrincipal">
        <div>
            <form action="{{route('enlace-añadir')}}" method="POST" name="ingresarNombre" id="ingresarNombre" class="form-nombre-enlace">
                @csrf
                <!-- SELECCIONAR UBICACIONES -->
                <h1 class="slide-in"><span class="font"> Nombre de Enlace</span></h1>
                <div>
                    <label>Gerencia</label>
                    <select id="gerencia" onchange="cambiarZona(value)" class="select-input-long">
                        <option selected value="nogerencia"> Seleccione una gerencia </option>
                        @forEach($gerencias as $gerencia)
                            <option value="{{$gerencia->id}}">{{$gerencia->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Zona - Punta A</label>
                    <select id="zonaA" onchange="cambiarUbicacionesZonaA(value)" name="zonaA" class="select-input-long">
                        <option selected value="nozona">Seleccione una zona</option>
                    </select><br>
                </div>
                <div>
                    <label>Zona - Punta B</label>
                    <select id="zonaB" onchange="cambiarUbicacionesZonaB(value)" name="zonaB" class="select-input-long">
                        <option selected value="nozona">Seleccione una zona</option>
                    </select><br>
                </div>
                <div class="nombre-enlace-div">
                    <label>Punta A </label>
                    <select onchange="modificar1()" id="select1" name="ubi1" required>
                        <option value="a">Seleccione una ubicacion</option>
                    </select>
                    <label>Tensión</label>
                    <select name="tipo" onchange="cambiarNombre(value)" id="tipo">
                        <option value="400KV">400KV</option>
                        <option value="230KV">230KV</option>
                        <option value="115KV">115KV</option>
                        <option value="13.8KV">13.8KV</option>
                        <option value="Subterraneo">Subterraneo</option>
                    </select>
                    <label>Punta B </label>
                    <select onchange="modificar2(value)" id="select2" name="ubi2" required>
                        <option value="a">Seleccione una ubicacion</option>
                        
                    </select>
                </div>
                <div class="nombre-enlace-div">
                    <br>
                    <label>Nombre de Enlace</label>
                    <input type="text" value="" name="izq" id="izq" class="input-no-editable" readonly required> 
                    <input type="text" value="A3" name="centro" id="centro"  class="input-no-editable"  readonly required>
                    <input type="text" value="" name="centro2"  id="centro2" required maxlength="3" checked class="input-editable"> 
                    <input type="text" value="" name="dcho" id="dcho" readonly required class="input-no-editable">
                    <input name="sub" value="sub" id="sub" type="hidden" required minlength="15" maxlength="30">
                    <br>
                </div>
                <div>
                    <label>Cantidad de Fibras</label>
                    <select name="noFibras" id="noFibrass" class="select-full-screen">
                        <option value="12">12</option>
                        <option value="24">24</option>
                        <option value="36" selected>36</option>
                        <option value="42">42</option>
                    </select>
                </div>
            </form>
            <div class="nombre-enlace-div">
                <a href="{{route('mod-maps')}}"><button class="aparecerbtn">Cancelar</button></a>
                <button onclick="enviarFormulario()" class="aparecerbtn">Siguiente</button>
            </div>
        </div>
        
</div>
    <script type="text/javascript">
        var Enlaces = @json($enlaces);
        var Zonas = @json($zonas);
        var Opciones = @json($ubicaciones);
        var ger = document.getElementById("gerencia");
        var zon = document.getElementById("zonaA");
        var zon2 = document.getElementById("zonaB");
        var select0 = document.getElementById("tipo");
        var select1 = document.getElementById("select1");
        var select2 = document.getElementById("select2");
        var iz = document.getElementById("izq");
        var cen = document.getElementById("centro");
        var cen2 = document.getElementById("centro2");
        var dr = document.getElementById("dcho");
        var subte = document.getElementById("sub");
        var opcional1 = 0;
        var opcional2 = 0;

        function cambiarNombre(valor){
                if(valor == "400KV"){
                    iz.setAttribute("type", "text");
                    cen.setAttribute("type", "text");
                    cen2.setAttribute("type", "text");
                    dr.setAttribute("type", "text");
                    subte.setAttribute("type", "hidden");
                    cen.value = "A3";
                }
                else if(valor == "230KV"){
                    iz.setAttribute("type", "text");
                    cen.setAttribute("type", "text");
                    cen2.setAttribute("type", "text");
                    dr.setAttribute("type", "text");
                    subte.setAttribute("type", "hidden");
                    cen.value = "93";
                }
                else if(valor == "115KV"){
                    iz.setAttribute("type", "text");
                    cen.setAttribute("type", "text");
                    cen2.setAttribute("type", "text");
                    dr.setAttribute("type", "text");
                    subte.setAttribute("type", "hidden");
                    cen.value = "73";
                }
                else if(valor == "13.8KV"){
                    iz.setAttribute("type", "text");
                    cen.setAttribute("type", "text");
                    cen2.setAttribute("type", "text");
                    dr.setAttribute("type", "text");
                    subte.setAttribute("type", "hidden");
                    cen.value = "40";
                }
                else if(valor == "Subterraneo"){
                    iz.setAttribute("type", "hidden");
                    cen.setAttribute("type", "hidden");
                    cen2.setAttribute("type", "hidden");
                    dr.setAttribute("type", "hidden");
                    subte.setAttribute("type", "text");
                    subte.value="";
                }
        }

        function modificar1(){
            var valor = select1.value;
            let s2 = select2.querySelector(`option[value="a"]`);
            s2.selected = true;
            dcho.value="";
            Opciones.forEach(op => {
                console.log(op)
                console.log(valor)
                if(op.id == valor){
                    
                    let option = select2.querySelector(`option[value="${op.id}"]`);
                    izq.value = op.abreviacion;
                    option.disabled = true;
                    opcional1=1;
                }
                else if(valor == "a"){
                    izq.value = "";
                    let option = select2.querySelector(`option[value="${op.id}"]`);
                    console.log(option)
                    if(option != null){
                        option.disabled = false;
                    }

                }
                else{
                    let option = select2.querySelector(`option[value="${op.id}"]`);
                    console.log(option)
                    if(option != null){
                        option.disabled = false;
                    }
                }
            });
        }

        function modificar2(valor){
            if(valor == "a"){
                dcho.value="";
                opcional2=0;
            }
            else{
                Opciones.forEach(ubi => {
                    if(valor == ubi.id){
                        dcho.value = ubi.abreviacion;
                        opcional2=1;
                    }
                });
            }
        }

        function borrarZonas(){
            zon.options.length = 0;
            zon2.options.length = 0;
            var opcion = document.createElement("OPTION");
            opcion.text = "Seleccione una zona";
            opcion.value = "nozona"

            var opcion2 = document.createElement("OPTION");
            opcion2.text = "Seleccione una zona";
            opcion2.value = "nozona"

            zon.add(opcion);
            zon2.add(opcion2);
            borrarUbicacionesA();
            borrarUbicacionesB();
        }

        function borrarUbicacionesA(){
            select1.options.length = 0;
            var opcion = document.createElement("OPTION");
            opcion.text = "Seleccione una ubicacion";
            opcion.value = "a"
            select1.add(opcion);
            iz.value="";
            
        }

        function borrarUbicacionesB(){
            select2.options.length = 0;
            var opcion = document.createElement("OPTION");
            opcion.text = "Seleccione una ubicacion";
            opcion.value = "a"
            select2.add(opcion);
            dr.value="";
            
        }

        function cambiarZona(g){
            borrarZonas();
                Zonas.forEach(z => {
                    console.log(z.gerencia.id)
                    if(z.gerencia.id == ger.value){
                        var opcion = document.createElement("OPTION");
                        opcion.text = z.name;
                        opcion.value = z.id;

                        var opcion2 = document.createElement("OPTION");
                        opcion2.text = z.name;
                        opcion2.value = z.id;

                        zon.add(opcion);
                        zon2.add(opcion2);
                    }
                });
            
        }

        function cambiarUbicacionesZonaA(z){
            borrarUbicacionesA()
            console.log(z);
            Opciones.forEach(ubi => {
                if(ubi.idZona == z){
                    var opcion = document.createElement("OPTION");
                    opcion.text = ubi.name;
                    opcion.value = ubi.id;
                    select1.add(opcion);
                    
                }
                               
            });
        }

        function cambiarUbicacionesZonaB(z){
            borrarUbicacionesB()
            console.log(z);
            Opciones.forEach(ubi => {
                if(ubi.idZona == z){
                    var opcion = document.createElement("OPTION");
                    opcion.text = ubi.name;
                    opcion.value = ubi.id;
                    select2.add(opcion);
                    
                }
                               
            });
        }

        function enviarFormulario(){
            if((select1 != "a" && select2 != "a" && iz.value != "" && cen2.value != "" && dr.value != "" )|| (select0.value == "Subterraneo" && select1.value != "a" && select2.value!="a")){
            var nombre;
            var repetido=0;

            if(select0.value == "subterraneo"){
                nombre = subte.value;
            }
            else{
                nombre = (iz.value + '-' + cen.value+cen2.value + '-' + dr.value)
            }
            Enlaces.forEach(e => {
                if(e.name == nombre){
                    repetido=1;
                }
            });

            if(repetido==1){
                window.alert("EL NOMBRE QUE USTED ESTA INGRESANDO YA EXISTE DENTRO DE LOS REGISTROS FAVOR DE COMPROBAR");
            }
            else{
                document.ingresarNombre.submit();
            }
                
            }
            else{
                window.alert("SELECCIONE UBICACIONES");
            }
        }


        </script>
@endsection