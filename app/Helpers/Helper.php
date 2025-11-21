<?php

use App\Models\Boleto;
use App\Models\Bot;
use Illuminate\Support\Facades\Auth;

const CONTROLE_DATA = [
    'V' => 'dt_vencimento',
    'P' => 'dt_pago',
    'E' => 'dt_emissao' 
];


function USER_LOGADO(){
   return  Auth::user()->id;
}
function PAGINACAO_HTML($pagina){
    
    $_limit=$pagina['linha_pagina'];
    $_total=$pagina['total'];
    $links = 7; 
    $_page = $pagina['pag_atual']; 
    $list_class = " pagination ";
     
    if($_total > $pagina['linha_pagina']){
        
        $last       = ceil( $_total / $_limit );
    
        $start      = ( ( $_page - $links ) > 0 ) ? $_page - $links : 1;
        $end        = ( ( $_page + $links ) < $last ) ? $_page + $links : $last;
        
        
        $html       = '<ul class="' . $list_class . '">';
    
        $class      = ( $_page == 1 ) ? "disabled" : "";
        $html       .= '<li class=" page-item ' . $class . '"><a href="#" x-on:click="setPageBoletos(' . ( $_page  ) . ')" >Anterior</a></li>';
    
        if ( $start > 1 ) {
            $html   .= '<li><a href="?limit=' . $_limit . '&page=1">1</a></li>';
            $html   .= '<li class=" page-item disabled"><span>...</span></li>';
        }
    
        for ( $i = $start ; $i <= $end; $i++ ) {
            $class  = ( $_page == $i ) ? "active" : "";
            $html   .= '<li class=" page-item ' . $class . '"><a href="#" x-on:click="setPageBoletos(' . ( $i  ) . ')">' . $i . '</a></li>';
        }
    
        if ( $end < $last ) {
            $html   .= '<li class=" page-item disabled"><span>...</span></li>';
            $html   .= '<li ><a href="#" x-on:click="setPageBoletos(' . ( $last ) . ')">' . $last . '</a></li>';
        }
    
        $class      = ( $_page == $last ) ? "disabled" : "";
        $html       .= '<li class=" page-item ' . $class . '"><a href="#" x-on:click="setPageBoletos(' . ( $_page ) . ')">Próximo</a></li>';
    
        $html       .= '</ul>';
    
    } else {  $html = ''; }

    return $html;






    /*
    $Pag='
    <nav aria-label="...">
        <ul class="pagination">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Anterior</a>
            </li>';
            for ($x = 1; $x <= ( ($pagina['ultima_pagina']>10)? 10 : $pagina['ultima_pagina'] ); $x++) {

                $Pag = $Pag . '
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active">
                    <a class="page-link" href="#">2 <span class="sr-only">(atual)</span></a>
                </li> 
                <li class="page-item"><a class="page-link" href="#">3</a></li>';
                

            }
            $Pag = $Pag . '<li class="page-item">
                <a class="page-link" href="#">Próximo</a>
            </li>
        </ul>
    </nav>
    ';
    return $Pag;
    */
}

function FUNC_ABREV_COND($nome){
    $array1=array('MTC - CONDOMINIO DO ','MTC - CONDOMINIO ','MTC - ');
    $array2=array('','','');

    return str_replace($array1, $array2, $nome);
}


 

