<?php
//Recebe variáveis
$nome = $_POST['nome_'];
$email = $_POST['email_'];
$telefone = $_POST['telefone_'];
$mensagem = $_POST['mensagem_'];

// pega template

$assunto = utf8_decode('Contato Enviado Através do Site');

$tpl = file_get_contents('templates/template.email.sf.html');
$tpl = str_replace('[#data#]', date("d/m/Y"), $tpl);
$tpl = str_replace('[#hora#]', date("H:i"), $tpl);
$tpl = str_replace('[#nome#]', $_POST['nome_'], $tpl);
$tpl = str_replace('[#email#]', $_POST['email_'], $tpl);
$tpl = str_replace('[#telefone#]', $_POST['telefone_'], $tpl);
$linhas = array("<br />","<br>","<br/>");
$tpl = str_replace($linhas, "\n", $tpl);
$message = str_replace("\n", nl2br("\n"), utf8_decode($_POST['mensagem_']));
$tpl = str_replace('[#mensagem#]', $message, $tpl);
$message = $tpl;
$message = html_entity_decode($message);

require 'classes/phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.host';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'smtp.user';                 // SMTP username
$mail->Password = 'smtp.password';                           // SMTP password
//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to
$mail->CharSet = "iso-8859-1";    
$mail->setFrom('from@address.com', 'website');
$mail->addAddress('to@addres.com', 'website');     // Add a recipient
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
$mail->addBCC('the@copy.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML



$mail->Subject = $assunto;
$mail->Body    = $message;
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if($mail->send()) {
    echo "true";
} else {
    echo "false";
}
?>