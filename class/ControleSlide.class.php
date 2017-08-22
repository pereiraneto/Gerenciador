<?php 
	class ControleSlide extends Conexao{
		public static $instance;

		private function __construct() {
			//
		}
		
		public static function getInstance(){
        	if (!isset(self::$instance))
            	self::$instance = new ControleSlide();

        	return self::$instance;
    	}

		public function cadastrarSlide(Slide $slide){
			try{
				$sql = "INSERT INTO slide(codigo, codigoUsuario, texto, imagem) VALUES (NULL, :codigoUsuario, :texto, :imagem)";

				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->bindValue(":codigoUsuario", $slide->getCodigoUsuario());
				$p_sql->bindValue(":texto", $slide->getTexto());
				$p_sql->bindValue(":imagem", $slide->getImagem());
				return $p_sql->execute();

			}catch (Exception $e){
				print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            	GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		public function removerSlide($codigo){
			try{
				$sql = "DELETE FROM slide WHERE codigo = :codigo";

				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->bindValue(":codigo", $codigo);
				return $p_sql->execute();
			}catch (Exception $e){
				print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            	GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		public function editarSlide(Slide $slide){
			try{
				$sql = "UPDATE slide SET texto = :texto, imagem = :imagem WHERE codigo = :codigo";

				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->bindValue(":texto", $slide->getTexto());
				$p_sql->bindValue(":imagem", $slide->getImagem());
				$p_sql->bindValue(":codigo", $slide->getCodigo());
				return $p_sql->execute();
			}catch (Exception $e){
				print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            	GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		public function listarSlide(){
			try{
				$sql = "SELECT * FROM slide";

				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->execute();
				return $p_sql->fetchAll();
			}catch (Exception $e){
				print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            	GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		public function getSlide($codigo){
			try{
				$sql = "SELECT * FROM slide WHERE codigo = :codigo";

				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->bindValue(":codigo", $codigo);
				$p_sql->execute();
				return $this->populaSlide($p_sql->fetch(PDO::FETCH_ASSOC));
			}catch (Exception $e){
				print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            	GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		private function populaSlide($row){
			$pojo = new Slide;
			$pojo->setCodigo($row['codigo']);
			$pojo->setTexto($row['texto']);
			$pojo->setImagem($row['imagem']);
			return $pojo;
		}
	}
 ?>
