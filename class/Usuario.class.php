<?php 
class Usuario{
	private $codigo;
	private $nome;
	private $email;
	private $senha;
	private $foto;
	private $permissoes;
	private $session_id;

	public function getCodigo(){
		return $this->codigo;
	}

	public function setCodigo($codigo){
		$this->codigo = $codigo;
	}

	public function getNome(){
		return $this->nome;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getSenha(){
		return $this->senha;
	}

	public function setSenha($senha){
		$this->senha = $senha;
	}

	public function getFoto(){
		return $this->foto;
	}

	public function setFoto($foto){
		$this->foto = $foto;
	}


	public function setPermissoes($permissoes){
		$this->permissoes = $permissoes;
	}

	public function getPermissoes(){
		return $this->permissoes;
	}

	public function setSessionID($session_id){
		$this->session_id = $session_id;
	}

	public function getSessionID(){
		return $this->session_id;
	}


}
 ?>