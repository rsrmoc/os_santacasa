<?php

namespace App\Bibliotecas;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;


class EnvioEmail {

   public function enviar_email($dados) {

      require base_path("vendor/autoload.php");
      $mail = new PHPMailer(true);

      try {

       $mail->IsSMTP(); // envia por SMTP
       $mail->SMTPDebug = 0;
       $mail->SMTPAuth = true;		//
       $mail->Host = "smtp.gmail.com";
       $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
       $mail->Port = 465;  		// A porta 587 deverï¿½ estar aberta em seu servidor
       $mail->Username = 'enviaremail@santacasamontesclaros.com.br'; // SMTP username
       $mail->Password = 'xlgqcuhtwnaqmoua'; // SMTP password
       $mail->From = 'enviaremail@santacasamontesclaros.com.br'; // From
       $mail->FromName = "Santa Casa de Montes Claros"; // Nome de quem envia o email
       //$mail->addAddress($dados['email'],'Funcionario');
       foreach ($dados['email'] as $email) {
            if(trim($email)){
               $mail->addAddress(trim($email), trim($email));
            }
       }
       $mail->WordWrap = 50; // Definir quebra de linha
       $mail->IsHTML(true); // Enviar como HTML
       $mail->Subject = $dados['assunto']; // Assunto
       $mail->Body = $dados['conteudo'];
       $mail->AltBody = "This is the text-only body"; //PlainText, para caso quem receber o email no aceite o corpo HTML
       $mail->SMTPDebug  = 0;

          //Copias
          if(isset($dados['copias'])){
             if($dados['copias']){
                $Ccs=explode(";",$dados['copias']);
                foreach ($Ccs as  $Cc) {
                   if(trim($Cc)){
                      $mail->addCC(trim($Cc), trim($Cc));
                   }

                }
             }
          }

          $mail->isHTML(true);

          if( !$mail->send() ) {
             return false;
          } else {
             return true;
          }

      } catch (Exception $e) {
         return false;
      }

   }


}

