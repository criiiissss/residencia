@extends('layouts.app')
@section('contenido')
<div class="divPrincipal">
    <div>
        <table border="2" class="table">
            @forEach($Gerencias as $gerencia)
                <tr>
                    <td colspan="3"><h2>{{$gerencia->name}}, {{$gerencia->enum}}</h2></td>
                </tr>
                @forEach($zonas as $zona)
                    @if($zona->idGerencia == $gerencia->id)
                        <tr>
                            <td>{{$zona->name}}</td>
                            <td>{{$zona->enum}}</td>
                            <td><button>Ver Enlaces</button></td>
                        </tr>
                    @endif
                @endforeach

            @endforeach
        </table>

        <a href="{{route('mod-app')}}"><button class="btn-regresar">Regresar</button></a>
    </div>
</div>
@endsection