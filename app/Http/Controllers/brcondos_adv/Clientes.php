<?php

namespace App\Http\Controllers\brcondos_adv;

use App\Http\Controllers\Controller;
use App\Models\Boleto;
use App\Models\BoletoHistorico;
use App\Models\Condominio;
use App\Models\HistoricoCliente;
use App\Models\Hospital;
use App\Models\Negociacao;
use App\Models\Produto;
use App\Models\Tabela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Clientes extends Controller
{
    public function lista(Request $request)
    {
        try {

           
            /*
            $clientes = Boleto::with('condominio')->select( 
                'nm_cliente',
                'cpf_cnpj',
                'cd_condominio',
                'bloco_apto', 
                DB::raw("sum(case when status='PENDENTE' then 1 else 0 end) qtde_aberto"),
                DB::raw("FORMAT(sum(case when status='PENDENTE' then vl_boleto else 0 end), 2, 'de_DE') vl_aberto"),
                DB::raw("sum(case when status='ATRASADO' then 1 else 0 end) qtde_atrasado"),
                DB::raw("FORMAT(sum(case when status='ATRASADO' then vl_boleto else 0 end), 2, 'de_DE') vl_atrasado") 
            ) 
                ->groupBy(
                    'nm_cliente',
                    'cpf_cnpj',
                    'cd_condominio',
                    'bloco_apto' 
                );

            if ($request->has('dti') && $request->has('dtf')) {
                $clientes->where('dt_emissao', '>=', $request->dti)->where('dt_emissao', '<=', $request->dtf);
            }

            if ($request->has('nome') && !empty($request->nome)) {
                $clientes->where('nm_cliente', $request->nome);
            }

            if ($request->has('cpf') && !empty($request->cpf)) {
                $clientes->where('cpf_cnpj', $request->cpf);
            } 

            if($request->status){ 
                $clientes->whereIn( "status", $request->status); 
            }

            if ($request->has('condominio') && !empty($request->condominio)) {
                $clientes->where('cd_condominio', $request->condominio);
            }

            if ($request->has('bloco') && !empty($request->bloco)) {
                $clientes->where('bloco_apto', $request->bloco);
            }

            if ($request->has('titulo') && !empty($request->titulo)) {
                $clientes->where('id_boleto', $request->titulo);
            }

            $clientes = $clientes->limit(30)->get();

            dd($clientes->toArray());
            */
            

            $tabelas = Tabela::where('sn_ativo', 'S')->orderByRaw("tp_tabela,campo")->get();

            $condominios = Condominio::orderBy('nm_condominio')->orderBy('nm_condominio')->get();

            return view('brcondos_adv.clientes.lista', compact('condominios', 'tabelas', 'request' ));

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Houve um erro ao atualizar a Rotina! ' . $e->getMessage()])->withInput();
        }
    }

    public function json(Request $request)
    {

        $query = Boleto::with('condominio')->select( 
            'nm_cliente',
            'cpf_cnpj',
            'cd_condominio', 
            DB::raw("sum(case when status='PENDENTE' then 1 else 0 end) qtde_aberto"),
            DB::raw("FORMAT(sum(case when status='PENDENTE' then vl_boleto else 0 end), 2, 'de_DE') vl_aberto"),
            DB::raw("sum(case when status='ATRASADO' then 1 else 0 end) qtde_atrasado"),
            DB::raw("FORMAT(sum(case when status='ATRASADO' then vl_boleto else 0 end), 2, 'de_DE') vl_atrasado") 
        )
        
            ->orderByRaw(" sum(case when status='PENDENTE' then 1 else 0 end) +  sum(case when status='ATRASADO' then vl_boleto else 0 end)  desc")
            ->groupBy(
                'nm_cliente',
                'cpf_cnpj',
                'cd_condominio' 
            );

        if ($request->has('dti')) {
            $query->where('dt_vencimento', '>=', $request->dti);
        }
        
        if ($request->has('dtf')) {
            $query->where('dt_vencimento', '<=', $request->dtf);
        }

        if ($request->has('nome') && !empty($request->nome)) {
            $query->where('nm_cliente', $request->nome);
        }

        if ($request->has('cpf') && !empty($request->cpf)) {
            $query->where(DB::raw("GetNumber(cpf_cnpj)"), preg_replace('/[^0-9]/', '', $request->cpf));
        }
        if($request->status){ 
            $query->whereIn( "status", $request->status); 
        }
        if ($request->condominio) {
            $query->where('cd_condominio', $request->condominio);
        }

        if ($request->has('bloco') && !empty($request->bloco)) {
            $query->where('bloco_apto', $request->bloco);
        }

        if ($request->has('titulo') && !empty($request->titulo)) {
            $query->where('id_boleto', $request->titulo);
        }

        $query = $query->paginate(30);

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
        $return['request']=$request->toArray();    
        return response()->json($return);
    }
 

    public function store(Request $request)
    {
        $request->validate([
            'nm_condominio' => 'required|string|max:200',
            'cd_condominio' => 'nullable|int'
        ]);

        try {
            $retorno = DB::transaction(function () use ($request) {

                return Condominio::create([
                    'nm_condominio' => $request->nm_condominio,
                    'sn_ativo' => 'S',
                    'cd_condominio' => $request->cd_condominio
                ]);
            });

            return redirect()->route('condominios-listar')->with('success', 'Condominio atualizado com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Houve um erro ao atualizar o condominio! ' . $e->getMessage()])->withInput();
        }
    }
    public function edit(Condominio $condominio)
    {
        return view('brcondos_adv.condominios.edit', compact('condominio'));
    }
    public function update(Request $request, Condominio $condominio)
    {

        $request->validate([
            'nm_condominio' => 'required|string|max:200',
            'cd_condominio' => 'nullable|int'
        ]);

        try {

            $retorno = DB::transaction(function () use ($request, $condominio) {

                return $condominio->update([
                    'nm_condominio' => $request->nm_condominio,
                    'cd_condominio' => $request->cd_condominio,
                    'sn_ativo' => ($request['ativo'] == 'N') ? 'N' : 'S'
                ]);
            });

            return redirect()->route('condominios-listar')->with('success', 'Condominio atualizado com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Houve um erro ao atualizar o condominio! ' . $e->getMessage()])->withInput();
        }
    }
    public function destroy(Condominio $condominio)
    {
        try {
            $condominio->delete();
        } catch (\Exception $e) {
            abort(500);
        }
    }

    public function jsonBoletosAbertos(Request $request) {
        $request->validate([
            'cpf_cnpj' => 'required|string|exists:boletos,cpf_cnpj'
        ]);

        $boletos = Boleto::with('condominio')
        ->selectRaw("boletos.*,DATE_FORMAT(dt_vencimento, '%d/%m/%Y') data_vencimento,DATE_FORMAT(dt_emissao, '%d/%m/%Y') data_emissao ")
            ->where('cpf_cnpj', $request->cpf_cnpj)
            ->where('status', 'ATRASADO')
            ->get();

        $negociacoes = Negociacao::with(['condominio',  'boletos' ])
            ->selectRaw("negociacoes.*,DATE_FORMAT(dt_negociacao, '%d/%m/%Y') data_negociacao,format(valor, 2,'de_DE') vl_negociacao,users.name ")
            ->where('cpf_cnpj_cliente', $request->cpf_cnpj)
            ->leftJoin('users','users.id','negociacoes.cd_usuario')
            ->get();

        foreach($negociacoes as $negociacao) {
            $negociacao->boletos->load('boleto');
        }

        $historico = HistoricoCliente::with('usuario')->where('cpf_cnpj_cliente', $request->cpf_cnpj)->get();

        return response()->json([
            'boletos' => $boletos,
            'negociacoes' => $negociacoes,
            'historico' => $historico
        ]);
    }
}
