<div id="container-header">



    <a href= "{{route('mod-app')}}" id="botonCFE"><img id="logoCFE" src= {{ asset('image\logoDT2.png') }}></a>
    @auth
    <div class="dropdown">
        <button class="dropdown-btn" onclick="redirect0()">Tabla de Estados</button>
    </div>
    <div class="dropdown">
        <button class="dropdown-btn" onclick="redirect()">Monitoreo de Enlaces
        </button> 
            <div class="dropdown-content">
                <a href="{{route('enlace-crear')}}">Crear Enlace</a>
                <a href="{{route('enlace-ver')}}">Ver Enlaces</a>
                <a href="{{route('medicion-ver')}}">Ver Mediciones</a>
                <a href="{{route('ubicaciones-ver')}}">Ver Ubicaciones</a>
            </div>
    </div>
    <div class="dropdown">
        <button class="dropdown-btn" onclick="redirect2()">Gestión de Usuarios
            
        </button>
            <div class="dropdown-content">
                <a href="{{route('users-create')}}">Crear Usuario</a>
                <a href="{{route('users-ver')}}">Ver Usuarios</a>
            </div>
    </div>
    <a href="{{route('logout')}}" id="red">Cerrar Sesion</a>
    @endauth
    
    
</div>
<script type="text/javascript">
    function redirect(){
        location.replace("/modulos/maps");
    }
    function redirect2(){
        location.replace("/modulos/usuarios/ver");
    }

    function redirect0(){
        location.replace("{{route('enlaces-tabla')}}");
    }
</script>
