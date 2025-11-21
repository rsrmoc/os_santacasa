<?php

namespace App\Http\Controllers\brcondos_adv;

use App\Http\Controllers\Controller;
use App\Models\Boleto;
use App\Models\Condominio;
use App\Models\Negociacao;
use App\Models\NegociacaoBoleto;
use App\Models\Tabela;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NegociacoesController extends Controller {

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

    public function json(Request $request)
    {

        $query = Negociacao::with(['condominio','boletos' => function($q) use($request){ 
            $q->selectRaw("negociacoes_boleto.cd_boleto,count(*) qtde, format(sum(vl_boleto), 2,'de_DE') vl_boleto")
            ->join('boletos','boletos.cd_boleto','negociacoes_boleto.cd_boleto')
            ->groupBy("negociacoes_boleto.cd_boleto");  

        } ])->selectRaw("negociacoes.*,DATE_FORMAT(dt_negociacao, '%d/%m/%Y') data_negociacao,format(valor, 2,'de_DE') vl_negociacao,name")
        ->join('users','users.id','negociacoes.cd_usuario');

        if ($request->has('dti')) {
            $query->where('dt_negociacao', '>=', $request->dti);
        }
        
        if ($request->has('dtf')) {
            $query->where('dt_negociacao', '<=', $request->dtf);
        }

        if ($request->has('nome') && !empty($request->nome)) {
            $query->whereRaw("upper(nm_cliente) like '".mb_strtoupper($request->nome)."%'" );
        }

        if ($request->has('cpf') && !empty($request->cpf)) {
            $query->where(DB::raw("GetNumber(cpf_cnpj_cliente)"), preg_replace('/[^0-9]/', '', $request->cpf));
        }
        if($request->status){ 
            $query->whereIn( "status", $request->status); 
        }
        if ($request->condominio) {
            $query->where('cd_condominio', $request->condominio);
        }
  
        if ($request->has('negoc') && !empty($request->negoc)) {
            $query->where('cd_negociacao', $request->negoc);
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

    public function jsonNegBoleto(Request $request)
    {

        $validated = $request->validate([
            'cpf' => 'required',
            'codigo' => 'required', 
        ]);

        $TODOS=false;
        try {
            $query=Boleto::whereRaw("cpf_cnpj ='".$request['cpf']."'")->whereRaw("grupo_historico ='ACORDO/NEGOCIAÇÃO'")
            ->join('condominios','condominios.cd_condominio','boletos.cd_condominio');
            if($request['tipo']=='TODOS'){
                $TODOS=true;
                $query = $query->leftJoin('negociacoes_boleto',  function($q) use ($request)
                {
                    $q->on('negociacoes_boleto.cd_boleto', 'boletos.cd_boleto')
                    ->whereRaw("negociacoes_boleto.cd_negociacao = ".$request['codigo']);
                })  
                ->whereRaw(" boletos.cd_boleto not in (select cd_boleto from negociacoes_boleto where cd_boleto is not null and cd_negociacao <> ".$request['codigo'].")");
            }else{
                $query = $query->join('negociacoes_boleto','negociacoes_boleto.cd_boleto', 'boletos.cd_boleto');
            }
            $query = $query->selectRaw("boletos.*,DATE_FORMAT(dt_vencimento, '%d/%m/%Y') data_vencimento,format(vl_boleto, 2,'de_DE') valor,DATE_FORMAT(dt_emissao, '%d/%m/%Y') data_emissao,negociacoes_boleto.cd_boleto boleto_selec")
            ->orderBy("dt_vencimento")->get();

            $BoletosSelecionados=null;
            foreach ($query as $key => $boleto) {
                if($boleto['boleto_selec']){
                    $BoletosSelecionados[]=$boleto['boleto_selec'];
                }
            }
      
            $return['dados']=$query;    
            $return['add']=$TODOS;    
            $return['select']=$BoletosSelecionados;  
            return response()->json($return); 

        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }
    
    public function storeNegBoleto(Request $request)
    {
        $validated = $request->validate([
            'cd_boletos' => 'required|array|min:1', 
            'cd_negociacao' => 'required', 
        ]);
 
        try {
            NegociacaoBoleto::where('cd_negociacao',$validated['cd_negociacao'])->delete();
            foreach ($validated['cd_boletos'] as $key => $boleto) {
                $arrayBoleto['cd_boleto'] = $boleto;
                $arrayBoleto['cd_negociacao'] = $validated['cd_negociacao'];
                $arrayBoleto['id_usuario'] = USER_LOGADO();
                NegociacaoBoleto::create($arrayBoleto);
             }
             
             return response()->json(true); 
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }
    public function createJson(Request $request) {
        $validated = $request->validate([
            'dt_negociacao' => 'required|date_format:Y-m-d',
            'nr_contato' => 'required|string',
            'email_cliente' => 'required|string|email',
            'valor' => 'required',
            'obs' => 'nullable|string',
            'cd_condominio' => 'required|integer|exists:condominios,cd_condominio',
            'cpf_cnpj_cliente' => 'required|string',
            'nm_cliente' => 'required|string'
        ]);

        try {
            $validated['id_usuario'] = $request->user()->id;
            $validated['valor'] = str_replace('.', '', $request->valor);
            $validated['valor'] = str_replace(',', '.', $validated['valor']);
            $validated['status'] = 'AGUARDANDO';
            $validated['valor'] = str_replace('.', '', $request['valor']);
            $validated['valor'] = str_replace(',', '.', $validated['valor']);
            $validated['cd_usuario'] = USER_LOGADO();
            $negociacao = Negociacao::create($validated);

            $negociacoes = Negociacao::with('condominio', 'boletos')
            ->selectRaw("negociacoes.*,DATE_FORMAT(dt_negociacao, '%d/%m/%Y') data_negociacao,format(valor, 2,'de_DE') vl_negociacao,users.name ")
            ->where('cpf_cnpj_cliente', $request->cpf_cnpj_cliente)
            ->leftJoin('users','users.id','negociacoes.cd_usuario')
            ->get();

            return response()->json([
                'message' => 'Negociação criada com sucesso!',
                'negociacao' => $negociacao,
                'negociacoes' => $negociacoes
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function updateJson(Request $request) {
        $validated = $request->validate([
            'cd_negociacao' => 'required|integer|exists:negociacoes,cd_negociacao',
            'dt_negociacao' => 'required|date_format:Y-m-d',
            'nr_contato' => 'required|string',
            'email_cliente' => 'required|string|email',
            'valor' => 'required',
            'obs' => 'nullable|string'
        ]);

        try {
            $validated['valor'] = str_replace('.', '', $request->valor);
            $validated['valor'] = str_replace(',', '.', $validated['valor']);
            $validated['valor'] = str_replace('.', '', $request['valor']);
            $validated['valor'] = str_replace(',', '.', $validated['valor']);
            unset($validated['cd_negociacao']);

            $negociacao = Negociacao::find($request->cd_negociacao);
            $CPF = $negociacao->cpf_cnpj_cliente;
            $negociacao->update($validated);

            $negociacoes = Negociacao::with('condominio', 'boletos')
            ->selectRaw("negociacoes.*,DATE_FORMAT(dt_negociacao, '%d/%m/%Y') data_negociacao,format(valor, 2,'de_DE') vl_negociacao,users.name ")
            ->where('cpf_cnpj_cliente', $CPF)
            ->leftJoin('users','users.id','negociacoes.cd_usuario')
            ->get();

            return response()->json([
                'message' => 'Negociação atualizado com sucesso!',
                'negociacao' => $negociacao,
                'negociacoes' => $negociacoes
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function deleteJson($cdNegociacao) {
        try {
            Negociacao::find($cdNegociacao)->delete();

            return response()->json(['message' => 'Negociação excluida com sucesso!']);
        }
        catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}