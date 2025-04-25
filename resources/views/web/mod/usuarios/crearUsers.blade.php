@extends('layouts.app')
@section('contenido')
<div class="divPrincipal">
    <div>
        <form action="{{route('users-agregar')}}" method="POST" name="crear">
            @csrf
            <h1>Crear Nuevo Usuario</h1>
            <label>Nombre</label>
            <br>
            <input type="text" required name="name" class="input-full-screen2">
            <br><br>
            <label>Apellidos</label>
            <br>
            <input type="text" required name="apellidos" class="input-full-screen2">
            <br><br>
            <label>R.P.E</label>
            <br>
            <input type="text" required name="rpe" class="input-full-screen2">
            <br><br>
            <label>Rol</label>
            <br>
            <select name="rol" class="select-input-long">
                @foreach ($niveles as $nivel)
                    <option value="{{$nivel}}">{{$nivel}}</option>
                @endforeach
            </select>
            <br><br>
            <label>Email</label>
            <br>
            <input type="email" required name="email" class="input-full-screen2">
            <br><br>
            <label>Password</label>
            <br>
            <input type="password" required name="password" class="input-full-screen2">
            <br><br>
            <br><br>
            <div>
                <br>
                </form>
                
            </div>
            <a href="{{route('users-ver')}}"><button class="btn-regresar">Regresar</button></a>
            <a><button class="btn-aceptar" onclick="confirmar()">Crear</button></a>
    </div>

</div>  

<script type="text/javascript">

    function confirmar(){
        document.crear.submit();
    }
</script>
@endsection