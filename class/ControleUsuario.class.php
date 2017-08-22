<?php 
class ControleUsuario extends Conexao{

	public static $instance;

    private function __construct() {
        //
    }
	
	public static function getInstance(){
    	if (!isset(self::$instance))
        	self::$instance = new ControleUsuario();

    	return self::$instance;
	}

	public function adicionarUsuario(Usuario $usuario){
		try{
			$sql = "INSERT INTO usuario(codigo, nome, email, senha, foto, user_permissions, session_id) VALUES (NULL, :nome, :email, :senha, :foto, :permissoes, :session_id);";

			$p_sql = Conexao::getInstance()->prepare($sql);

			$p_sql->bindValue(":nome", $usuario->getNome());
			$p_sql->bindValue(":email", $usuario->getEmail());
			$p_sql->bindValue(":senha", $usuario->getSenha());
			$p_sql->bindValue(":foto", $usuario->getFoto());
			$p_sql->bindValue(":permissoes", $usuario->getPermissoes());
			$p_sql->bindValue(":session_id", $usuario->getSessionID());

			return $p_sql->execute();
		}catch (Exception $e){
			print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
        	GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
		}
	}

	public function deletarUsuario($codigo){
		try{
			$sql = "DELETE FROM usuario WHERE codigo = :codigo";

			$p_sql = Conexao::getInstance()->prepare($sql);
			$p_sql->bindValue(":codigo", $codigo);
			return $p_sql->execute();
		}catch (Exception $e){
			print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
        	GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
		}
	}

	public function listarUsuarios(){
		try{
			$sql = "SELECT * FROM usuario";
			$p_sql = Conexao::getInstance()->prepare($sql);
			$p_sql->execute();
			return $p_sql->fetchAll();
		}catch (Exception $e){
			print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
        	GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
		}
	}

	public function getUsuario($codigo){
		try{
			$sql = "SELECT * FROM usuario WHERE codigo = :codigo";
			$p_sql = Conexao::getInstance()->prepare($sql);
			$p_sql->bindValue(":codigo", $codigo);
			$p_sql->execute();
			return $this->populaUsuario($p_sql->fetch(PDO::FETCH_ASSOC));
		}catch (Exception $e){
			print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
        	GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
		}
	}

	public function getUsuarioByEmail($email){
		try{
			$sql = "SELECT * FROM usuario WHERE email = :email";
			$p_sql = Conexao::getInstance()->prepare($sql);
			$p_sql->bindValue(":email", $email);
			$p_sql->execute();
			return $this->populaUsuario($p_sql->fetch(PDO::FETCH_ASSOC));
		}catch (Exception $e){
			print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
        	GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
		}
	}

	private function populaUsuario($row) {
    	$pojo = new Usuario;
    	$pojo->setCodigo($row['codigo']);
    	$pojo->setNome($row['nome']);
    	$pojo->setEmail($row['email']);
    	$pojo->setSenha($row['senha']);
    	$pojo->setFoto($row['foto']);
    	$pojo->setPermissoes($row['user_permissions']);
    	$pojo->setSessionID($row['session_id']);
    	return $pojo;
	}

	public function autentica($email, $senha){
		$sql = "SELECT email, senha FROM usuario WHERE email = :email AND senha = :senha";

		$p_sql = Conexao::getInstance()->prepare($sql);
		$p_sql->bindValue(":email", $email);
		$p_sql->bindValue(":senha", $senha);
		$p_sql->execute();

		$row_cnt = $sql->num_rows;
		if($row_cnt == 1){
			return true;
		}
		return false;
	}

	public function editarPerfil(Usuario $usuario){
		try{
			$sql = "UPDATE usuario SET nome = :nome, email = :email, senha = :senha, foto = :foto, user_permissions = :permissoes WHERE codigo = :codigo";
			$p_sql = Conexao::getInstance()->prepare($sql);
			$p_sql->bindValue(":nome", $usuario->getNome());
			$p_sql->bindValue(":email", $usuario->getEmail());
			$p_sql->bindValue(":senha", $usuario->getSenha());
			$p_sql->bindValue(":foto", $usuario->getFoto());
			$p_sql->bindValue(":codigo", $usuario->getCodigo());
			$p_sql->bindValue(":permissoes", $usuario->getPermissoes());
			return $p_sql->execute();
		}catch (Exception $e){
			print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
		}
	}
}
?>