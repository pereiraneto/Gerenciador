<?php  
	class Slide{
		private $codigo;
		private $texto;
		private $imagem;
		private $codigoUsuario;

		public function getCodigo(){
			return $this->codigo;
		}

		public function setCodigo($codigo){
			$this->codigo = $codigo;
		}

		public function getCodigoUsuario(){
			return $this->codigoUsuario;
		}

		public function setCodigoUsuario($codigoUsuario){
			$this->codigoUsuario = $codigoUsuario;
		}

		public function getTexto(){
			return $this->texto;
		}

		public function setTexto($texto){
			$this->texto = $texto;
		}

		public function getImagem(){
			return $this->imagem;
		}

		public function setImagem($imagem){
			$this->imagem = $imagem;
		}
	}
?>
