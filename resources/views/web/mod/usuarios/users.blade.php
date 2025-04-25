@extends('layouts.app')
@section('contenido')
<div class="divPrincipal">
    <div>
        <h1 class="titulo-tabla">Usuarios</h1>
        <table class="table">
            <thead>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>R.P.E</th>
                <th>Email</th>
                <th>ROL</th>
                <th>Alta en el sistema</th>
                @if(auth()->user()->rol == "level3")
                    <th>Acciones</th>
                @endif
            </thead>
            @foreach($usuarios as $usuario)
            <tr>
                <td>{{$usuario->name}}</td>
                <td>{{$usuario->apellido}}</td>
                <td>{{$usuario->rpe}}</td>
                <td>{{$usuario->email}}</td>
                <td>{{$usuario->rol}}</td>
                <td>{{$usuario->created_at}}</td>
                @if (auth()->user()->rol == "level3")
                    <td><a href="{{route('users-ver-modificar',$usuario->id)}}"><button>Modificar</button></a>
                    <form action="{{route('users-delete',$usuario->id)}}" method="POST" id="formEliminar">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Desea eliminar al usuario: {{$usuario->name}} con el RPE: {{$usuario->rpe}}')" class="btn-regresar2">Eliminar</button></td>
                    </form>
                @endif
            </tr>
            @endforeach
        </table>
        <div>
            <a href="/modulos"><button class="btn-regresar">Regresar</button></a>
            @if(auth()->user()->rol == 'level2' || auth()->user()->rol == 'level3')
                <a href="{{route('users-create')}}"><button class="btn-aceptar2">Crear nuevo Usuario</button></a>
            @endif
        </div>
    </div>
</div>

<script type="text/javascript">

</script>
@endsection