@extends('layouts.app')
@section('contenido')

<div class="divPrincipal">
    <div style="margin-top: 4em">
        <div>
            <h1 style="text-align: center">Selecciona el metodo por el cual agregar las estructuras</h1>
        </div>
    <div class="botonesMain">
        <div>
            <a href="{{route('enlace.decision.kmz',$enlaceModificado->id)}}"><button><img src={{asset('image/simbolo-de-formato-de-archivo-kmz.png')}}><br><br>INGRESAR ARCHIVO KMZ</button></a>
            <a href="{{route('estructuras-agregar-pantalla',$enlaceModificado->id)}}"><button><img src={{asset('image/escribiendo.png')}}><br><br>INGRESAR DE MANERA MANUAL</button></a>
        </div>
    </div>
    </div>
</div>
@endsection