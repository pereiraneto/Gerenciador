<?php
	class Banner{
		private $codigo;
		private $imagem;
		private $codigoUsuario;

		public function getCodigo(){
			return $this->codigo;
		}

		public function setCodigo($codigo){
			$this->codigo = (int)$codigo;
		}

		public function getImagem(){
			return $this->imagem;
		}

		public function setImagem($imagem){
			$this->imagem = $imagem;
		}

		public function getCodigoUsuario(){
			return $this->codigoUsuario;
		}

		public function setCodigoUsuario($codigoUsuario){
			$this->codigoUsuario = $codigoUsuario;
		}
	}
?>