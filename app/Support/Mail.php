<?php
	namespace App\Support;

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	class Mail{

		public static function sendEmailConfirmationCode(string $email, string $name, string $code){
			$mail = new PHPMailer(true);

			try {
				$mail->isSMTP();                                            //Send using SMTP
				$mail->Host       = 'mail.sigim.co.mz';                     //Set the SMTP server to send through
				$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
				$mail->Username   = 'no-replay@sigim.co.mz';                     //SMTP username
				$mail->Password   = 'Sebastiao73!';                               //SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
				$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
				$mail->CharSet	  = "UTF-8";
				//Recipients
				$mail->setFrom('no-replay@sigim.co.mz', 'UR - Registo Academico');
				$mail->addAddress($email, $name);  

				$mail->isHTML(true);                                  //Set email format to HTML
				$mail->Subject = 'Envio de código de confirmação';
				$mail->Body = 'Este é o seu código de confirmação: <span font-size: 15pt;><strong>'. $code. '</strong></span>';

				$mail->send();
			} catch (Exception $e) {
				//dd($e->getMessage());
				return false;
			}

			return true;
		}
	}
?>