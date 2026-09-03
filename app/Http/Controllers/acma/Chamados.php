<?php

namespace App\Http\Controllers\acma;

use App\Bibliotecas\EnvioEmail;
use App\Http\Controllers\Controller;
use App\Models\Boleto;
use App\Models\BoletoHistorico;
use App\Models\Condominio;
use App\Models\Hospital;
use App\Models\mv\ClassificacaoOs;
use App\Models\mv\Funcionario;
use App\Models\mv\ItSolicitacaoOs;
use App\Models\mv\Localidade;
use App\Models\mv\ManuServ;
use App\Models\mv\Oficina;
use App\Models\mv\OfiServ;
use App\Models\mv\OsAprazamento;
use App\Models\mv\OsConfig;
use App\Models\mv\OsObservacoes;
use App\Models\mv\OsSituacao;
use App\Models\mv\OsTipo;
use App\Models\mv\Setor;
use App\Models\mv\SolicitacaoOs;
use App\Models\mv\TipoOs;
use App\Models\Produto;
use App\Models\Tabela;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Chamados extends Controller
{

    public function chamados(Request $request)
    {

        try {
            $oficina = Auth::user()->cd_oficina;
            $request['dti'] = date('Y-m-d', strtotime('-5 days', strtotime(date('Y-m-d'))));
            $request['dtf'] = date('Y-m-d');
            $request['cd_situacao'] = 'A';
            $request['setor'] = Setor::where('sn_ativo', 'S')->orderBy('nm_setor')->get();
            $request['func'] = Funcionario::where('sn_ativo', 'S')->orderBy('nm_func')->get();
            $request['localidade'] = Localidade::orderBy('ds_localidade')
                ->whereRaw("cd_setor in (select cd_setor from dbamv.setor where sn_ativo = 'S') ")
                ->whereRaw("ds_localidade not in ('.')")->get();
            $request['tipo_os'] = TipoOs::orderBy('ds_tipo_os')->get();
            $request['oficina'] = Oficina::orderBy('ds_oficina')->whereRaw("cd_oficina in (" . $oficina . ")")->get();
            $request['situacao'] = OsSituacao::orderBy('nm_situacao')->get();
            $request['serv'] = ManuServ::whereRaw("cd_servico in (select cd_servico from dbamv.ofi_serv where cd_oficina in (" . $oficina . "))")
                ->orderBy('nm_servico')->get();
            $request['nm_oficina'] = Oficina::whereRaw("cd_oficina in (" . $oficina . ")")->value('ds_oficina');
            $request['tipos'] = TipoOs::join('dbacaixa.os_tipo', 'os_tipo.cd_tp_os', '=', 'tipo_os.cd_tipo_os')
                ->whereRaw("cd_oficina in (" . $oficina . ")")->orderBy('ds_tipo_os')->get();
            return view('acma.chamados.lista', compact('request'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Houve um erro ao atualizar a Rotina! ' . $e->getMessage()])->withInput();
        }
    }

    public function suporte(Request $request)
    {

        try {

            $request['Config'] = OsConfig::find(Auth::user()->cd_oficina);
            $oficina = Auth::user()->cd_oficina;
            $request['dti'] = date('Y-m-d', strtotime('-5 days', strtotime(date('Y-m-d'))));
            $request['dtf'] = date('Y-m-d');
            $request['cd_situacao'] = 'A';
            $request['setor'] = Setor::where('sn_ativo', 'S')->orderBy('nm_setor')->get();
            $request['func'] = Funcionario::where('sn_ativo', 'S')->orderBy('nm_func')->get();
            $request['localidade'] = Localidade::orderBy('ds_localidade')
                ->whereRaw("cd_setor in (select cd_setor from dbamv.setor where sn_ativo = 'S') ")
                ->selectRaw("cd_setor, ds_localidade,cd_localidade")
                ->whereRaw("ds_localidade not in ('.')")->get();
            $request['tipo_os'] = TipoOs::orderBy('ds_tipo_os')->get();
            $request['oficina'] = Oficina::orderBy('ds_oficina')->whereRaw("cd_oficina in (" . $oficina . ")")->get();
            $request['situacao'] = OsSituacao::orderBy('nm_situacao')->get();
            $request['serv'] = ManuServ::whereRaw("cd_servico in (select cd_servico from dbamv.ofi_serv where cd_oficina in (" . $oficina . "))")
                ->orderBy('nm_servico')->get();
            $request['nm_oficina'] = Oficina::whereRaw("cd_oficina in (" . $oficina . ")")->value('ds_oficina');
            $request['tipos'] = TipoOs::join('dbacaixa.os_tipo', 'os_tipo.cd_tp_os', '=', 'tipo_os.cd_tipo_os')
                ->whereRaw("cd_oficina in (" . $oficina . ")")->orderBy('ds_tipo_os')->get();
            return view('acma.suporte.lista', compact('request'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Houve um erro ao atualizar a Rotina! ' . $e->getMessage()])->withInput();
        }
    }

    public function projetos(Request $request)
    {

        try {

            $request['Config'] = OsConfig::find(Auth::user()->cd_oficina);
            $oficina = Auth::user()->cd_oficina;
            $request['dti'] = date('Y-m-d', strtotime('-5 days', strtotime(date('Y-m-d'))));
            $request['dtf'] = date('Y-m-d');
            $request['cd_situacao'] = 'A';
            $request['setor'] = Setor::where('sn_ativo', 'S')->orderBy('nm_setor')->get();
            $request['func'] = Funcionario::where('sn_ativo', 'S')->orderBy('nm_func')->get();
            $request['localidade'] = Localidade::orderBy('ds_localidade')
                ->whereRaw("cd_setor in (select cd_setor from dbamv.setor where sn_ativo = 'S') ")
                ->selectRaw("cd_setor, ds_localidade,cd_localidade")
                ->whereRaw("ds_localidade not in ('.')")->get();
            $request['tipo_os'] = TipoOs::orderBy('ds_tipo_os')->get();
            $request['oficina'] = Oficina::orderBy('ds_oficina')->whereRaw("cd_oficina in (" . $oficina . ")")->get();
            $request['situacao'] = OsSituacao::orderBy('nm_situacao')->get();
            $request['serv'] = ManuServ::whereRaw("cd_servico in (select cd_servico from dbamv.ofi_serv where cd_oficina in (" . $oficina . "))")
                ->orderBy('nm_servico')->get();
            $request['nm_oficina'] = Oficina::whereRaw("cd_oficina in (" . $oficina . ")")->value('ds_oficina');
            $request['tipos'] = TipoOs::join('dbacaixa.os_tipo', 'os_tipo.cd_tp_os', '=', 'tipo_os.cd_tipo_os')
                ->whereRaw("cd_oficina in (" . $oficina . ")")->orderBy('ds_tipo_os')->get();
            return view('acma.projetos.lista', compact('request'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Houve um erro ao atualizar a Rotina! ' . $e->getMessage()])->withInput();
        }
    }

    public function json(Request $request)
    {

        try {

            $Config = OsConfig::find(Auth::user()->cd_oficina);


            $query = $this->queryChamados($request->all());
            if ($request['tp_pagina'] == 'suporte') {
                $query = $query->selectRaw("solicitacao_os.*,
                case when tp_situacao in ('A','S') then ( trunc(sysdate) - trunc(dt_pedido) ) || ' Dias' else ( trunc(sysdate) - trunc(dt_execucao) ) || ' Dias' end as dias_em_aberto")
                ->whereRaw( ($Config->query_suporte ?? " 1=1 ") );
            }
            if ($request['tp_pagina'] == 'projeto') {
                $query = $query->selectRaw("solicitacao_os.*,
                case when tp_situacao in ('A','S') then ( trunc(sysdate) - trunc(dt_pedido) ) || ' Dias' else ( trunc(sysdate) - trunc(dt_execucao) ) || ' Dias' end as dias_em_aberto")
                ->whereRaw( ($Config->query_projeto ?? " 1=1 ") );
            }
            if ($request['tp_pagina'] == 'chamados') {
                $query = $query->selectRaw("solicitacao_os.*,
                case when tp_situacao in ('A','S') then ( trunc(sysdate) - trunc(dt_pedido) ) || ' Dias' else ( trunc(sysdate) - trunc(dt_execucao) ) || ' Dias' end as dias_em_aberto");
            }
            $contadores = $this->contadoresChamados($request->all(), $Config);

            $query = $query->orderByRaw(($request['ordenacao'] ?? "dt_pedido desc"))->paginate(($request['linha_pagina'] ?? 30));

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

            $return['dados'] = $query;
            $return['pagination'] = PAGINACAO_HTML($pagination);
            $return['contadores'] = $contadores;
            $return['request'] = $request->toArray();

            return response()->json($return);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage(), 'request' => $request->toArray()], 500);
        }
    }

    public function json_header(Request $request, $tela = null)
    {
        try {

            if($tela == 'suporte'){
                $query = $this->queryChamados($request->all())
                ->whereRaw("cd_oficina = " . Auth::user()->cd_oficina);
                $retorno = $query->toBase()->selectRaw("
                    sum(case when tp_situacao in (select cd_situacao from dbarpsys.os_situacao where tipo='A') then 1 else 0 end) as total_aberta,
                    sum(case when tp_situacao in (select cd_situacao from dbarpsys.os_situacao where tipo='A') and cd_os in (select cd_os from dbacaixa.classificacao_os) then 1 else 0 end) as total_classificada,
                    sum(case when tp_situacao in (select cd_situacao from dbarpsys.os_situacao where tipo='A') and cd_os in (select cd_os from dbacaixa.classificacao_os where dt_prazo is not null) then 1 else 0 end) as total_aprazada,
                    sum(case when tp_situacao in (select cd_situacao from dbarpsys.os_situacao where tipo='A')  and (trunc(sysdate) - trunc(dt_pedido)) <= 5 then 1 else 0 end) as total_ate_5_dias,
                    sum(case when tp_situacao in (select cd_situacao from dbarpsys.os_situacao where tipo='A') and (trunc(sysdate) - trunc(dt_pedido)) > 5 and (trunc(sysdate) - trunc(dt_pedido)) <= 10 then 1 else 0 end) as total_ate_10_dias,
                    sum(case when tp_situacao in (select cd_situacao from dbarpsys.os_situacao where tipo='A') and (trunc(sysdate) - trunc(dt_pedido)) > 10 then 1 else 0 end) as total_maior_10_dias
                ")->first();
                $retorno = (array) $retorno;
                $retorno['p_total_classificada'] = intval(($retorno['total_classificada'] / $retorno['total_aberta']) * 100);
                $retorno['p_total_aprazada'] = intval(($retorno['total_aprazada'] / $retorno['total_aberta']) * 100);
                $retorno['p_total_ate_5_dias'] = intval(($retorno['total_ate_5_dias'] / $retorno['total_aberta']) * 100);
                $retorno['p_total_ate_10_dias'] = intval(($retorno['total_ate_10_dias'] / $retorno['total_aberta']) * 100);
                $retorno['p_total_maior_10_dias'] = intval(($retorno['total_maior_10_dias'] / $retorno['total_aberta']) * 100);
                //dd($retorno);
                return response()->json($retorno);
            }

            if($tela == 'projeto'){
                $query = $this->queryChamados($request->all())
                ->whereRaw("cd_oficina = " . Auth::user()->cd_oficina)
                ->whereRaw("cd_os in (select cd_os from dbacaixa.classificacao_os where responsavel = " . Auth::user()->cd_funcionario . ")");
                $retorno = $query->toBase()->selectRaw("
                    sum(case when tp_situacao in (select cd_situacao from dbarpsys.os_situacao where tipo='A') then 1 else 0 end) as total_aberta,
                    sum(case when tp_situacao in (select cd_situacao from dbarpsys.os_situacao where tipo='A') and cd_os in (select cd_os from dbacaixa.classificacao_os where dt_prazo is null and responsavel = " . Auth::user()->cd_funcionario . ") then 1 else 0 end) as total_aprazada,
                    sum(case when tp_situacao in (select cd_situacao from dbarpsys.os_situacao where tipo='A') and cd_os in ( select cd_os from dbacaixa.classificacao_os where trunc(dt_prazo) < trunc(sysdate-3) and dt_prazo is not null and responsavel = " . Auth::user()->cd_funcionario . ") then 1 else 0 end) as dentro_prazo,
                    sum(case when tp_situacao in (select cd_situacao from dbarpsys.os_situacao where tipo='A') and cd_os in ( select cd_os from dbacaixa.classificacao_os where trunc(dt_prazo) >= trunc(sysdate-3) and trunc(dt_prazo) <= trunc(sysdate) and dt_prazo is not null and responsavel = " . Auth::user()->cd_funcionario . ") then 1 else 0 end) as vencendo_prazo,
                    sum(case when tp_situacao in (select cd_situacao from dbarpsys.os_situacao where tipo='A') and cd_os in ( select cd_os from dbacaixa.classificacao_os where trunc(dt_prazo) > trunc(sysdate) and responsavel = " . Auth::user()->cd_funcionario . " )  then 1 else 0 end) as vencido
                ")->first();
                $retorno = (array) $retorno;
                $retorno['p_total_aprazada'] = intval(($retorno['total_aprazada'] / $retorno['total_aberta']) * 100);
                $retorno['p_dentro_prazo'] = intval(($retorno['dentro_prazo'] / $retorno['total_aberta']) * 100);
                $retorno['p_vencendo_prazo'] = intval(($retorno['vencendo_prazo'] / $retorno['total_aberta']) * 100);
                $retorno['p_vencido'] = intval(($retorno['vencido'] / $retorno['total_aberta']) * 100);
                //dd($retorno);
                return response()->json($retorno);
            }
            return response()->json([]);

        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage(), 'request' => $request->toArray()], 500);
        }
    }


    public function contadoresChamados($dados = [], $Config = null) {
        $query = $this->queryChamados($dados);

        if ($dados['tp_pagina'] == 'suporte') {
            $query = $query->whereRaw( ($Config->query_suporte ?? " 1=1 ") );
        }
        if ($dados['tp_pagina'] == 'projeto') {
            $query = $query->whereRaw( ($Config->query_projeto ?? " 1=1 ") );
        }

        return $query->toBase()->selectRaw("
            sum(case when tp_situacao in (select cd_situacao from dbarpsys.os_situacao where tipo='A') then 1 else 0 end) as total_aberta,
            sum(case when tp_situacao in (select cd_situacao from dbarpsys.os_situacao where tipo='A') and cd_os in (select cd_os from dbacaixa.classificacao_os) then 1 else 0 end) as total_classificada,
            sum(case when tp_situacao in (select cd_situacao from dbarpsys.os_situacao where tipo='A') and (trunc(sysdate) - trunc(dt_pedido)) <= 10 then 1 else 0 end) as total_ate_10_dias,
            sum(case when tp_situacao in (select cd_situacao from dbarpsys.os_situacao where tipo='A') and (trunc(sysdate) - trunc(dt_pedido)) > 10 then 1 else 0 end) as total_maior_10_dias
        ")->first();
    }

    public function json_classicacao(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'cd_os' => 'required',
                'oficina' => 'required',
                'responsavel' => 'nullable',
                'tipo' => 'nullable',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first()], 400);
            }

            $Config = OsConfig::find(Auth::user()->cd_oficina);

            DB::beginTransaction();
            $textoObs = "Classificou a OS: ";
            if ($request['responsavel']) {
                $resp = Funcionario::where('cd_func', $request['responsavel'])->first();
                $textoObs .= "\n__Responsável: " . $resp->nm_func;

                ClassificacaoOs::UpdateOrInsert(
                    ['CD_OS' => $request['cd_os']],
                    [
                        'RESPONSAVEL' => $request['responsavel'],
                        'UPDATED_AT' => $this->sysdate(),
                        'CREATED_AT' => $this->sysdate()
                    ]
                );
            }
            $oficina = Oficina::where('cd_oficina', $request['oficina'])->first();
            $dados['CD_OFICINA'] = $request['oficina'];
            if ($request['tipo']) {
                $Tipo = TipoOs::where('cd_tipo_os', $request['tipo'])->first();
                $textoObs .= "\n__Tipo: " . $Tipo->ds_tipo_os;
                $dados['CD_TIPO_OS'] = $request['tipo'];
            }
            $textoObs .= "\n__Oficina: " . $oficina->ds_oficina;
            SolicitacaoOs::where('cd_os', $request['cd_os'])->update($dados);
            OsObservacoes::create([
                'CD_OS' => $request['cd_os'],
                'OBS' => $textoObs,
                'CD_USUARIO' => Auth::user()->email
            ]);
            $descricao = $Config->ds_classificacao ?? "Classificação de OS ";
            $servico = $Config->tp_classificacao ?? 687;
            $retorno = $this->createServicoOs($request['cd_os'], date('Y-m-d H:i'), (date('Y-m-d H:i', strtotime('+5 minutes'))), $servico, Auth::user()->cd_funcionario, $descricao);

            DB::commit();

            $retorno = $this->queryChamados([])
                ->where('cd_os', $request['cd_os'])->first();

            return response()->json(['request' => $request->all(), 'retorno' => $retorno]);

        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(),'request' => $request->toArray() ], 500);
        }

    }

    public function json_aprazamento(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'cd_os' => 'required',
                'email' => 'required',
                'dt_previsao' => 'required|date_format:Y-m-d',
                'descricao' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first()], 400);
            }

            $Config = OsConfig::find(Auth::user()->cd_oficina);

            $dados['cd_os'] = $request['cd_os'];
            $dados['dt_aprazamento'] = date('d/m/Y', strtotime($request['dt_previsao']));
            $dados['responsavel'] = Auth::user()->name;
            $dados['descricao'] = $request['descricao'];
            $Conteudo = FUNC_EMAIL_APRAZAMENTOS($dados);

            $DadosEmail['arquivo_anexo'] = 'anexo.pdf';
            $DadosEmail['email'] = explode(";", $request['email']);
            $DadosEmail['assunto'] = utf8_decode('Setor Informatica - Aprazamento Ordem de Serviço ');
            $DadosEmail['conteudo'] = $Conteudo;
            $email = new EnvioEmail();
            if ($email->enviar_email($DadosEmail) == true) {
                //if(true == true){
                DB::beginTransaction();
                OsAprazamento::insert([
                    'CD_OS' => $request['cd_os'],
                    'EMAIL' => $request['email'],
                    'DT_PRAZO' => $request['dt_previsao'],
                    'DESCRICAO' => $request['descricao'],
                    'CD_FUNC' => Auth::user()->cd_funcionario,
                    'USUARIO' => Auth::user()->email,
                    'CREATED_AT' => $this->sysdate(),
                ]);
                ClassificacaoOs::UpdateOrInsert(
                    ['CD_OS' => $request['cd_os']],
                    [
                        'RESPONSAVEL' => Auth::user()->cd_funcionario,
                        'DT_PRAZO' => $request['dt_previsao'],
                        'UPDATED_AT' => $this->sysdate(),
                        'CREATED_AT' => $this->sysdate(),
                    ]
                );

                $descricao = ($Config->ds_aprazamento ?? 'Aprazamento: ') . " " . date('d/m/Y', strtotime($request['dt_previsao'])) . ".";
                $servico = $Config->tp_aprazamento ?? 686;
                $this->createServicoOs($request['cd_os'], date('Y-m-d H:i'), (date('Y-m-d H:i', strtotime('+5 minutes'))), $servico, Auth::user()->cd_funcionario, $descricao);
                OsObservacoes::create([
                    'CD_OS' => $request['cd_os'],
                    'OBS' => $descricao,
                    'CD_USUARIO' => Auth::user()->email
                ]);
                DB::commit();

                /*
                $retorno = OsAprazamento::where('cd_os',$request['cd_os'])
                ->with('tab_responsavel')
                ->orderBy('created_at', 'desc')->get();
                */

                $retorno = $this->queryChamados([])
                    ->where('cd_os', $request['cd_os'])->first();

                return response()->json(['retorno' => $retorno, 'request' => $request->toArray()]);
            } else {

                return response()->json(['message' => 'Falha ao enviar o email'], 400);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), 'request' => $request->toArray()], 500);
        }
    }

    public function json_obs(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'cd_os' => 'required',
                'descricao' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first()], 400);
            }

            DB::beginTransaction();
            OsObservacoes::create([
                'CD_OS' => $request['cd_os'],
                'OBS' => $request['descricao'],
                'CD_USUARIO' => Auth::user()->email
            ]);
            DB::commit();

            $retorno = $this->queryChamados([])
                ->where('cd_os', $request['cd_os'])->first();

            return response()->json(['request' => $request->all(), 'retorno' => $retorno]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), 'request' => $request->toArray()], 500);
        }
    }

    public function json_servico(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'cd_os' => 'required',
                'descricao' => 'required',
                'dti' => 'required',
                'dtf' => 'required',
                'servico' => 'required',
                'funcionario' => 'required',
                'fechar_os' => 'nullable',
            ]);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first()], 400);
            }

            DB::beginTransaction();

            $this->createServicoOs($request['cd_os'], $request['dti'], $request['dtf'], $request['servico'], $request['funcionario'], $request['descricao']);
            if (!empty($request['fechar_os'])) {
                SolicitacaoOs::where('cd_os', $request['cd_os'])
                    ->update(['tp_situacao' => 'C', 'tp_local' => 'I', 'dt_execucao' =>  $request['dtf']]);
                OsObservacoes::create([
                    'CD_OS' => $request['cd_os'],
                    'OBS' => 'O USUARIO FECHOU A ORDEM DE SERVIÇO.',
                    'CD_USUARIO' => Auth::user()->email
                ]);
            }
            DB::commit();
            $retorno = $this->queryChamados([])
                ->where('cd_os', $request['cd_os'])->first();

            return response()->json(['request' => $request->all(), 'retorno' => $retorno ?? []]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), 'request' => $request->toArray()], 500);
        }
    }

    public function json_servico_cancelar(Request $request, ItSolicitacaoOs $id)
    {
        try {

            DB::beginTransaction();

            ItSolicitacaoOs::where('cd_itsolicitacao_os', $id->cd_itsolicitacao_os)
                ->delete();

            DB::commit();

            $retorno = $this->queryChamados([])
                ->where('cd_os', $id->cd_os)->first();

            return response()->json(['request' => $request->all(), 'retorno' => $retorno ?? []]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function json_servico_fechar(Request $request, SolicitacaoOs $id)
    {
        try {
            $servico = ItSolicitacaoOs::where('cd_os', $id->cd_os)->count();
            if ($servico == 0) {
                return response()->json(['message' => 'A OS não possui serviços para fechar.'], 400);
            }
            DB::beginTransaction();

            SolicitacaoOs::where('cd_os', $id['cd_os'])
                ->update(['tp_situacao' => 'C', 'tp_local' => 'I', 'dt_execucao' =>  now()]);

            DB::commit();

            $retorno = $this->queryChamados([])
                ->where('cd_os', $id->cd_os)->first();

            return response()->json(['request' => $request->all(), 'retorno' => $retorno ?? []]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function json_finalizar(Request $request, SolicitacaoOs $id)
    {
        try {

            DB::beginTransaction();

            $Config = OsConfig::find(Auth::user()->cd_oficina);
            $DTI = $id->dt_pedido;
            //$DTF = (date('Y-m-d H:i', strtotime($id->dt_pedido .' +'.($Config->temp_suporte ?? 10).' minutes')));
            $DTF = $this->sysdate();
            $this->createServicoOs( $id->cd_os, $DTI, $DTF,
                                    ($Config->serv_suporte ?? 393), Auth::user()->cd_funcionario,( $Config->ds_suporte ?? 'SUPORTE AO USUARIO' ));
            SolicitacaoOs::where('cd_os', $id->cd_os)
                ->update(['tp_situacao' => 'C', 'tp_local' => 'I', 'dt_execucao' =>  $DTF]);

            DB::commit();


            $retorno = $this->queryOsAndamento();
            return response()->json(['request' => $request->all(), 'retorno' => $retorno ?? []]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function json_servico_reabrir(Request $request, SolicitacaoOs $id)
    {
        try {

            DB::beginTransaction();

            SolicitacaoOs::where('cd_os', $id->cd_os)
                ->update([
                    'tp_situacao' => 'A',
                    'tp_local' => 'I',
                    'dt_execucao' => null
                ]);

            OsObservacoes::create([
                'CD_OS' => $id->cd_os,
                'OBS' => 'O USUARIO REABRIU A ORDEM DE SERVIÇO.',
                'CD_USUARIO' => Auth::user()->email
            ]);

            DB::commit();

            $retorno = $this->queryChamados([])
                ->where('cd_os', $id->cd_os)->first();

            return response()->json(['request' => $request->all(), 'retorno' => $retorno ?? []]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function json_os_suporte(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'tipo' => 'required',
                'oficina' => 'required',
                'setor' => 'required',
                'localidade' => 'required',
                'descricao' => 'required',
                'observacao' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first()], 400);
            }

            //$Config = OsConfig::find(Auth::user()->cd_oficina);
            $TipoOs = OsTipo::where('cd_tp_os', $request->cd_tipo_os)
                ->whereRaw(" cd_oficina in (" . Auth::user()->cd_oficina . ") ")->first();

            DB::beginTransaction();

            $cd_os = DB::select("select seq_os.nextval from dual")[0]->nextval;
            SolicitacaoOs::insert([
                'cd_os' => $cd_os,
                'dt_pedido' =>$this->sysdate(),
                'ds_servico' => $request->descricao,
                'ds_observacao' => $request->observacao,
                'nm_solicitante' => Auth::user()->name,
                'tp_situacao' => 'A',
                'cd_setor' => $request->setor,
                'cd_multi_empresa' => 1,
                'cd_tipo_os' => $request->tipo,
                'nm_usuario' => Auth::user()->email,
                'dt_ultima_atualizacao' => $this->sysdate(),
                'cd_localidade' => $request->localidade,
                'sn_sol_externa' => 'S',
                'cd_oficina' => $request['oficina'],
                'sn_ordem_servico_principal' => 'S',
                'cd_mot_serv' => $TipoOs->cd_motivo ?? null,
                'sn_paciente' => 'N'
            ]);
            if($request['tp_form']=='suporte'){
                ClassificacaoOs::insert(
                    [
                        'CD_OS' => $cd_os,
                        'RESPONSAVEL' => Auth::user()->cd_funcionario,
                        'DT_PRAZO' => null,
                        'SN_ANDAMENTO' => 'S',
                        'UPDATED_AT' => $this->sysdate(),
                        'CREATED_AT' => $this->sysdate()
                    ]
                );
            }

            DB::commit();

            $retorno = $this->queryOsAndamento();
            return response()->json(['request' => $request->all(), 'retorno' => $retorno ?? []]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), 'request' => $request->toArray()], 500);
        }
    }

    public function json_os_andamentos(Request $request)
    {

        try {

            $retorno = $this->queryOsAndamento();
            return response()->json(['request' => $request->all(), 'retorno' => $retorno ?? []]);

        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage(), 'request' => $request->toArray()], 500);
        }
    }

    public function queryOsAndamento($dados = [])
    {
            $retorno = ClassificacaoOs::where('responsavel', Auth::user()->cd_funcionario)
            ->join('dbamv.solicitacao_os', 'dbamv.solicitacao_os.cd_os', '=', 'dbacaixa.classificacao_os.cd_os')
            ->whereRaw("tp_situacao in ('A','S')")
            ->where('sn_andamento', 'S')
            ->with('tab_responsavel')
            ->with('tab_solicitacao.tab_setor')
            ->with('tab_solicitacao.tab_tipo_os')
            ->with('tab_solicitacao.tab_oficina')
            ->orderBy('created_at', 'desc')->get();

            return $retorno;
    }

    public function queryChamados($dados = [])
    {
        $oficina = Auth::user()->cd_oficina;
        $query = SolicitacaoOs::whereRaw('cd_oficina in (' . $oficina . ')')

            ->with('tab_it_solicitacao.tab_func')
            ->with('tab_it_solicitacao.tab_servico')
            ->with('tab_setor')
            ->with('tab_espec')
            ->with('tab_aprazamento.tab_responsavel')
            ->with('tab_tipo_os')
            ->with(['tab_classificacao' => function ($query) use ($dados) {
                if (!empty($dados['func'])) {
                    $query->where('responsavel', $dados['func']);
                }
            }])
            ->with('tab_classificacao.tab_responsavel')
            ->with('tab_localidade')
            ->with('tab_situacao')
            ->with('tab_observacao.tab_func')
            ->with('tab_oficina');

        if (($dados['dti'] ?? null)) {
            $query = $query->where(DB::raw('trunc(dt_pedido)'), '>=', $dados['dti']);
        }
        if (($dados['dtf'] ?? null)) {
            $query = $query->where(DB::raw('trunc(dt_pedido)'), '<=', $dados['dtf']);
        }
        if (!empty($dados['descricao'])) {
            $query = $query->whereRaw("upper(ds_servico) like '%" . mb_strtoupper($dados['descricao']) . "%'");
        }
        if (!empty($dados['setor'])) {
            $query = $query->whereRaw("upper(cd_setor) = '" . mb_strtoupper($dados['setor']) . "'");
        }
        if (!empty($dados['func'])) {
            $query = $query->whereHas('tab_classificacao', function ($query) use ($dados) {
                $query->where('responsavel', $dados['func']);
            });
        }
        if (!empty($dados['tipo_os'])) {
            $query = $query->whereRaw("upper(cd_tipo_os) = '" . mb_strtoupper($dados['tipo_os']) . "'");
        }
        if (!empty($dados['cd_os'])) {
            $query = $query->whereRaw("upper(cd_os) = '" . mb_strtoupper($dados['cd_os']) . "'");
        }
        if (!empty($dados['localidade'])) {
            $query = $query->whereRaw("upper(cd_localidade) = '" . mb_strtoupper($dados['localidade']) . "'");
        }
        if (!empty($dados['situacao'])) {
            $query = $query->whereRaw("tp_situacao in (select cd_situacao from dbarpsys.os_situacao where tipo='" . mb_strtoupper($dados['situacao']) . "')");
        }
        if (!empty($dados['oficina'])) {
            $query = $query->whereRaw("upper(cd_oficina) = '" . mb_strtoupper($dados['oficina']) . "'");
        }

        $query = $query;
        return $query;
    }

    public function createServicoOs($os = null, $dti = null, $dtf = null, $serv = null, $func = null, $desc = null)
    {

        $tempo = diferencaHorasMinutos($dti, $dtf);
        if($tempo['minutos'] == 0) $tempo['minutos'] = 1;
        $cd_itos = DB::select("select seq_itos.nextval from dual")[0]->nextval;
        $dados_func = Funcionario::where('cd_func', $func)->first();
        return ItSolicitacaoOs::insert([
            'cd_itsolicitacao_os' => $cd_itos,
            'hr_final' => $dtf,
            'hr_inicio' => $dti,
            'vl_tempo_gasto' => $tempo['horas'] ?? 0,
            'cd_os' => $os,
            'cd_func' => $func,
            'cd_servico' => $serv,
            'ds_servico' => $desc,
            'vl_tempo_gasto_min' => $tempo['minutos'] ?? 1,
            'sn_check_list' => 'N',
            'vl_hora' => $dados_func->vl_hora ?? 1
        ]);
    }

    public function sysdate()
    {

        $data = DB::select("select sysdate from dual")[0]->sysdate;
        return $data;

    }

}
