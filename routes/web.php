<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\firebase\usuarioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\firebase\FirebaseUserController;

use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('login');
});

//Rutas del login
Route::post('registrarUsuario', [usuarioController::class,'store']);
Route::post('logeo', [usuarioController::class,'login']);

//Rutas de login redes sociales
//google
Route::get('/login-google', function () { 
    return Socialite::driver('google') ->scopes(['openid', 'profile', 'email'])->redirect();
});
Route::get('/google-callback', [usuarioController::class,'procesamientoGoogle']);
//facebook
Route::get('/login-github', function () {
    return Socialite::driver('github')->redirect();
});
Route::get('/github-callback', [usuarioController::class,'procesamientoGithub']);

use App\Http\Controllers\GoogleLoginController;

Route::get('auth/google', [usuarioController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [usuarioController::class, 'handleGoogleCallback'])->name('auth.callback');




//URLS PRUEBAS FIREBASE
Route::get('usuarios', [usuarioController::class,'index']);
Route::get('aggUsuario', [usuarioController::class,'create']);
Route::post('aggUsuario', [usuarioController::class,'store']);
Route::get('updUsuario/{id}', [usuarioController::class,'update']);
Route::put('upUsuario/{id}',[usuarioController::class,'save']);
Route::get('delUsuario/{id}', [usuarioController::class,'delete']);

Route::get('/firebase-users', [usuarioController::class, 'index']);

Route::get('/listaUsuarios', function (){
    return view('pages/adminPages/listaUsuarios');
})->name('lista.usuarios');


Route::get('/login', function () {
    return view('login');
});


//RUTAS LOCATARIO
Route::get('/homepage', function () {
    return view('pages.homePage'); // Asegúrate de que la vista exista
})->name('homePage');

Route::get('/registroLocal', function () { 
    return view('pages/registroTienda');
});

Route::get('/aggCat', function () { 
    return view('pages/aggCategoria');
});

Route::get('/registro', [CategoriaController::class, 'listarCategorias'])->name('categorias.list');

Route::get('categorias', [CategoriaController::class, 'listarCategorias2'])->name('categorias.store');

Route::get('editarCategoria/{id}', [CategoriaController::class, 'editarCategoria'])->name('categoria.editar');

Route::post('editarCategoria/{id}', [CategoriaController::class, 'editarCategoria'])->name('categoria.edit');

Route::get('/editarCat', function () { 
    return view('pages.adminPages.editarCategoria');
});

Route::post('registroTienda', [CategoriaController::class, 'agregarNuevaSubcategoria'])->name('categorias.subcat');

Route::get('/admin', function () { 
    return view('pages/adminPages/homePageAdm');
});