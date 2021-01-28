
 <?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



// Load Composer's autoloader
require '../vendor/autoload.php';


//pegando email objeto
function enviarEmail($status, $conteudo, $email){
	// Instantiation and passing `true` enables exceptions
	$mail = new PHPMailer(true);
	try {
		//Server settings
		$mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output
		$mail->isSMTP();                                            // Send using SMTP
		$mail->Host = 'smtp.gmail.com';                 			// Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$mail->Username   = 'gian15249@gmail.com';                     // SMTP username
		$mail->Password   = 'erwpbrbiegwkqpti';                               // SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

		//Recipients
		$mail->setFrom('gian15249@gmail.com', 'Gian Lucas');
		$mail->addAddress($email);     // Add a recipient
		//$mail->addAddress('ellen@example.com');               // Name is optional
		//$mail->addReplyTo('info@example.com', 'Information');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		// Attachments
		//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		$mail->addAttachment('../public/pdf.pdf');    // Optional name

		// Content
		$mail->isHTML(true); // Set email format to HTML
		
		//verifica o status da entrega e modifica o assunto do email
		if($status == 'Encomenda entregue!')
		{
			$status = 'Entregue';
		}
		else if($status == 'Objeto postado após o horário limite da unidade' or $status == 'Objeto postado')
		{
			$status = 'Postado';
		}
		else if($status == 'Objeto em trânsito - por favor aguarde')
		{
			$status = 'Encaminhado';
		}
		else if($status == 'Objeto saiu para entrega ao destinatário')
		{
			$status == 'Objeto saiu para entrega ao destinatário';
		}
		else
		{
			$status = 'Erro';
		}
		
		
		
		
					
		$mail->Subject = $status;
		$mail->Body    = $conteudo;

		$mail->send();
		
	} catch (Exception $e) {
		echo "Email não enviado, motivo: {$mail->ErrorInfo}";
	}
}