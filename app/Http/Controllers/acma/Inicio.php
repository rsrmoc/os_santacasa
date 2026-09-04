<?php

namespace App\Http\Controllers\acma;

use App\Http\Controllers\Controller;
use App\Models\Boleto;
use App\Models\Condominio;
use App\Models\Contrato;
use App\Models\Hospital;
use App\Models\mv\Funcionario;
use App\Models\mv\OsConfig;
use App\Models\mv\SolicitacaoOs;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Inicio extends Controller
{


    public function home() {


        return view('acma.inicial/inicial');
    }

    public function login() {
        return view('login');
    }

    public function json(Request $request) {

        $Config = OsConfig::find(Auth::user()->cd_oficina);
        $header01 = SolicitacaoOs::whereIn('tp_situacao', ['A','S'])
        ->leftJoin('dbacaixa.classificacao_os', 'solicitacao_os.cd_os', '=', 'classificacao_os.cd_os')
        ->where("cd_oficina", Auth::user()->cd_oficina)
        ->toBase()->selectRaw("count(*) as total,
                    sum(case when classificacao_os.dt_prazo is null then 1 else 0 end) as aprazamento,
                    sum(case when classificacao_os.responsavel is null then 1 else 0 end) as classificacao,
                    sum(case when classificacao_os.dt_prazo is not null and trunc(classificacao_os.dt_prazo) <=trunc(sysdate) then 1 else 0 end) as dentro_prazo,
                    sum(case when classificacao_os.dt_prazo is not null and trunc(classificacao_os.dt_prazo) >trunc(sysdate) then 1 else 0 end) as fora_prazo,
                    sum(case when solicitacao_os.cd_tipo_os in (337,338) then 1 else 0 end) as projetos,
                    sum(case when solicitacao_os.cd_tipo_os not in (337,338) then 1 else 0 end) as suporte")
        ->first();

        $table = Funcionario::whereRaw( "funcionario.cd_func in (" . ($Config->funcionarios ?? '00') . ") " )
        ->leftJoin("dbacaixa.classificacao_os", 'funcionario.cd_func', '=', 'classificacao_os.responsavel')
        ->leftJoin("dbamv.solicitacao_os", 'classificacao_os.cd_os', '=', 'solicitacao_os.cd_os')
        ->whereRaw("solicitacao_os.tp_situacao in ('A','S')")
        ->selectRaw("funcionario.cd_func, nm_func,  count(distinct(solicitacao_os.cd_os)) as total_os,
        sum(case when classificacao_os.dt_prazo is null  then 1 else 0 end) as aguardando_aprazamento,
        sum(case when classificacao_os.dt_prazo is not null and trunc(classificacao_os.dt_prazo) > trunc(sysdate) then 1 else 0 end) as vencido,
        sum(case when classificacao_os.dt_prazo is not null and trunc(classificacao_os.dt_prazo) <= trunc(sysdate) then 1 else 0 end) as a_vencer,
        sum(case when solicitacao_os.cd_tipo_os in (337,338) then 1 else 0 end) as projetos,
        sum(case when solicitacao_os.cd_tipo_os not in (337,338) then 1 else 0 end) as suporte")
        ->groupBy('funcionario.cd_func', 'nm_func')
        //->whereRaw("cd_oficina = ?", [Auth::user()->cd_oficina])
        ->orderBy('nm_func')
        ->get();

        return response()->json(['header' => $header01, 'table' => $table]);

    }





}
