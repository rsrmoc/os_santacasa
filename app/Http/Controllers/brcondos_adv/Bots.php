<?php

namespace App\Http\Controllers\brcondos_adv;

use App\Http\Controllers\Controller;
use App\Models\Boleto;
use App\Models\Condominio;
use Illuminate\Http\Request;

class Bots extends Controller
{
    public function rotina() {
        ini_set('max_execution_time', 1800); //10 minutos
         $Condominios=Condominio::where('sn_ativo','S')->get();
         $SnRotina='N';
         foreach ($Condominios as $key => $Cond) {
            $ArrayCondominios[]=$Cond->cd_condominio;
            $SnRotina='S';
         }
 
 
         if($SnRotina=='S'){

            echo $dados=FUNC_DADOS_BRCONDOS("matheusamaraladvogado@gmail.com","genqo9-nYvmen-hihgam", $ArrayCondominios, 1, '', 1, "01/01/2023", "31/01/2023",null,"REC"); 

            /*
            foreach ($dados as $key => $Condominios) {
                $ID_CONDOMINIO = $key; 
                echo '<code>'.$ID_CONDOMINIO.'</code> <br>';
                foreach($Condominios as $Boletos){
                    echo $Boletos['BilletID'].'<br>';
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
                            'cpf_cnpj'=> $Boletos['CPFCNPJ'],
                            'tipo_conta'=> mb_strtoupper($Boletos['Status']),
                            'status'=> mb_strtoupper($Boletos['StatusEnumDescription']),
                            'tp_status'=> $Boletos['StatusEnumClassCss'],
                            'sn_atrasado'=> $Boletos['Overdue'],
                            'forma_pag'=> $Boletos['FormOfPayment'],
                            'centro_custo'=> $Boletos['CostCenter'],
                            'impresso_boleto'=> $Boletos['ReceivePrintBillet'], 
                        );
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
                        Boleto::where('id_boleto',$Boletos['BilletID'])->where('cd_condominio',$ID_CONDOMINIO)->update($ArrayBoleto);
                        
                    }
                     
                }
    
            }
            */
         }

    }
 

     
}
