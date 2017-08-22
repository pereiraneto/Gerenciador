<?php
	class ControleEmail extends Conexao{
		public static $instance;

	    private function __construct() {
	        //
	    }

		public static function getInstance(){
	    	if (!isset(self::$instance))
	        	self::$instance = new ControleEmail();

	    	return self::$instance;
		}

		public function enviarEmail($nome_destinatario, $email_destinatario, $assunto, $mensagem){
			require_once ABSPATH . '/vendor/PHPMailer/class.phpmailer.php';
			$mail = new PHPMailer(true);
			$mail->IsSMTP(); // Define que a mensagem será SMTP

			try {
				$mail->CharSet = 'iso-8859-1';
				//$mail->SMTPSecure = 'ssl';
				$mail->Host = SMTP_HOST; // Endereço do servidor SMTP (Autenticação, utilize o host smtp.seudomínio.com.br)
				$mail->SMTPAuth   = true;  // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
				$mail->Port       = 587; //  Usar 587 porta SMTP
				$mail->Username = SMTP_USERNAME; // Usuário do servidor SMTP (endereço de email)
				$mail->Password = SMTP_PASSWORD; // Senha do servidor SMTP (senha do email usado)
				$mail->isHTML(true);

				//Define o remetente
				// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=    
				$mail->SetFrom(EMAIL_FROM, EMAIL_NAME); //Seu e-mail
				$mail->AddReplyTo(EMAIL_FROM, EMAIL_NAME); //Seu e-mail
				$mail->Subject = utf8_decode($assunto);//Assunto do e-mail
				$mail->Sender = EMAIL_FROM;//Para onde irá a mensagem de erro(caso ocorra).


				//Define os destinatário(s)
				//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
				//$mail->AddAddress('jordao.souza05@gmail.com', 'jord1');
				$mail->AddAddress($email_destinatario, utf8_decode($nome_destinatario));

				//Campos abaixo são opcionais 
				//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
				//$mail->AddCC('jordao.souza05@gmail.com', 'Destinatario2'); // Copia
				//$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
				//$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo


				//Define o corpo do email
				$mail->MsgHTML(utf8_decode($mensagem)); 

				////Caso queira colocar o conteudo de um arquivo utilize o método abaixo ao invés da mensagem no corpo do e-mail.
				//$mail->MsgHTML(file_get_contents('arquivo.html'));

				$mail->Send();
				return true;
				//caso apresente algum erro é apresentado abaixo com essa exceção.
			}catch (phpmailerException $e) {
				print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            	GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
			return false;
		}

		public function listaEmails(){
			$sql = 'SELECT * FROM email ORDER BY email ASC';

			$p_sql = Conexao::getInstance()->prepare($sql);
			$p_sql->execute();

			return $p_sql->fetchAll();
		}
	}
 ?>