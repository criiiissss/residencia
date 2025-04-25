<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function index(){
        $usuarios = User::all();

        return view('web.mod.usuarios.users',compact('usuarios'));
    }

    public function create(){
        $niveles = ['level1','level2','level3'];
        return view('web.mod.usuarios.crearUsers',compact('niveles'));
    }

    public function agregarUsuario(Request $request){
        $nuevoUsuario = new User();
        $nuevoUsuario->name = $request->name;
        $nuevoUsuario->apellido = $request->apellidos;
        $nuevoUsuario->rpe = $request->rpe;
        $nuevoUsuario->email = $request->email;
        $nuevoUsuario->rol = $request->rol;
        $nuevoUsuario->password = $request->password;
        $nuevoUsuario->save(); 
        return redirect(route('users-ver'));
    }

    public function verModificarUsuario($id){
        $Usuario = User::findorfail($id);
        $niveles = ['level1','level2','level3'];
        return view('web.mod.usuarios.modificarUser',compact('Usuario','niveles'));
    }

    public function modificarUsuario($id, Request $request){
        $Usuario = User::findorfail($id);
        $Usuario->name = $request->name;
        $Usuario->apellido = $request->apellido;
        $Usuario->rpe = $request->rpe;
        $Usuario->email = $request->email;
        $Usuario->rol = $request->rol;

        if($request->password != ""){
            $Usuario->password = $request->password;
        }
        else{
            $Usuario->password = $Usuario->password;
        }

        $Usuario->save();
        return redirect(route('users-ver'));

    }

    public function eliminarUsuario($id){
        $Usuario = User::findorfail($id);
        $Usuario->delete();
        return redirect(route('users-ver'));
    }
}
