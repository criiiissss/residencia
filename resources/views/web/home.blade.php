@extends('layouts.appHeader')
@section('contenido')
<div class="divPrincipal">
    <div class="divInicio">
        <div>
            <h2 class="estiloH2">Inicio de Sesion</h2>
            <hr>
        </div>
        <br>
        <div class="division">
            <div>
                <img src={{asset('image/fibra.jpg')}} class="img-gnd">
            </div>
            <div class="form">
                <form action="{{route('login-app')}}" method="post">
                    @csrf
                    <div><img src={{asset('image/usuario.png')}} class="imgForm"><label>R.P.E</label></div>
                    <br>
                    <input type="text" name="rpe" class="jinput">
                    <br>
                    <br>
                    <div><img src={{asset('image/cerrar-con-llave.png')}} class="imgForm"><label>Contraseña</label></div>
                    <br>
                    <input type="password" name="password">
                    <br><br><br>
                    <button type="submit" value="enviar" class="botonEnviar">Ingresar</button>
                    <br>
                    <br>
                </form>
                
            </div>
        </div>
    </div>

    <script type="text/javascript">
        window.onload = function iniciarTabla(){
            @if($errors->any())
                window.alert('{{ $errors->first() }}');
            @endif
        }
    </script>
</div>
@endsection