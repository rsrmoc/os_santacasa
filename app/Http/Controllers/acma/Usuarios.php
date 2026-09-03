<?php

namespace App\Http\Controllers\acma;

use App\Http\Controllers\Controller;
use App\Models\mv\Funcionario;
use App\Models\mv\Oficina;
use App\Models\mv\UsuariosMv;
use App\Models\Permission;
use App\User;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Throwable;

class Usuarios extends Controller
{
    public function index(Request $request) {
        
        if ($request->has('b')) {
            $usuarios = User::where('name', 'LIKE', "%{$request->b}%")
                ->orWhere('email', 'LIKE', "%{$request->b}%")
                ->get();
        } else {
            $usuarios = User::orderBy('email')->get(); 
        } 
        return view('acma.usuarios.lista', compact('usuarios'));
    }

    public function create() {
        
        $permissoes=Permission::all();  
        $func=Funcionario::whereRaw("sn_ativo='S'")->orderByRaw('nm_func')
        ->selectRaw('cd_func,nm_func')->get();
        $oficina=Oficina::orderByRaw('ds_oficina')
        ->selectRaw('cd_oficina,ds_oficina')->get();
        return view('acma.usuarios.criar',compact('permissoes','func','oficina'));
    }


    public function jsonUsuarioMv(Request $request, $usuario) {

        try { 

            $query=UsuariosMv::find(mb_strtoupper($usuario));  
            if(empty($query)){
                return response()->json(['message' => 'Usuario não encontrado no MV!'], 500);
            }
            return response()->json($query->toArray());

        } catch (Throwable $error) {
            return response()->json(['message' => [$error->getMessage()]], 500);
        }
        
    }

    

    public function store(Request $request) {
 

        $validator = Validator::make($request->post(), [
            'usuario' => 'required|string|max:50|unique:users,email',
            'password' => 'required|string|max:50',
            'nome' => 'required|string|max:100',
            'celular' => 'nullable|string|max:50',
            'sexo' => 'nullable|string|max:1', 
            'email' => 'nullable|email',
            'oficina' => 'required',
            'func' => 'required',
            'permissoes' => 'sometimes|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 500);
        }
 
        $usuario = UsuariosMv::where("cd_usuario",mb_strtoupper($request->usuario))->count();
        if($usuario<=0){
            return response()->json(['message' => 'Usuario não encontrado no MV!'], 500); 
        }

        if (!$request->has('permissoes')) {
            return response()->json(['message' => 'Permissão não informada para o usuario!'], 500); 
        }
          
        try {
 
            $x = DB::transaction(function () use($request) {
       
                $usuario = User::create([ 
                    'name' => $request->nome,
                    'email' => mb_strtoupper($request->usuario), 
                    'email_user' => mb_strtoupper($request->email), 
                    'fone' => $request->celular,
                    'sexo' => $request->sexo,  
                    'cd_oficina' => $request->oficina,
                    'cd_funcionario' => $request->func,
                    'sn_admin' => ($request->sn_admin) ? $request->sn_admin : 'N',
                    'password' => Hash::make($request->password),
                    'user_cadastro' =>   Auth::user()->id,
                    'dt_password' => date('Y-m-d H:i'),
                    'user_password' => Auth::user()->id
                ]);
                $usuario = User::where("email",mb_strtoupper($request->usuario))->first();
                if ($request->has('permissoes')) {
                    foreach ($request->permissoes as $nome => $permissao) {
                        if (!in_array('ver', $permissao)) {
                            array_push($permissao, 'ver');
                        }
 
                        $xx = UserPermission::create([
                            'user' => $usuario->id,
                            'nome' => $nome,
                            'permissoes' => implode(',', $permissao)
                        ]);
                    }
                }
                 
                return $usuario; 
            });
            return $x;
            //return redirect()->route('usuarios-listar')->with('success', 'Novo Usuário cadastrado com sucesso!  ');
        }
        catch(\Exception $e) { 
            return response()->json(['message' => $e->getMessage(),'xx' => $request->permissoes], 500);
        }
    }

    public function edit(User $usuario) {
        $permissoes=Permission::all();
        $func=Funcionario::whereRaw("sn_ativo='S'")->orderByRaw('nm_func')
        ->selectRaw('cd_func,nm_func')->get();
        $oficina=Oficina::orderByRaw('ds_oficina')
        ->selectRaw('cd_oficina,ds_oficina')->get();
        return view('acma.usuarios.editar', compact('usuario','permissoes','func','oficina'));
    }

    public function update(Request $request, User $usuario) {
        $request->validate([
            'usuario' => 'required|string|max:50',
            'password' => 'nullable|string|max:50',
            'nome' => 'required|string|max:100',
            'celular' => 'nullable|string|max:50',
            'sexo' => 'nullable|string|max:1', 
            'email' => 'nullable|email',
            'oficina' => 'required',
            'func' => 'required',
            'permissoes' => 'sometimes|array'
        ]);

        if (User::where('email', $request->usuario)->where('id', '<>', $usuario->id)->first()) {
            return back()->withErrors(['error' => 'Email já está sendo usuado por outro usuário.']);
        }

        $usuarioMv = UsuariosMv::where("cd_usuario",mb_strtoupper($request->usuario))->count();
        if($usuarioMv<=0){
            return back()->withErrors(['error' => 'Usuario não encontrado no MV!']); 
        }

        try {
            DB::transaction(function () use($request, $usuario) {
                
                $usuarioMv = UsuariosMv::where("cd_usuario",mb_strtoupper($usuario->email))->first();
              
                $array=[
                    'name' => $usuarioMv->nm_usuario, 
                    'email_user' => mb_strtolower($request->email), 
                    'fone' => $request->celular,
                    'sexo' => $request->sexo,  
                    'cd_oficina' => $request->oficina,
                    'cd_funcionario' => $request->func,
                    'sn_admin' => ($request->sn_admin) ? $request->sn_admin : 'N', 
                ];
                if($request->password){
                    $array['password'] = Hash::make($request->password);
                    $array['dt_password'] = date('Y-m-d H:i');
                    $array['user_password'] = Auth::user()->id;

                }
                $usuario->update($array);


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
          
        try { 
            DB::transaction(function () use($usuario) { 
                UserPermission::where('user',$usuario->id)->delete();
                $usuario->delete(); 
            });
        }
        catch(\Exception $e) { abort(500); }
    }
}
