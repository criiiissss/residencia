@extends('layouts.app')
@section('contenido')
<div class="divPrincipal">
    <div>
        <div>
            <h1>Modificar Usuario</h1>
            <form action="{{route('users-modificar', $Usuario->id)}}" method="POST" name="modificar"> 
                @csrf
                @method('PUT')
                <label>Nombre</label><br>
                <input type="text" value="{{$Usuario->name}}" name="name" class="input-full-screen2">
                <br><br>
                <label>Apellidos</label><br>
                <input type="text" value="{{$Usuario->apellido}}" name="apellido" class="input-full-screen2">
                <br><br>
                <label>R.P.E</label><br>
                <input type="text" value="{{$Usuario->rpe}}" name="rpe" class="input-full-screen2">
                <br><br>
                <label>Email</label><br>
                <input type="email" value="{{$Usuario->email}}" name="email" class="input-full-screen2">
                <br><br>
                <label>Cambiar Contraseña</label><br>
                <input type="password" placeholder="Dejar en blanco para mantener la misma contraseña" name="password" class="input-full-screen2">
                <br><br>
                <label>Rol</label><br>
                <select name="rol" class="select-input-long">
                    @foreach ($niveles as $nivel)
                        @if ($nivel == $Usuario->rol)
                            <option value="{{$nivel}}" selected>{{$nivel}}</option>
                        @else
                        <option value="{{$nivel}}">{{$nivel}}</option>
                        @endif
                    @endforeach
                </select>
                <br><br>
                <br><br>
            </form>
                <a href="{{route('users-ver')}}"><button class="btn-regresar">Regresar</button></a>
                <button type="submit" class="btn-aceptar"  onclick=confirmar()>Modificar</button>
        </div>
    </div>
</div>
    
<script type="text/javascript">
    var usuario = @json($Usuario);
    function confirmar(){
        if(confirm('Esta seguro de modificar el usuario '+usuario.name+ ' con el r.p.e. '+usuario.rpe)){
            document.modificar.submit()
            return true;
        }else{
            return false;
        }
    }
</script>
@endsection