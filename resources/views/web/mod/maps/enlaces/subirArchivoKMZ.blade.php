@extends('layouts.app')
@section('contenido')
<div class="divPrincipal">
    <div>
        <div class="div-margin-top-2" style="text-align: center">
            <h1>Seleccione el Archivo <abbr title="Keyhole Markup Language">KMZ</abbr></h1>

        </div>
        <div style="text-align: center" >
            <form action="{{route('enlace-leer-kmz',$enlace->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" accept=".kmz" name="archivo"   required>
                <br>
                <br>
                <br>
                <button class="btn-aceptar2" type="submit">Aceptar</button>
            </form>
        </div>
    </div>
</div>
@endsection