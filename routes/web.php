<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\Maps\EnlaceController;
use App\Http\Controllers\Maps\MedicionController;
use App\Http\Controllers\Maps\EstructuraController;
use App\Http\Controllers\Maps\DetalleController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GerenciaController;




//MODULO DE MAPAS
    //GET
        //LOGIN
            Route::get('/modulos/maps', [EnlaceController::class, 'index'])->middleware('auth.login')->name('mod-maps');      //INICIO DE MAPAS

        //LEVEL1
            Route::get('/modulos/maps/enlace/ver',[EnlaceController::class, 'ver'])->middleware('auth.level1')->name('enlace-ver'); //VER LOS ENLACES
            Route::get('/modulos/maps/enlace/mostrarResumen/enlace{id}',[EstructuraController::class, 'mostrarEnlaceResumen'])->middleware('auth.level1')->name('estructura-enlace-resumen'); //VER LOS DATOS DE UN ENLACE
            Route::get('/modulos/maps/mediciones/toma', [MedicionController::class, 'tomarMediciones'])->middleware('auth.level1')->name('mediciones-tomar'); //TOMAR LAS MEDICIONES PARA LAS LINEAS DE ENLACE
            Route::get('/modulos/maps/mediciones/ver', [MedicionController::class, 'index'])->middleware('auth.level1')->name('medicion-ver'); //VER LAS MEDICIONES DE LAS DIFERENTES LINEAS DE ENLACE
            Route::get('/modulos/maps/mediciones/toma/detalles{id}',[MedicionController::class, 'detallar'])->middleware('auth.level1')->name('medicion-detallar'); //VER DETALLES DE LAS MEDICIONES
            Route::get('/modulos/maps/mediciones/ver/medicion{id}',[MedicionController::class, 'detalles'])->middleware('auth.level1')->name('mediciones-detalles'); //Ver las mediciones
            Route::get('/modulos/maps/ubicaciones/ver',[UbicacionController::class, 'index'])->middleware('auth.level1')->name('ubicaciones-ver'); //VER LA LISTA DE LAS UBICACIONES
            Route::get('/modulos/maps/ubicaciones/ver/detalle{id}',[UbicacionController::class, 'verDetalle'])->middleware('auth.level1')->name('ubicaciones-ver-detalle'); //VER LOS DETALLES DE UNA UBICACION
            Route::get('/modulos/estadosTabla',[EnlaceController::class, 'verTabla'])->middleware('auth.level1')->name('enlaces-tabla');
            Route::post('/modulos/maps/estructura/agregar/{id}', [EstructuraController::class, 'agregarEstructuras'])->name('estructura-agregar');//AGREGAR ELE EXCEL Y LEERLO DE MANERA AUTOMATICA
            


        //LEVEL2
            Route::get('/modulos/maps/enlace/crear/agregarEstructuras{id}', [EstructuraController::class, 'mostrarAgregar'])->middleware('auth.level2')->name('estructuras-agregar-pantalla'); //AGREGAR ESTRUCTURAS A UN ENLACE YA CREADO
            Route::get('/modulos/maps/enlace/crear/agregarEstructuras/modificar{id}', [EstructuraController::class, 'modificarEstructuras'])->middleware('auth.level2')->name("estructuras-modificar"); //MODIFICAR UNA ESTRUCTURA YA CREADA
            Route::get('/modulos/maps/mediciones/modificar/medicion{id}',[MedicionController::class, 'mostrarModificar'])->middleware('auth.level2')->name('medicion-mostrar-modificar'); //MOSTRAR LAS MODIFICACIONES DE LAS MEDICIONES
            Route::get('/modulos/maps/ubicaciones/crearNuevo',[UbicacionController::class, 'verCreate'])->middleware('auth.level2')->name('ubicaciones-ver-crear'); //MOSTRAR LA CREACION DE UNA NUEVA UBICACION
            Route::get('/modulos/maps/ubicaciones/modificar{id}',[UbicacionController::class, 'modificarUbicacion'])->middleware('auth.level2')->name('ubicacion-ver-modificar'); //MOSTRAR LA MODIFICACION DE LAS UBICACIONES
            Route::get('/modulos/maps/detalles/modificar/medicion{id}',[DetalleController::class, 'modificarDetalle'])->middleware('auth.level2')->name('detalle-modificar');
            


        //LEVEL3
            Route::get('/modulos/maps/enlace/crear', [EnlaceController::class, 'crear'])->middleware('auth.level3')->name('enlace-crear');     //ENLACE A CREAR
            Route::get('/modulos/maps/enlace/modificar{id}',[EnlaceController::class, 'verModificar'])->middleware('auth.level3')->name('enlace-verModificar'); //MODIFICAR UN ENLACE EN BASE A SU ID
            Route::get('/modulos/maps/enlace/crear/atenuacionIdeal{id}', [EnlaceController::class, 'atenuacionIdeal'])->middleware('auth.level3')->name('enlace-atenuacion'); //Atenuacion ideal en el enlace
            Route::get('/modulos/maps/enlace/crear/estrucutras/decision',[EnlaceController::class, 'decision'])->middleware('auth.level3')->name('enlace.decision');
            Route::get('/modulos/maps/enlace/crear/estructuras/decision/kmz{id}', [EnlaceController::class, 'decisionKMZ'])->middleware('auth.level2')->name('enlace.decision.kmz');






    //PUT
        //LOGIN
        //LEVEL1

        //LEVEL2
            Route::put('/modulos/maps/enlace/crear/agregarEstructuras{id}', [EnlaceController::class, 'modificarEnlace'])->middleware('auth.level2')->name('enlace-agregar-modificar-conectores');
            Route::put('/modulos/maps/enlace/crear/agregarEstructuras/modificar{id}',[EstructuraController::class, 'reescribirEstructuras'])->middleware('auth.level2')->name('estructuras-edit');
            Route::put('/modulos/maps/mediciones/modificar{id}',[MedicionController::class, 'modificarMediciones'])->middleware('auth.level2')->name('mediciones-modificar');
            Route::put('/modulos/maps/ubicaciones/modificar{id}', [UbicacionController::class, 'reescribirUbicacion'])->middleware('auth.level2')->name('ubicacion-modificar');
            Route::put('/modulos/maps/detalles/modificar',[DetalleController::class, 'update'])->middleware('auth.level2')->name('detalle-reescribir');
        //LEVEL3
            Route::put('/modulos/maps/enlace/modficar{id}',[EnlaceController::class, 'reescribirEnlace'])->middleware('auth.level3')->name('enlace-modificar');


    //POST
        //LOGIN
        //LEVEL1
            Route::post('/modulos/maps/mediciones/toma', [MedicionController::class, 'create'])->middleware('auth.level1')->name('medicion-tomar');
            Route::post('/modulos/maps/mediciones/toma/fibras',[DetalleController::class, 'create'])->middleware('auth.level1')->name('detalle-crear');
        //LEVEL2
            Route::post('/modulos/maps/enlace/crear/agregarEstructuras{id}', [EstructuraController::class, 'agregarEstructuras'])->middleware('auth.level2')->name('estructuras-añadir');
            Route::post('/modulos/maps/ubicaciones/crear/nuevo',[UbicacionController::class, 'create'])->middleware('auth.level2')->name('ubicaciones-crear');
        //LEVEL3
            Route::post('/modulos/maps/enlace/crear',[EnlaceController::class, 'create'])->middleware('auth.level3')->name('enlace-añadir');
            Route::post('/modulos/maps/enlace/crear/decision/kmz{id}', [EnlaceController::class, 'leerKMZL'])->name('enlace-leer-kmz');
        
        
            
    //DELETE
        //LOGIN
            Route::delete('/',[SessionController::class, 'destroy'])->name('logout');
            Route::delete('/modulos/maps/enlace/eliminarMedicion{id}',[MedicionController::class, 'preDestroy'])->middleware('auth.level1')->name('medicion-cancelar');
            Route::delete('/modulos/maps/enlace/eliminarEnlace{id}',[EnlaceController::class, 'preDestroy'])->middleware('auth.level1')->name('enlace-preEliminar');
        //LEVEL1
        //LEVEL2
            Route::delete("/modulos/maps/enlace/estructuras/eliminar{id}",[EstructuraController::class, 'destroy'])->middleware('auth.level2')->name('estructuras-eliminar');
            
        //LEVEL3        
            Route::delete("/modulos/maps/enlace/eliminar{id}",[EnlaceController::class, 'destroy'])->middleware('auth.level3')->name('enlace-eliminar');
            Route::delete("/modulos/maps/ubicaciones/eliminar{id}",[UbicacionController::class, 'destroy'])->middleware('auth.level3')->name('ubicaciones-eliminar');
            Route::delete("/modulos/maps/mediciones/eliminar{id}", [MedicionController::class, 'destroy'])->middleware('auth.level3')->name('medicion-eliminar');



