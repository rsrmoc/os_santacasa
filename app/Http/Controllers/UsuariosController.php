<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuariosController extends Controller
{
    public function index(Request $request) {
        
        if ($request->has('b')) {
            $usuarios = User::where('name', 'LIKE', "%{$request->b}%")
                ->orWhere('email', 'LIKE', "%{$request->b}%")
                ->get();
        } else {
            $usuarios = User::all();
        }

        return view('home.usuarios.lista', compact('usuarios'));
    }

    public function create() {
        return view('home.usuarios.criar');
    }

    public function store(Request $request) {
        $request->validate([
            'nome' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'permissoes' => 'sometimes|array'
        ]);

        try {
            DB::transaction(function () use($request) {
                $usuario = User::create([
                    'name' => $request->nome,
                    'email' => $request->email,
                    'password' => Hash::make('password')
                ]);

                if ($request->has('permissoes')) {
                    foreach ($request->permissoes as $nome => $permissao) {
                        if (!in_array('ver', $permissao)) {
                            array_push($permissao, 'ver');
                        }

                        UserPermission::create([
                            'user' => $usuario->id,
                            'nome' => $nome,
                            'permissoes' => implode(',', $permissao)
                        ]);
                    }
                }
            });

            return redirect()->route('usuarios-listar')->with('success', 'Novo usuário cadastrado com sucesso!');
        }
        catch(\Exception $e) {
            return back()->withErrors(['error' => 'Houve um erro ao salvar o usuário! '.$e->getMessage()])->withInput();
        }
    }

    public function edit(User $usuario) {
        return view('home.usuarios.editar', compact('usuario'));
    }

    public function update(Request $request, User $usuario) {
        $request->validate([
            'nome' => 'required|string|max:50',
            'email' => 'required|email',
            'permissoes' => 'sometimes|array'
        ]);

        if (User::where('email', $request->email)->where('id', '<>', $usuario->id)->first()) {
            return back()->withErrors(['error' => 'Email já está sendo usuado por outro usuário.']);
        }

        try {
            DB::transaction(function () use($request, $usuario) {
                $usuario->update([
                    'name' => $request->nome,
                    'email' => $request->email
                ]);


                foreach (($request->permissoes ?? []) as $nome => $permissao) {
                    if (!in_array('ver', $permissao)) {
                        array_push($permissao, 'ver');
                    }

                    UserPermission::updateOrCreate(
                        [ 'user' => $usuario->id, 'nome' => $nome ],
                        [ 'permissoes' => implode(',', $permissao) ]
                    );
                }

                $excluidas = array_diff(array_column($usuario->permissoes->toArray(), "nome"), array_keys($request->permissoes ?? []));

                foreach ($excluidas as $nome) {
                    UserPermission::firstWhere(['nome' => $nome, 'user' => $usuario->id])->delete();
                }
            });

            return redirect()->route('usuarios-listar')->with('success', 'Usuário atualizado com sucesso!');
        }
        catch(\Exception $e) {
            return back()->withErrors(['error' => 'Houve um erro ao atualizar o usuário! '.$e->getMessage()])->withInput();
        }
    }

    public function destroy(User $usuario) {
        try { $usuario->delete(); }
        catch(\Exception $e) { abort(500); }
    }
}
