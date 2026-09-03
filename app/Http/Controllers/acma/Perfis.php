<?php

namespace App\Http\Controllers\acma;

use App\Http\Controllers\Controller;
use App\Models\Perfil;
use App\Models\Permission;
use App\User;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Perfis extends Controller
{
    public function index(Request $request) {
        
        if ($request->has('b')) {
            $perfil = Perfil::where('nm_perfil', 'LIKE', "%{$request->b}%")
                ->orWhere('cd_perfil', 'LIKE', "%{$request->b}%")
                ->get();
        } else {
            $perfil = Perfil::all(); 
        }

        return view('brcondos_adv.perfil.lista', compact('perfil'));
    }

    public function create() {
        
        $permissoes=Permission::all();
        return view('brcondos_adv.usuarios.criar',compact('permissoes'));
    }

    public function store(Request $request) {
        $request->validate([
            'nome' => 'required|string|max:50',
            'celular' => 'nullable|string|max:50',
            'sexo' => 'nullable|string|max:1',
            'perfil' => 'nullable|int|max:10',
            'email' => 'required|email|unique:users,email',
            'permissoes' => 'sometimes|array'
        ]);

        try {
            DB::transaction(function () use($request) {
                //$Senha =explode('@',$request->email);
                //$Senha = mb_strtolower($Senha[0]);
                $usuario = User::create([
                    'name' => $request->nome,
                    'email' => $request->email,
                    'cd_perfil' => $request->perfil,
                    'fone' => $request->celular,
                    'sexo' => $request->sexo,
                    'password' => Hash::make('12345678')
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

            return redirect()->route('usuarios-listar')->with('success', 'Novo Usuário cadastrado com sucesso!  ');
        }
        catch(\Exception $e) {
            return back()->withErrors(['error' => 'Houve um erro ao salvar o usuário! '.$e->getMessage()])->withInput();
        }
    }

    public function edit(User $usuario) {
        $permissoes=Permission::all();
        return view('brcondos_adv.usuarios.editar', compact('usuario','permissoes'));
    }

    public function update(Request $request, User $usuario) {
        $request->validate([
            'nome' => 'required|string|max:50',
            'email' => 'required|email',
            'celular' => 'nullable|string|max:50',
            'sexo' => 'nullable|string|max:1',
            'perfil' => 'nullable|int|max:10',
            'permissoes' => 'sometimes|array'
        ]);

        if (User::where('email', $request->email)->where('id', '<>', $usuario->id)->first()) {
            return back()->withErrors(['error' => 'Email já está sendo usuado por outro usuário.']);
        }

        try {
            DB::transaction(function () use($request, $usuario) {
                $usuario->update([
                    'name' => $request->nome,
                    'email' => $request->email,
                    'cd_perfil' => $request->perfil,
                    'fone' => $request->celular,  
                    'sexo' => $request->sexo, 
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
