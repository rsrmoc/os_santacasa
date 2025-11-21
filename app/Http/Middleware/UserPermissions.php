<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class UserPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $usuario = Auth::user();

        if ($usuario->admin) return $next($request);

        $verificarRotas = ['usuarios', 'setores'];

        $rotaAtual = Route::currentRouteName();
        $permissaoRota = substr(Route::currentRouteName(), 0, strpos(Route::currentRouteName(), "-") === false ? null : strpos(Route::currentRouteName(), "-"));

        if (in_array($permissaoRota, $verificarRotas) || $usuario->existPermissao($permissaoRota)) {
            
            if (str_ends_with($rotaAtual, "listar") && !$usuario->isPermissao($permissaoRota, 'ver')) {
                return redirect()->route('home')->withErrors(['error' => 'Você não tem permissão de acesso!']);
            }

            if ((str_ends_with($rotaAtual, "criar") || str_ends_with($rotaAtual, "store") ||
                str_ends_with($rotaAtual, "editar") || str_ends_with($rotaAtual, "update")) &&
                !$usuario->isPermissao($permissaoRota, 'criar'))
            {
                return redirect()->route('home')->withErrors(['error' => 'Você não tem permissão de acesso!']);
            }

            if ((str_contains($rotaAtual, "excluir") || str_contains($rotaAtual, "destroy")) && !$usuario->isPermissao($permissaoRota, 'excluir')) {
                return redirect()->route('home')->withErrors(['error' => 'Você não tem permissão de acesso!']);
            }
        }

        return $next($request);
    }
}
