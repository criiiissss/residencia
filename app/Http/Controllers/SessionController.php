<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Maps\Enlace;
use App\Models\Ubicacion;
use App\Models\Maps\EnlaceUbicacion;

class SessionController extends Controller
{
    //
    public function index(){
        return view('web.home');
    }

    public function login(){
        if(auth()->attempt(request(['rpe','password']))==false){
            return back()->withErrors(['message' => 'El R.P.E o la contraseña son incorrectos']);
        }
        else{
            return redirect(route('mod-app'));
        }
    }

    public function modulos(){
        //TODOS LOS ENLACES CON SUS ESTRUCTURAS Y SUS ULTIMAS MEDICIONES

        $enlace = Enlace::with('ubicaciones','enlaces','medic')->get();
        $ubicacion = Ubicacion::with('enlaces')->get();


        $ubicacionSoloA = EnlaceUbicacion::where('punta','a')->with('enlace.medic','ubicacion')->get();

        //FALTA LA MEDICION
        

        return view('web.mod.main', compact('enlace','ubicacion','ubicacionSoloA'));
    }
   
    
    public function destroy(){
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/');
    }
}
