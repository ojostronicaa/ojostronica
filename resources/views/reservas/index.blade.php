@extends('layouts.app')
@section('content')
<div class="container">

    <div class="row text-center my-3">
        <h1 class="fs-1 my-3">Reservar Aula</h1>
        <form action="/reservas" method="get">
            @csrf
            <input type="date" name="fecha" onchange="this.form.submit()" value="{{$fecha}}">
        </form>
    </div>

    <div class="row d-flex justify-center">

        @if(session('success'))
            <div class="alert my-3 alert-success text-center">{{session('success')}}</div>
        @endif

        @if(session('error'))
            <div class="alert my-3  alert-success text-center">{{session('error')}}</div>
        @endif

        <table class="table text-center my-3 w-75">
            <thead>
                <tr class="table-dark">
                    <td>Horario</td>
                    <td>Reservado</td>
                    <td>Acción</td>
                </tr>
            </thead>

            <tbody>
                @foreach ($horario as $hora)
                    <tr class='bg-success text-white '>
                        <td>{{$hora['hora_inicio']}} - {{$hora['hora_fin']}}</td>
                        @if ($hora['reservada'])
                            <td>
                                <p class="bg-danger text-white rounded">
                                    Reservado - {{$hora['propietarioNombre']}}
                                </p>
                            </td>
                        @else
                            <td>
                                <p class="bg-success text-white rounded">
                                        Disponible
                                </p>
                            </td>
                        @endif

                        @if ($hora['propietario'])
                            <td>
                                <form action="/cancelar" method="post">
                                        @csrf
                                        <input type="hidden" name='idReserva' value="{{$hora['id_reserva']}}">
                                        <button type="submit" class="btn btn-danger">
                                                    Cancelar
                                        </button>
                                </form>
                            </td>
                        @elseif (!$hora['reservada'])
                            <td>
                                <form action="/reservar" method="post">
                                    @csrf
                                    <input type="hidden" name='fecha' value="{{$fecha}}">
                                    <input type="hidden" name='hora_id' value="{{$hora['hora_id']}}">
                                    <button type="submit" class="btn btn-success">
                                                Reservar
                                    </button>
                                </form>
                            </td>
                        @else
                            <td>
                            <button class="btn btn-secondary">
                                Reserva Bloqueada
                            </button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>


@endsection
