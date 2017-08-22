<?php
    class Contato 
    {
        private $codigo;
        private $nome;
        private $sobrenome;
        private $texto;
        private $email;

        public function getCodigo(){
            return $this->codigo;
        }
        public function setCodigo($cod){
            $this->codigo = $cod;
        }

        public function getNome(){
            return $this->nome;
        }
        public function setNome($nome){
            $this->nome = $nome;
        }

        public function getSobrenome(){
            return $this->sobrenome;
        }
        public function setSobrenome($sobrenome){
            $this->sobrenome = $sobrenome;
        }

        public function getTexto(){
            return $this->texto;
        }
        public function setTexto($texto){
            $this->texto = $texto;
        }
        
        public function getEmail(){
            return $this->email;
        }
        public function setEmail($email){
            $this->email = strtolower($email);
        }

    }
 ?>