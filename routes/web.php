<?php

use App\Http\Controllers\acma\AuthController;
use App\Http\Controllers\acma\BoletoHistorico;
use App\Http\Controllers\acma\Chamados;
use App\Http\Controllers\acma\Clientes;
use App\Http\Controllers\acma\HistoricoClienteController;
use App\Http\Controllers\acma\Inicio;
use App\Http\Controllers\acma\NegociacaoBoletoController;
use App\Http\Controllers\acma\NegociacoesController;
use App\Http\Controllers\acma\Usuarios;
use App\Http\Middleware\UserPermissions;
use Illuminate\Support\Facades\Route;

//Route::get('/', [Inicio::class,  'cadastro']);
route::get('/', [AuthController::class, 'login'])->name('login-action')->middleware('guest');

Route::get('/login', [Inicio::class, 'login'])->name('login')->middleware('guest');
route::post('/login', [AuthController::class, 'login'])->name('login-action')->middleware('guest');

Route::group([
    'prefix' => 'acma',
    'middleware' => ['auth', UserPermissions::class]
], function() {

    Route::get('/', [Inicio::class, 'home'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/usuarios', [Usuarios::class, 'index'])->name('usuarios-listar');
    Route::get('/usuarios-criar', [Usuarios::class, 'create'])->name('usuarios-criar');
    Route::post('/usuarios-store', [Usuarios::class, 'store'])->name('usuarios-store');
    Route::get('/usuarios-editar/{usuario}', [Usuarios::class, 'edit'])->name('usuarios-editar');
    Route::post('/usuarios-update/{usuario}', [Usuarios::class, 'update'])->name('usuarios-update');
    Route::delete('/usuarios-delete/{usuario}', [Usuarios::class, 'destroy'])->name('usuarios-destroy');

    /* Chamados */
    Route::get('/chamados', [Chamados::class, 'chamados'])->name('chamados-listar');
    Route::get('/chamados-suporte', [Chamados::class, 'suporte'])->name('chamados-suporte');
    Route::get('/chamados-projetos', [Chamados::class, 'projetos'])->name('chamados-projetos');
    Route::get('/controle-json', [Chamados::class, 'json'])->name('controle-json');


    Route::group([
        'prefix' => 'json'
    ], function() {

        /* Usuario */
        Route::get('usuario-mv/{usuario}', [Usuarios::class, 'jsonUsuarioMv']);
        Route::post('usuario-store', [Usuarios::class, 'store']);


        /* Home */
        Route::post('home-json', [Inicio::class, 'json']);

        /* Chamados */
        Route::post('chamados-json', [Chamados::class, 'json']);
        Route::post('chamados-classicacao', [Chamados::class, 'json_classicacao']);
        Route::post('chamados-aprazar', [Chamados::class, 'json_aprazamento']);
        Route::post('chamados-obs', [Chamados::class, 'json_obs']);
        Route::post('chamados-servico', [Chamados::class, 'json_servico']);
        Route::post('chamados-servico/cancelar/{id}', [Chamados::class, 'json_servico_cancelar']);
        Route::post('chamados-servico/reabrir/{id}', [Chamados::class, 'json_servico_reabrir']);
        Route::post('chamados-servico/fechar/{id}', [Chamados::class, 'json_servico_fechar']);
        Route::post('chamados-os-suporte', [Chamados::class, 'json_os_suporte']);
        Route::post('chamados-andamentos', [Chamados::class, 'json_os_andamentos']);
        Route::post('chamados-servico/finalizar/{id}', [Chamados::class, 'json_finalizar']);
        Route::post('chamados-header/{tela}', [Chamados::class, 'json_header']);



    });
});
