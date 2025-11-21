<?php

namespace App\Http\Controllers\brcondos_adv;

use App\Http\Controllers\Controller;
use App\Models\Boleto;
use App\Models\Condominio;
use App\Models\Hospital;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Integracoes extends Controller
{
    public function lista_rec(Request $request) {
        
        $condominios = Condominio::orderBy('nm_condominio')->get(); 
        return view('brcondos_adv.integracao.con_rec', compact('condominios'));

    }
  
    public function store_rec(Request $request) {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 1800); //10 minutos
        $request->validate([
            'dti' => 'required|date',
            'dtf' => 'required|date',
            'tipo' => 'required|string|max:20',
            'nome' => 'nullable|string|max:100',
            'cpf' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:1', 
            'excluido' => 'nullable|string|max:1',
            'condominios' => 'nullable|array' 
        ]);
        
        try {
              
            $nome=$request['nome']; 
            $cpf=$request['cpf']; 
            $Tipo=$request['tipo']; 
            $dti= date_format(date_create($request['dti']),"d/m/Y");
            $dtf= date_format(date_create($request['dtf']),"d/m/Y"); 
            $status=$request['status'];
            $excluido=$request['excluido'];
            if(empty($request['condominios'])){
                $array= Condominio::where('br_condos','S')->where('sn_ativo','S')->get();
                foreach($array as $val){
                    $condominios[]=$val->cd_condominio;
                } 
            }else{
                $condominios=$request['condominios'];
            }    
            $dados=FUNC_DADOS_BRCONDOS($condominios, $status, $cpf, $nome, $excluido, $Tipo, $dti, $dtf, $timeout = 30,"REC");
            /*
            foreach ($dados as $key => $Condominios) {
                $ID_CONDOMINIO = $key;  
                foreach($Condominios as $Boletos){ 
                    if(!Boleto::where('id_boleto',$Boletos['BilletID'])->where('cd_condominio',$ID_CONDOMINIO)->first()){ 
                        $ArrayBoleto=array(
                            'id_boleto'=> $Boletos['BilletID'],
                            'nr_documento'=> $Boletos['Document'],
                            'cd_condominio'=>$ID_CONDOMINIO,
                            'bloco_apto'=> $Boletos['Detail'],
                            'bloco'=> '',
                            'apto'=> '',
                            'nosso_numero'=> $Boletos['NossoNumero'],
                            'nm_cliente'=> $Boletos['UserFullName'],
                            'grupo_historico'=> $Boletos['HistoricGroup'],
                            'fone'=> $Boletos['BilletUnitTelephone'],
                            'id_unidade'=> $Boletos['UnitID'],
                            'dt_vencimento'=> $Boletos['DateExpireOriginal'],
                            'dt_registro'=> $Boletos['DateRecord'],
                            'dt_emissao'=> $Boletos['DateIssue'],
                            'dt_pago'=> $Boletos['DatePaid'],
                            'dt_expiracao'=> $Boletos['DateExpire'],
                            'vl_boleto'=> $Boletos['Value'],
                            'vl_pago'=> $Boletos['ValuePaid'],
                            'vl_desconto'=> $Boletos['ValueDiscount'],
                            'vl_juros'=> $Boletos['ValueInterest'],
                            'vl_multa'=> $Boletos['ValueMulta'],
                            'vl_total'=> $Boletos['ValueTotal'],
                            'detalhes'=> $Boletos['Details'], 
                            'ds_conta'=> $Boletos['AccountName'],
                            'cpf_puro' => trim(preg_replace('/[^0-9]/', '', $Boletos['CPFCNPJ'])),
                            'cpf_cnpj'=> $Boletos['CPFCNPJ'],
                            'tipo_conta'=> mb_strtoupper($Boletos['Status']),
                            'status'=> mb_strtoupper($Boletos['StatusEnumDescription']),
                            'tp_status'=> $Boletos['StatusEnumClassCss'],
                            'sn_atrasado'=> $Boletos['Overdue'],
                            'forma_pag'=> $Boletos['FormOfPayment'],
                            'centro_custo'=> $Boletos['CostCenter'],
                            'impresso_boleto'=> $Boletos['ReceivePrintBillet'], 
                        );
                        echo " <b>Insert</b> " . $Boletos['BilletID'].'<br><br>';
                        print_r($ArrayBoleto);
                        Boleto::create($ArrayBoleto);
    
                    }else{
    
                        $ArrayBoleto=array( 
                            'nr_documento'=> $Boletos['Document'], 
                            'bloco_apto'=> $Boletos['Detail'],
                            'bloco'=> '',
                            'apto'=> '',
                            'nosso_numero'=> $Boletos['NossoNumero'],
                            'nm_cliente'=> $Boletos['UserFullName'],
                            'grupo_historico'=> $Boletos['HistoricGroup'],
                            'fone'=> $Boletos['BilletUnitTelephone'],
                            'id_unidade'=> $Boletos['UnitID'],
                            'dt_vencimento'=> $Boletos['DateExpireOriginal'],
                            'dt_registro'=> $Boletos['DateRecord'],
                            'dt_emissao'=> $Boletos['DateIssue'],
                            'dt_pago'=> $Boletos['DatePaid'],
                            'dt_expiracao'=> $Boletos['DateExpire'],
                            'vl_boleto'=> $Boletos['Value'],
                            'vl_pago'=> $Boletos['ValuePaid'],
                            'vl_desconto'=> $Boletos['ValueDiscount'],
                            'vl_juros'=> $Boletos['ValueInterest'],
                            'vl_multa'=> $Boletos['ValueMulta'],
                            'vl_total'=> $Boletos['ValueTotal'],
                            'detalhes'=> $Boletos['Details'], 
                            'ds_conta'=> $Boletos['AccountName'],
                            'cpf_cnpj'=> $Boletos['CPFCNPJ'],
                            'tipo_conta'=> mb_strtoupper($Boletos['Status']),
                            'status'=> mb_strtoupper($Boletos['StatusEnumDescription']),
                            'tp_status'=> $Boletos['StatusEnumClassCss'],
                            'sn_atrasado'=> $Boletos['Overdue'],
                            'forma_pag'=> $Boletos['FormOfPayment'],
                            'centro_custo'=> $Boletos['CostCenter'],
                            'impresso_boleto'=> $Boletos['ReceivePrintBillet'], 
                        );
                        echo " <b>Update</b> " . $Boletos['BilletID'].'<br><br>';
                        print_r($ArrayBoleto);
                        Boleto::where('id_boleto',$Boletos['BilletID'])->where('cd_condominio',$ID_CONDOMINIO)->update($ArrayBoleto); 

                    } 
                } 
            }
            */
           return response()->json(['message' => 'Rotina Atualizada com sucesso!']);
         
        }
        catch(\Exception $e) {
            return response()->json(['message' => 'Houve um erro ao atualizar a Rotina! '.$e->getMessage()], 500);
        }
    }
   
    public function lista_pag(Request $request) {

        $condominios = Condominio::orderBy('nm_condominio')->get(); 
        return view('brcondos_adv.integracao.con_pag', compact('condominios'));

    }
    public function store_pag(Request $request) {
        
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 1800); //10 minutos
        
        $request->validate([
            'dti' => 'required|date',
            'dtf' => 'required|date',
            'tipo' => 'required|string|max:20',
            'status' => 'nullable|string|max:1', 
            'cpf' => 'nullable|string|max:100',
            'excluido' => 'nullable|string|max:1',
            'condominios' => 'nullable|array' 
        ]);
        
        try {

            $nome=$request['nome']; 
            $cpf=$request['cpf']; 
            $Tipo=$request['tipo']; 
            $dti= date_format(date_create($request['dti']),"d/m/Y");
            $dtf= date_format(date_create($request['dtf']),"d/m/Y"); 
            $status=$request['status'];
            $excluido=$request['excluido'];
            if(empty($request['condominios'])){
                $array= Condominio::where('br_condos','S')->where('sn_ativo','S')->get();
                foreach($array as $val){
                    $condominios[]=$val->cd_condominio;
                } 
            }else{
                $condominios=$request['condominios'];
            } 

            $dados=FUNC_DADOS_BRCONDOS($condominios, $status, $cpf, $nome, $excluido, $Tipo, $dti, $dtf, $timeout = 30,"PAG");
  

            return response()->json(['message' => 'Rotina Atualizada com sucesso!']);
        }
        catch(\Exception $e) {
            return response()->json(['message' => 'Houve um erro ao atualizar a Rotina! '.$e->getMessage()]);
        }
         
    }
}
