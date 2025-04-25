@extends('layouts.app')
@section('contenido')

<div class="principal-fullscreen">
    <div class="div-principal-fullscreen">
    <h1 class="center-text">
        Estado de los enlaces
    </h1>
    <div class="div-marginado">
        <table class="table2">
            <thead>
                <tr>
                    <th class="ubi-table">Ubicacion</th>
                    <th class="nombre-enlace-table">Nombre del Enlace</th>
                    <th class="at-real-table">Atenuacion Real</th>
                    <th class="at-ideal-table">Atenuacion Ideal</th>
                    <th class="estado-table">Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="div-marginado2">
        <div class="tablaContainer2">
            <table class="table2">
                <tbody>
                    @foreach ($ubicaciones as $ubicacion)
                        @if (count($ubicacion->enlaces)>0)
                            
                                @php
                                    $ArregloEnlaces = [];
                                @endphp
                                @foreach ($ubicacion->enlaces as $enlace)
                                    @php
                                    // Encuentra la posición del primer guion en el nombre
                                        $posGuion = strpos($enlace->name, '-');
                                        $abreviacion = $ubicacion->abreviacion;

                                        if($abreviacion == (substr($enlace->name,0,$posGuion))){
                                            $ArregloEnlaces[]=$enlace;
                                        }
                                    @endphp
                                @endforeach

                                @if (count($ArregloEnlaces)>0)
                                        <tr>
                                        <td rowspan="{{count($ArregloEnlaces)}}">{{$ubicacion->name}}</td>
                                        @foreach ($ArregloEnlaces as $en)
                                            
                                            <td>{{$en->name}}</td>
                                            
                                            @if ($en->medic != null)
                                                <td>{{bcdiv($en->medic->atenuacionReal,'1',2)}}</td>
                                                <td>{{bcdiv($en->atenuacionIdeal,'1',2)}}</td>
                                                <td><div class="btn-rojo"></td>
                                            @else
                                                <td><abbr title="Sin medición registrada">S/M</abbr></td>
                                                <td>{{bcdiv($en->atenuacionIdeal,'1',2)}}</td>
                                                <td><div class="btn-verde"></td>
                                            @endif

                                            <td><a href="{{route('estructura-enlace-resumen',$en->id)}}"><button>Ver enlace</button></a><br>
                                            @if ($en->medic !=null)
                                            <a href="{{route('mediciones-detalles',$en->medic->id)}}"><button>Ir a ultima medición</button></a>
                                            @endif
                                            
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="7"><hr></td>
                                        </tr>
                                    
                                @endif
                        @endif
                    @endforeach
                                
            </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var enlaces = @json($enlaces);
    var ubicaciones = @json($ubicaciones);

    console.log(ubicaciones);
</script>
@endsection