//GENERAL

    //Get
        //LOGIN
            Route::get('/',[SessionController::class, 'index'])->name('inicio-app');//INICIO DE LA PAGINA WEB
            Route::get('/modulos/usuarios/ver',[UserController::class, 'index'])->middleware('auth.login')->name('users-ver');
            Route::get('/modulos/gerenciasYzonas', [GerenciaController::class, 'index'])->middleware('auth.login')->name('gerencia-ver');
            Route::get('/modulos',[SessionController::class, 'modulos'])->middleware('auth.login')->name('mod-app');//INICIO DE LOS MODULOS
            

        //LEVEL1
        //LEVEL2
        //LEVEL3
            Route::get('/modulos/usuarios/crear',[UserController::class, 'create'])->middleware('auth.level3')->name('users-create');
            Route::get('/modulos/usuarios/modificar{id}', [UserController::class, 'verModificarUsuario'])->middleware('auth.level3')->name('users-ver-modificar');


    //Post
        Route::post('/',[SessionController::class, 'login'])->name('login-app');           //INICIO DE SESION
        //LOGIN
        //LEVEL1
        //LEVEL2
        //LEVEL3
            Route::post('/modulos/usuarios/crear/nuevoUsuario', [UserController::class, 'agregarUsuario'])->middleware('auth.level3')->name('users-agregar');
    //DELETE
        //LOGIN
        //LEVEL1
        //LEVEL2
        //LEVEL3
            Route::delete('/modulos/usuarios/eliminar/usuario{id}',[UserController::class, 'eliminarUsuario'])->middleware('auth.level3')->name('users-delete');

    //PUT
        //LOGIN
        //LEVEL1
        //LEVEL2
            Route::put('/modulos/usuarios/modificar/usuario{id}', [UserController::class, 'modificarUsuario'])->middleware('auth.level2')->name('users-modificar');
        //LEVEL3


