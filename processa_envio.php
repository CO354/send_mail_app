<?php 
	
	require("./bibliotecas/PHPMailer/Exception.php");
	require("./bibliotecas/PHPMailer/OAuth.php");
	require("./bibliotecas/PHPMailer/PHPMailer.php");
	require("./bibliotecas/PHPMailer/POP3.php");
	require("./bibliotecas/PHPMailer/SMTP.php");
	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	

	class Mensagem{
		private $para = null;
		private $assunto = null;
		private $mensagem = null;
		public 	$status = array('codigo_status' => null, 'descricao_status' => '');


		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}

		public function mensagemValida(){
			if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)){
				return false;
			}
			return true;
		}
	}	

	$mensagem = new Mensagem();

	$mensagem->__set('para', $_POST['para']);
	$mensagem->__set('assunto', $_POST['assunto']);
	$mensagem->__set('mensagem', $_POST['mensagem']);

	// print_r($mensagem);

	
	if(!$mensagem->mensagemValida()){
		echo 'Mensagem enviada não é valida';
		header("Location: index.php?send=error");
	}

	$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                      				//Enable verbose debug output
    $mail->isSMTP();                                         //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'buanalitos@gmail.com';                     //SMTP username
    $mail->Password   = '@bigbang007E';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('buanalitos@gmail.com', 'Buana Aly'); 	//Remetente
    $mail->addAddress($messagem->__get('para'));     //Add a recipient
    // $mail->addReplyTo('info@example.com', 'Information');	 // Add third user for answer 

    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments

    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $mensagem->__get('assunto');
    $mail->Body    = $mensagem->__get('mensagem');
    $mail->AltBody = 'E necessario utilizar um cliente que suporte HTML para ter acesso total ao conteudo dessa mensagem';

    $mail->send();

    $mensagem->status['codigo_status'] = 1;
    $mensagem->status['descricao_status'] = 'E-mail enviado com sucesso!';
   

} catch (Exception $e) {
	 $mensagem->status['codigo_status'] = 2;

    $mensagem->status['descricao_status'] = 'Nao foi possivel enviar este email, tente novamente mais tarde. Detalhes do erro: ' . $mail->ErrorInfo;

}

?>




