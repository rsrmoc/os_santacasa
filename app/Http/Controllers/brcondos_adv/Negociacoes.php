<?php

namespace App\Http\Controllers\brcondos_adv;

use App\Http\Controllers\Controller;
use App\Models\Boleto;
use App\Models\BoletoHistorico;
use App\Models\Condominio;
use App\Models\Hospital;
use App\Models\Produto;
use App\Models\Tabela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class Negociacoes extends Controller
{
    public function lista(Request $request) {

        try {

            $tabelas = Tabela::where('sn_ativo','S')->orderByRaw("tp_tabela,campo")->get(); 
              
            $condominios = Condominio::orderBy('nm_condominio')->orderBy('nm_condominio')->get();
            return view('brcondos_adv.negociacoes.lista', compact('condominios','tabelas','request'));
        }
        catch(\Exception $e) {
            return back()->withErrors(['error' => 'Houve um erro ao atualizar a Rotina! '.$e->getMessage()])->withInput();
        }

    }

    public function json(Request $request) {
        
        $query= Boleto::Search($request)->paginate(30)->appends($request->query());

        $pagination['pag_atual'] = $query->toArray()['current_page'];
        $pagination['pagina_um'] = $query->toArray()['first_page_url'];
        $pagination['ultima_pagina'] = $query->toArray()['last_page'];
        $pagination['ultima_pagina_url'] = $query->toArray()['last_page_url'];
        $pagination['prox_pagina_url'] = $query->toArray()['next_page_url'];
        $pagination['linha_pagina'] = $query->toArray()['per_page'];
        $pagination['pagina_anterior_url'] = $query->toArray()['prev_page_url'];
        $pagination['total'] = $query->toArray()['total'];
        $pagination['de'] = $query->toArray()['from'];
        $pagination['ate'] = $query->toArray()['to'];  
        $page =  PAGINACAO_HTML($pagination); 

        $return['dados']=$query;
        $return['pagination']=$page;  
        return response()->json($return);
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
