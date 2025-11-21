<?php

namespace App\Http\Controllers\brcondos_adv;

use App\Http\Controllers\Controller;
use App\Models\Boleto;
use App\Models\Condominio;
use App\Models\Hospital;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Condominios extends Controller
{
    public function lista(Request $request) {

        if ($request->has('b')) {
            $condominios = Condominio::where('nm_condominio', 'LIKE', "%{$request->b}%")
                ->orWhere('cd_condominio', 'LIKE', "%{$request->b}%")
                ->orderBy('nm_condominio')
                ->paginate(25)->appends($request->query());
        } else {
            $condominios = Condominio::orderBy('nm_condominio')->paginate(25)->appends($request->query());
        }

        return view('brcondos_adv.condominios.lista', compact('condominios'));

    }

    public function create() {
        return view('brcondos_adv.condominios.add');
    }
 
    public function store(Request $request) {
        $request->validate([
            'nm_condominio' => 'required|string|max:200',
            'cd_condominio' => 'nullable|int' 
        ]);
        
        try {
           $retorno= DB::transaction(function () use($request) {
              
                return Condominio::create([
                    'nm_condominio' => $request->nm_condominio,
                    'sn_ativo' => 'S',
                    'cd_condominio' => $request->cd_condominio
                ]);

            }); 

            return redirect()->route('condominios-listar')->with('success', 'Condominio atualizado com sucesso!');
        }
        catch(\Exception $e) {
            return back()->withErrors(['error' => 'Houve um erro ao atualizar o condominio! '.$e->getMessage()])->withInput();
        }
    }
    public function edit(Condominio $condominio) {
        return view('brcondos_adv.condominios.edit', compact('condominio'));
    }
    public function update(Request $request,Condominio $condominio) {
        
        $request->validate([
            'nm_condominio' => 'required|string|max:200',
            'cd_condominio' => 'nullable|int' 
        ]);

        try {

           $retorno = DB::transaction(function () use($request,$condominio) {
              
                return $condominio->update([
                    'nm_condominio'=> $request->nm_condominio,
                    'cd_condominio'=> $request->cd_condominio,
                    'sn_ativo'=> ($request['ativo']=='N')?'N':'S' 
                ]);

            }); 

            return redirect()->route('condominios-listar')->with('success', 'Condominio atualizado com sucesso!');

        }
        catch(\Exception $e) {
            return back()->withErrors(['error' => 'Houve um erro ao atualizar o condominio! '.$e->getMessage()])->withInput();
        }

    }
    public function destroy(Condominio $condominio) { 
        try { $condominio->delete(); }
        catch(\Exception $e) { abort(500); }
    }
    
}
