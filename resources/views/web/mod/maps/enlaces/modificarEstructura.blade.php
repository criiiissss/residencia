@extends('layouts.app')
@section('contenido')
<div class="divPrincipal">
    <div class="divExtendido">
        <div>
            <div>
            <br>
            <h1>Modificar Estructura 🗼</h1>
            <br>
                <form action="{{route('estructuras-edit',$estaEstructura->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <table class="table">
                        <thead>
                            <tr>
                                <th><label for="name"> Nombre de la estructura </label></th>
                                <th><label for="tipo">Caja de Empalme</label></th>
                                <th><label for="distancia">Distancia</label></th>
                                <th><label> Latitud</label></th>
                                <th><label> Longitud</label></th>
                                <th><label>Distancia de la <br>anterior estructura</label></th>
                            </tr>
                        </thead>
                        <tr>
                            <td><input type="text"  value="{{$estaEstructura->name}}" id="name" name="name" required class="input-editable"></td>
                            <td><select name="tipo">
                                <option value="{{$tipoEstructura}}"> {{$tipoEstructura}} </option>
                                <option value="{{$otroTipo}}"> {{$otroTipo}}</option>
                                </select>
                            </td>
                            <td><input type="text" value="{{bcdiv($estaEstructura->distancia,'1',2)}}" required class="input-editable"></td>
                            <td><input type="text" value="{{$estaEstructura->lat}}" name="lat" required class="input-editable"></td>
                            <td><input type="text" value="{{$estaEstructura->lng}}" name="lng" required class="input-editable"></td>
                            <td><input type="text" value="{{bcdiv($estaEstructura->distancia,'1',2)}}" class="input-editable"></td>
                        </tr>
                    </table>
                    <div>
                        <br>
                        <button type="submit" class="btn-aceptar"> Modificar </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection