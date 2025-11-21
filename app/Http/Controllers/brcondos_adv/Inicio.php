<?php

namespace App\Http\Controllers\brcondos_adv;

use App\Http\Controllers\Controller;
use App\Models\Boleto;
use App\Models\Condominio;
use App\Models\Hospital;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Inicio extends Controller
{
    public function cadastro() {
        $hospitais = Hospital::all();
        $produtos = Produto::all();

        return view('index', [
            'hospitais' => $hospitais,
            'produtos' => $produtos,
        ]);
    }

    public function home() {
 
        return view('brcondos_adv.inicial/inicial');
    }

    public function login() {
        return view('login');
    }
    
    public function bot() {
        echo "<pre>";
        set_time_limit(8000000);
        $array= Condominio::where('br_condos','S')->where('sn_ativo','S')->get();
        foreach($array as $val){
            $condominios[]=$val->cd_condominio;
        } 
        $dados=FUNC_DADOS_BRCONDOS($condominios,null,null,null,null,null,'2022-01-01','2023-12-31', $timeout = 30,"REC","REC_ABERTO");
    }

    public function bot_pag() {
        echo "<pre>";
        set_time_limit(8000000);
        $array= Condominio::where('br_condos','S')->where('sn_ativo','S')/*->whereRaw("cd_condominio in (1302,1730,2354,1874,2322,874)")*/->get();
        foreach($array as $val){
            $condominios[]=$val->cd_condominio;
        } 
        echo "<pre>";
        $dados=FUNC_DADOS_BRCONDOS($condominios,null,null,null,null,null,'2022-01-01','2023-12-31', $timeout = 30,"PAG","");
        foreach ($dados as $condominio => $boletos) {
            foreach ($boletos as $key => $val) {
                 
                $Array = array(
                    'cd_condominio'=> $condominio,
                    'fornecedor'=> $val['Supplier'],
                    'DateSchedule'=>$val['DateSchedule'],
                    'DateRecord'=>$val['DateRecord'],
                    'DateExpire'=>$val['DateExpire'],
                    'DatePaid'=>$val['DatePaid'],
                    'DateIssue'=>$val['DateIssue'],
                    'ValuePaid'=>$val['ValuePaid'],
                    'ValueTotal'=>$val['ValueTotal'],
                    'Details'=>$val['Details'],
                    'BilletID'=>$val['BilletID'],
                    'StatusEnumDescription'=>$val['StatusEnumDescription'], 
                );
                print_r($Array);
                DB::table('con_pag')->insert($Array);

            }
             
        }
    }
}