function FUNC_DADOS_BRCONDOS($id_do_condominio=array(), $status, $Cpf, $Nome, $excluidos, $Tipo, $data_inicio, $data_fim, $timeout = 30,$RecPag,$snBOT=null){


    if($snBOT=='REC_ABERTO'){
        echo "<table border='1'>";
        echo "<tr>";
        echo "<td> DATA  </td>";
        echo "<td> ".$data_inicio." </td>";
        echo "<td>  ".$data_fim." </td>";
        echo "</tr>";
        echo "</table>";
   }

    $BOT=Bot::where('cd_bot','BR')->first();
    $email=$BOT->usuario;
    $senha=$BOT->senha;
    if(count($id_do_condominio)>0){

        $cookie = "cookie.txt";
        file_put_contents($cookie, null);
        
        $headers = array(
        "X-Requested-With: XMLHttpRequest",
        "Origin: https://ssl.brcondos.com.br"
        );
        
        $ch = curl_init("https://ssl.brcondos.com.br/Auth/Index");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"Login=$email&Password=$senha");
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $retorno = curl_exec($ch);
        curl_close($ch);

        $ch = curl_init("https://ssl.brcondos.com.br/Me/Index?isLogin=S");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $retorno = curl_exec($ch);
        curl_close($ch);
    
        $headers = array(
        "X-Requested-With: XMLHttpRequest",
        "Origin: https://ssl.brcondos.com.br",
        "Referer: https://ssl.brcondos.com.br/Admin/FranchiseMessage?MessageId=29"
        );

        $RETORNO=array();
        foreach($id_do_condominio as $ID){ 
            sleep(2);
            $ch = curl_init("https://ssl.brcondos.com.br/Admin/AdminAccount/ChangeCurrentCondo");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,"condoID=$ID");
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            $retorno = curl_exec($ch);
            curl_close($ch);

            //CONTAS A RECEBER
            if($RecPag=='REC'){
              
                if($snBOT==null){
                    $LINK = "https://ssl.brcondos.com.br/Admin/FINReports/ReceivableResult?IsUnit=True&UserIsBearer=False&CondoNameToBearer=&CondoIDToBearer=&DateStart=".urlencode($data_inicio)."&DateEnd=".urlencode($data_fim)."&TypeDate=".$Tipo."&CondoWing_ID=0&Account_ID=0&Status_ID=0&CostCenter_ID=0&ShareClosure_ID=0&ValueFilterMin=0%2C00&ValueFilterMax=0%2C00&UserFullName=".urlencode($Nome)."&CPFCNPJ=".$Cpf."&NossoNumero=&Status=".$status."&Excluded=".$excluidos."&ReceivePrintBillet=0&Address=0&InterestOrFine=0&NotDisplayGroupBillet=false";
                }
                if($snBOT=='REC_ABERTO'){
                    $LINK = "https://ssl.brcondos.com.br/Admin/FINReports/ReceivableResult?IsUnit=True&UserIsBearer=False&CondoNameToBearer=&CondoIDToBearer=&DateStart=".urlencode($data_inicio)."&DateEnd=".urlencode($data_fim)."&TypeDate=Vencimento&CondoWing_ID=0&Account_ID=0&Status_ID=0&CostCenter_ID=0&ShareClosure_ID=0&ValueFilterMin=0%2C00&ValueFilterMax=0%2C00&UserFullName=&CPFCNPJ=&NossoNumero=&Status=1&Excluded=0&ReceivePrintBillet=0&Address=0&InterestOrFine=0&NotDisplayGroupBillet=false";
                    //echo "<br>".$LINK."<br>";
                }
                $ch = curl_init($LINK);
                

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                $retorno = curl_exec($ch);
                curl_close($ch);

                $dataJson = explode('var dataJson = (', $retorno);
                $dataJson = explode(');', $dataJson[1])[0]; 
                $dataJson  = json_decode($dataJson, true); 
                $ListaBoletos=$dataJson; 

                $dataJsonAcordo = explode('viewmodelUnits.loadData(', $retorno);
                $dataJsonAcordo = explode(');', $dataJsonAcordo[1])[0]; 
                if(trim($dataJsonAcordo)){
                    $dataJsonAcordo  = json_decode($dataJsonAcordo, true); 
                    $ListaAcordos=$dataJsonAcordo; 
                }else{
                    $ListaAcordos= null;
                }
                /*
                if($snBOT=='REC_ABERTO'){
                    echo "<h1>LISTA BOLETOS</h1>";
                    print_r($ListaBoletos); 
                    echo "<h1>LISTA ACORDOS</h1>";
                    print_r($ListaAcordos);
                }
                */

                    $ID_CONDOMINIO = $ID;  
                    /* Boletos */
                    $BOLETOS=0;
                    foreach($ListaBoletos as $KEY_BOLETO => $Boletos){
                        $BOLETOS=($BOLETOS+1);
                         $Boletos['BilletID'];
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

                    /* Acordos */
                    $ACORDOS=0;
                    foreach($ListaAcordos as $KEY_ACORDO =>  $Boletos){
                        $ACORDOS=($ACORDOS+1);
                        $Boletos['BilletID'];
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

                   if($snBOT=='REC_ABERTO'){
                        echo "<table border='1'>";
                        echo "<tr>";
                        echo "<td> CONDOMINIO = ".$ID." </td>";
                        echo "<td> BOLETOS = ".$BOLETOS." </td>";
                        echo "<td> ACORDOS = ".$ACORDOS." </td>";
                        echo "</tr>";
                        echo "</table>";
                   }
            }
             
            //CONTAS A PAGAR
            if($RecPag=='PAG'){
                  
                
                $LINK = "https://ssl.brcondos.com.br/Admin/FINReports/PayableResult?DateStart=".urlencode($data_inicio)."&DateEnd=".urlencode($data_fim)."&TypeDate=".$Tipo."&Supplier_ID=0&Account_ID=0&CostCenter_ID=0&ValueFilterMin=0%2C00&ValueFilterMax=0%2C00&CPFCNPJ=".$Cpf."&Status=".$status."&Approved=0&Schedule=0&DocumentSendItsPaid=0&FormOfPaymentIsDebitoAutomatico=0&Excluded=".( ($excluidos) ? $excluidos : 0 )."&NotDisplayGroupBillet=true&NotDisplayGroupBillet=false";    
                $LINK = "https://ssl.brcondos.com.br/Admin/FINReports/PayableResult?DateStart=01%2F01%2F2023&DateEnd=30%2F06%2F2023&TypeDate=Vencimento&Supplier_ID=0&Account_ID=0&CostCenter_ID=0&ValueFilterMin=0%2C00&ValueFilterMax=0%2C00&CPFCNPJ=24.532.147%2F0001-90&Status=0&Approved=0&Schedule=0&DocumentSendItsPaid=0&FormOfPaymentIsDebitoAutomatico=0&Excluded=0&NotDisplayGroupBillet=true&NotDisplayGroupBillet=false";
                $ch = curl_init($LINK);
  
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                $retorno = curl_exec($ch);
                curl_close($ch);
 
                $dataJson = explode('var tmpArray =', $retorno);  
                if(isset($dataJson[1])){
                    $dataJson = explode('];', $dataJson[1])[0].']'; 
                    $dataJson  = json_decode($dataJson, true); 
                    $RETORNO[$ID]=$dataJson;
                } 

            }


        }
        if($RecPag=='PAG'){
            return $RETORNO;
        }
        return true;
      
    }
}
