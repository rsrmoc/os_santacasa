<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\brcondos_adv\BoletoHistorico;
use App\Http\Controllers\brcondos_adv\Bot;
use App\Http\Controllers\brcondos_adv\Clientes;
use App\Http\Controllers\brcondos_adv\Condominios;
use App\Http\Controllers\brcondos_adv\Controle;
use App\Http\Controllers\brcondos_adv\HistoricoClienteController;
use App\Http\Controllers\brcondos_adv\Inicio;
use App\Http\Controllers\brcondos_adv\Integracoes;
use App\Http\Controllers\brcondos_adv\NegociacaoBoletoController;
use App\Http\Controllers\brcondos_adv\NegociacoesController;
use App\Http\Controllers\brcondos_adv\Negociacoes;
use App\Http\Controllers\brcondos_adv\Perfis;
use App\Http\Controllers\brcondos_adv\Usuarios;
use App\Http\Controllers\UsuariosController;
use App\Http\Middleware\UserPermissions;
use App\Models\Perfil;
use Illuminate\Support\Facades\Route;

//Route::get('/', [Inicio::class,  'cadastro']);
route::get('/', [AuthController::class, 'login'])->name('login-action')->middleware('guest');

Route::get('/bot', [Inicio::class,  'bot']);
Route::get('/bot_pag', [Inicio::class,  'bot_pag']);
Route::get('/login', [Inicio::class, 'login'])->name('login')->middleware('guest');
route::post('/login', [AuthController::class, 'login'])->name('login-action')->middleware('guest');

Route::group([
    'prefix' => 'brcondos_adv',
    'middleware' => ['auth', UserPermissions::class]
], function() {

    Route::get('/', [Inicio::class, 'home'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('/perfis', [Perfis::class, 'index'])->name('perfis-listar');
    Route::get('/perfis-criar', [Perfis::class, 'create'])->name('perfis-criar');
    Route::post('/perfis-store', [Perfis::class, 'store'])->name('perfis-store');
    Route::get('/perfis-editar/{perfil}', [Perfis::class, 'edit'])->name('perfis-editar');
    Route::post('/perfis-update/{perfil}', [Perfis::class, 'update'])->name('perfis-update');
    Route::get('/perfis-delete/{perfil}', [Perfis::class, 'destroy'])->name('perfis-destroy');


    Route::get('/bot', [Bot::class, 'rotina'])->name('bot-rotina');
    Route::get('/usuarios', [Usuarios::class, 'index'])->name('usuarios-listar');
    Route::get('/usuarios-criar', [Usuarios::class, 'create'])->name('usuarios-criar');
    Route::post('/usuarios-store', [Usuarios::class, 'store'])->name('usuarios-store');
    Route::get('/usuarios-editar/{usuario}', [Usuarios::class, 'edit'])->name('usuarios-editar');
    Route::post('/usuarios-update/{usuario}', [Usuarios::class, 'update'])->name('usuarios-update');
    Route::get('/usuarios-delete/{usuario}', [Usuarios::class, 'destroy'])->name('usuarios-destroy');


    Route::get('/condominios', [Condominios::class, 'lista'])->name('condominios-listar');
    Route::get('/condominios-criar', [Condominios::class, 'create'])->name('condominios-criar');
    Route::post('/condominios-store', [Condominios::class, 'store'])->name('condominios-store');
    Route::get('/condominios-editar/{condominio}', [Condominios::class, 'edit'])->name('condominios-editar');
    Route::post('/condominios-update/{condominio}', [Condominios::class, 'update'])->name('condominios-update');
    Route::get('/condominios-delete/{condominio}', [Condominios::class, 'destroy'])->name('condominios-destroy');

    Route::get('/integracoes-con-rec', [Integracoes::class, 'lista_rec'])->name('integracoes-con-rec');
    Route::post('/integracoes-rec-store', [Integracoes::class, 'store_rec'])->name('integracoes-rec-store');
    Route::get('/integracoes-con-pag', [Integracoes::class, 'lista_pag'])->name('integracoes-con-pag');
    Route::post('/integracoes-pag-store', [Integracoes::class, 'store_pag'])->name('integracoes-pag-store');

    /* Boletos */
    Route::get('/controle', [Controle::class, 'lista'])->name('controle-listar');
    Route::get('/controle-json', [Controle::class, 'json'])->name('controle-json');
    Route::get('/controle-historico-json/{cd_boleto}', [BoletoHistorico::class, 'index'])->name('controle-historico-json');
    Route::post('/controle-historico-json', [BoletoHistorico::class, 'store'])->name('controle-historico-json-store');
    Route::delete('/controle-historico-json/{cd_boleto_hist}', [BoletoHistorico::class, 'destroy'])->name('controle-historico-json-destroy');

    Route::get('/setores', [UsuariosController::class, 'index'])->name('setores-listar');
    
    /* Clientes */
    Route::get('/clientes', [Clientes::class, 'lista'])->name('clientes-listar');
    Route::get('/clientes-json', [Clientes::class, 'json'])->name('clientes-json');
    
    /* Negociações */
    Route::get('/negociacoes', [NegociacoesController::class, 'lista'])->name('negociacoes-listar');
    Route::get('/negociacoes-json', [NegociacoesController::class, 'json'])->name('negociacoes-json');
    Route::get('/boleto-negoc-json', [NegociacoesController::class, 'jsonNegBoleto'])->name('boleto-negoc-json');
    Route::post('/boleto-negoc-store', [NegociacoesController::class, 'storeNegBoleto'])->name('boleto-negoc-store');
    
    Route::group([
        'prefix' => 'json'
    ], function() {

        Route::get('clientes-boletos-abertos', [Clientes::class, 'jsonBoletosAbertos']);
        Route::post('negociacao', [NegociacoesController::class, 'createJson']);
        Route::put('negociacao', [NegociacoesController::class, 'updateJson']);
        Route::delete('negociacao/{cdNegociacao}', [NegociacoesController::class, 'deleteJson']);

        Route::post('negociacao-boleto', [NegociacaoBoletoController::class, 'createJson']);
        Route::delete('negociacao-boleto/{negociacaoBoleto}', [NegociacaoBoletoController::class, 'deleteJson']);

        Route::post('historico-cliente', [HistoricoClienteController::class, 'storeJson']);
        Route::put('historico-cliente', [HistoricoClienteController::class, 'updateJson']);
        Route::delete('historico-cliente/{negociacaoBoleto}', [HistoricoClienteController::class, 'destroyJson']);

    });
});
