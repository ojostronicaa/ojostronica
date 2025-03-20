<?php

namespace App\Http\Controllers;

use App\Models\Horarios;
use App\Models\Reservas;
use App\Models\User;
use Illuminate\Http\Request;

class reservaController extends Controller{

    public function index(Request $request){
        try {
            $fecha = $request->input('fecha', now()->toDateString());

            $horario = Horarios::all();

            $idUser = $request->user()->id;

            $horarioRenderizar = [];

            foreach ($horario as $hora) {
                $rex = [
                    'id_reserva' => null,
                    'reservada' => false,
                    'propietario' => null,
                    'propietarioNombre' => null,
                    'hora_inicio' => $hora->hora_inicio,
                    'hora_fin' => $hora->hora_fin,
                    'hora_id' => $hora->id
                ];

                $reserva = Reservas::where('fecha', $fecha)
                                    ->where('horario_id', $hora->id)->first();

                if($reserva){
                    $rex['reservada'] = true;
                    $rex['id_reserva'] = $reserva->id;
                    if($reserva->user_id == $idUser){
                        $rex['propietario'] = true;
                    }

                    $rex['propietarioNombre'] =  User::find($reserva->user_id)->name;
                }

                array_push($horarioRenderizar, $rex);

            }

            return view('reservas.index', ['horario'=>$horarioRenderizar, 'fecha'=>$fecha]);
        } catch (\Throwable $th) {
            return redirect()->route('reservas.index')->with('error', 'Hubo un error...');
        }
    }


    public function reservar(Request $request){

       try {
            $hora = $request->input('hora_id');
            $fecha = $request->input('fecha');
            $idUser = $request->user()->id;


            $reservaFind = Reservas::where('fecha', $fecha)->where('horario_id', $hora)->exists();

            if(!$reservaFind){
                $reserva = new Reservas();
                $reserva->user_id = $idUser;
                $reserva->fecha = $fecha;
                $reserva->horario_id = $hora;

                $reserva->save();
            }else{
                return redirect()->route('reservas.index',['fecha'=>$fecha])->with('error', 'Ya existe una reserva de este aula a esta hora');
            }

            return redirect()->route('reservas.index',['fecha'=>$fecha])->with('success', 'Reserva realizada correctamente');

        } catch (\Throwable $th) {
            return redirect()->route('reservas.index')->with('error', 'Hubo un error...');
        }
    }


    public function cancelar(Request $request){

        try {
            $reservaId = $request->input('idReserva', null);
            $idUser = $request->user()->id;

            $reserva = Reservas::find($reservaId);

            if($reserva && $reserva->user_id == $idUser){
                $reserva->delete();
            }

            return redirect()->route('reservas.index',['fecha'=>$reserva->fecha])->with('success', 'Reserva cancelada correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('reservas.index')->with('error', 'Hubo un error...');
        }

    }

}
