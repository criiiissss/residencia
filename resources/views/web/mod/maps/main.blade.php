@extends('layouts.app')

@section('contenido')
    <div class="divPrincipal">
        <div class="moduloOpciones">
            <div>
                <div>
                    <div>
                        <a href="/modulos"><button class="btn-regresar"><span>Regresar</span></button></a>
                    </div>
                    <h1>MODULO DE MONITOREO</h1>
                    <br>
                    <br>
                    <h2>Acerca de este modulo</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc porttitor mauris neque, sit amet pretium lacus feugiat vitae. Vestibulum sollicitudin quam vel mi sodales commodo. Nunc diam turpis, vulputate eget dapibus et, sagittis a diam. Nunc convallis, metus et tristique dapibus, mauris risus molestie justo, eu aliquet dolor magna nec dui. Nullam et quam scelerisque, porttitor augue eu, eleifend odio. Nulla vitae blandit lectus, a rhoncus enim. Aliquam imperdiet diam urna, ac vulputate lorem venenatis non. Integer metus purus, tempor vitae gravida at, porttitor et lectus. Integer quis lorem et neque rutrum mollis quis et nisi. Etiam tempor, mauris efficitur malesuada hendrerit, sem magna fermentum urna, sit amet pretium lorem ipsum nec diam. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.

                    Aliquam orci turpis, volutpat quis rutrum ac, cursus id magna. Nullam non metus euismod, convallis quam non, hendrerit velit. Mauris vehicula egestas scelerisque. Donec aliquam mi quis arcu bibendum lacinia. Praesent ut facilisis lectus, quis mattis sapien. Donec elit ligula, iaculis eget tincidunt ac, suscipit id nulla. Suspendisse lacus purus, tincidunt id vulputate vel, ullamcorper tincidunt ipsum.</p>
                </div>
                <br>
                <hr>
                <br>
                <div>
                    <div>
                        @if (auth()->user()->rol == 'level3')
                            <div>
                                <a href="/modulos/maps/enlace/crear"><button class="btn-opciones-modulo"><img src={{asset('image/enlace.png')}} class="img-btn-opciones-modulo2"></button></a>
                                <h3>Crear enlace</h3>
                            </div>
                        @endif
                        <div>
                            <a href="/modulos/maps/enlace/ver"><button class="btn-opciones-modulo"><img src={{asset('image/ojo-abierto.png')}} class="img-btn-opciones-modulo"></button></a>
                            <h3>Ver enlace</h3>
                        </div>
                        <div>
                            <a href="/modulos/maps/mediciones/toma"><button class="btn-opciones-modulo"><img src={{asset('image/tomar-nota.png')}} class="img-btn-opciones-modulo2"></button></a>
                            <h3>Tomar medición</h3>
                        </div>
                        <div>
                            <a href="/modulos/maps/mediciones/ver"><button class="btn-opciones-modulo"><img src={{asset('image/ojo.png')}} class="img-btn-opciones-modulo"></button></a>
                            <h3>Ver medición</3>
                        </div>
                        <div>
                            <a href="/modulos/maps/ubicaciones/ver"><button class="btn-opciones-modulo"><img src={{asset('image/marcador-de-posicion.png')}} class="img-btn-opciones-modulo2"></button></a>
                            <h3>Ver ubicaciones</h3>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div>
                
                
            </div>
        </div>
    </div>
@endsection
