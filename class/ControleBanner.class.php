<?php
	class ControleBanner extends Conexao{

		public static $instance;

	    private function __construct() {
	        //
	    }

		public static function getInstance(){
	    	if (!isset(self::$instance))
	        	self::$instance = new ControleBanner();

	    	return self::$instance;
		}

		public function inserirBanner(Banner $banner){
			try{
				$sql = "INSERT INTO banner(codigo, imagem, codigoUsuario) VALUES (NULL, :imagem, :codigoUsuario)";

				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->bindValue(":imagem", $banner->getImagem());
				$p_sql->bindValue(":codigoUsuario", $banner->getCodigoUsuario());
				return $p_sql->execute();
			}catch (Exception $e){
				print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            	GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		public function deletarBanner($codigo){
			try{
				$sql = "DELETE * FROM banner WHERE codigo = :codigo";

				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->bindValue(":codigo", $codigo);
				return $p_sql->execute();
			}catch (Exception $e){
				print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            	GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		public function listarBanner(){
			try{
				$sql = "SELECT * FROM banner";
				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->execute();
				return $p_sql->fetchAll();
			}catch (Exception $e){
				print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            	GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		public function editarBanner(Banner $banner){
			try{
				$sql = "UPDATE banner SET imagem = :imagem, codigoUsuario = :codigoUsuario  WHERE codigo = :codigo";

				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->bindValue(":codigoUsuario", $banner->getCodigoUsuario());
				$p_sql->bindValue(":imagem", $banner->getImagem());
				$p_sql->bindValue(":codigo", $banner->getCodigo());
				return $p_sql->execute();
			}catch (Exception $e){
				print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            	GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		public function getBanner($codigo){
			try{
				$sql = "SELECT * FROM banner WHERE codigo = :codigo";

				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->bindValue(":codigo", $codigo);
				$p_sql->execute();
				return $this->populaBanner($p_sql->fetch(PDO::FETCH_ASSOC));
			}catch (Exception $e){
				print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            	GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		private function populaBanner($row){
			$pojo = new Banner;
			$pojo->setCodigo($row['codigo']);
			$pojo->setImagem($row['imagem']);
			return $pojo;
		}
	}
 ?>