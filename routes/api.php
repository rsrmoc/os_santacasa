<?php

use App\Http\Controllers\Api\CadastroController;
use App\Http\Controllers\Api\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::get('produto-pesquisa', [ProdutoController::class, 'search']);
Route::post('cadastro', [CadastroController::class, 'store']);
