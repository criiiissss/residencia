@extends('layouts.app')
@section('contenido')
<div class="divPrincipal">
    <div class="divExtendido">
            <h1 id="fadein">Toma de Mediciones </h1>
            <h2 id="fadein">Gerencia</h1>
                <select id="gerencia" onchange="cambiarZonas(value)" class="select-part-screen">
                        <option>Seleccione una gerencia</option>
                    @forEach($Gerencias as $gerencia)
                        <option value="{{$gerencia->id}}">{{$gerencia->name}}</option>
                    @endforeach
                </select>
                <h2 id="fadein">Zona</h2>
                <select id="zona" onchange="cambiarEnlaces(value)" class="select-part-screen">
                    <option>Seleccione una opcion</option>
                </select>
        <div class="div-medicion">
            <div>
                <form action="{{route('medicion-tomar')}}" method="POST" id="formulario" enctype="multipart/form-data">
                    @csrf
                    <h2>Linea</h2>
                        <select onchange="editarPuntas(value)" id="sEnlace" name="sEnlace" class="select-custom-screen">
                                <option value="a" selected>Seleccione un enlace</option>
                        </select>
                <h2>Punta A</h2>
                    <select id="puntaA" onchange="moverPuntaB(value)" name="puntaA" class="select-input-long2"> 
                    </select>
                <h2>Punta B</h2>
                    <select id="puntaB" name="puntaB" class="select-input-long2">
                    </select>
            </div>
            <div>
                <h2>Fecha del Mantenimiento</h2>
                    
                        <input type="date" id="fecha" name="fecha" class="fecha">
                    
                <h2>Archivo de Medicion en PDF</h2>
                
                    <input type="file" name="pdffile" required accept=".pdf" class="btn-pdf" id="pdf">
                
                <h2>Archivo de Medicion en XLS</h2>
                
                    <input type="file" name="xlsfile" required accept=".xls,.xmls" class="btn-xls" id="xls">
                    
                </form>
            </div>
        </div>
        <a href="{{route('mod-maps')}}"><button class="btn-regresar2">Cancelar</button></a>
        <button onclick="validarCampos()" class="btn-aceptar">Continuar</button>
    </div>
</div>

<script type="text/javascript">    
        var enlaces = @JSON($Enlaces);
        var ubicaciones = @JSON($Ubicaciones);
        var Zonas = @JSON($Zonas);
        var xls = document.getElementById("xls");
        var pdf = document.getElementById("pdf");
        var selecZonas = document.getElementById("zona");
        var selecGerencias = document.getElementById("gerencia");
        var miformulario = document.getElementById("formulario");
        var mantenimiento = document.getElementById("fecha");

        var seleccion0 = document.getElementById("sEnlace");
        var seleccion1 = document.getElementById("puntaA");
        var seleccion2 = document.getElementById("puntaB");

            function editarPuntas(valor){
                while(seleccion1.options.length > 0){
                    seleccion1.remove(0);
                    seleccion2.remove(0);
                }

                var sOpcion1 = document.createElement("option");
                
                sOpcion1.text = "Seleccione un lugar";
                sOpcion1.value = "a";
                puntaA.add(sOpcion1);

                ubicaciones.forEach(ubi => {
                        ubi.enlaces.forEach(enlaces => {
                            if(enlaces.id == valor){
                                console.log(ubi.name);
                                var lugar = document.createElement("option");
                                lugar.text = ubi.name;
                                lugar.value = ubi.id;
                                console.log(lugar);
                                puntaA.add(lugar);

                            }
                        
                            
                        });
                    
                });
            }

            function moverPuntaB(valor){
                var idEnlace = seleccion0.value;
                while(seleccion2.options.length > 0){
                    
                    seleccion2.remove(0);
                }

                ubicaciones.forEach(ubi => {

                    ubi.enlaces.forEach(enlaces => {
                        if(idEnlace == enlaces.id){
                            if(valor != ubi.id){
                                var lugar = document.createElement("option");
                                lugar.text = ubi.name;
                                lugar.value = ubi.id;
                                console.log(lugar);
                                puntaB.add(lugar);
                            }
                        
                        }
                    }); 
                });

                console.log(idEnlace,valor);
            }

            function borrarZonas(){
                selecZonas.options.length = 0;
                var Option = document.createElement("OPTION");
                Option.text = "Seleccione una zona";
                selecZonas.add(Option);

            }

            function borrarEnlaces(){
                seleccion0.options.length = 0;
                var Option = document.createElement("OPTION");
                Option.text = "Seleccione un Enlace";
                seleccion0.add(Option);
            }

            function cambiarZonas(valor){
                borrarZonas()
                Zonas.forEach(zona => {
                    if(zona.idGerencia == selecGerencias.value){
                        var opcion = document.createElement("OPTION");
                        opcion.text = zona.name;
                        opcion.value = zona.id;
                        selecZonas.add(opcion);
                    }
                });
            }

            function cambiarEnlaces(valor){
                borrarEnlaces()
                enlaces.forEach(enlace => {
                        enlace.zona.forEach(zones => {
                            if (zones.id == selecZonas.value) {
                                var op = document.createElement("OPTION")
                                op.text = enlace.name;
                                op.value = enlace.id;
                                seleccion0.add(op);
                            }
                        });
                });
            }

            function validarCampos(){
                if(mantenimiento.value == "" || seleccion0.value == "a" || seleccion1.value == "a" || seleccion1.value == null || seleccion2.value == null){
                    alert('Se detectaron campos vacios, favor de revisar');
                }
                else{
                    miformulario.submit();
                }
            }

        
    </script>
    
@endsection