<?php
    class ControlContato extends Conexao
    {

        public static $instance;

        function __construct()
        {
            //
        }

        public static function getInstance() {
            if (!isset(self::$instance))
                self::$instance = new ControlContato();

            return self::$instance;
        }

        public function adicionarContato(Contato $contato)
        {
            try {
                $sql = "INSERT INTO contato (
                    nome,
                    sobrenome,
                    texto,
                    email)
                    VALUES (
                    :nome,
                    :sobrenome,
                    :texto,
                    :email)";

                $p_sql = Conexao::getInstance()->prepare($sql);

                $p_sql->bindValue(":nome", $contato->getNome());
                $p_sql->bindValue(":sobrenome", $contato->getSobrenome());
                $p_sql->bindValue(":texto", $contato->getTexto());
                $p_sql->bindValue(":email", $contato->getEmail());

                return $p_sql->execute();
            } catch (Exception $e) {
                print "Ocorreu um erro ao tentar executar esta ação, foi gerado
        um LOG do mesmo, tente novamente mais tarde.";
                GeraLog::getInstance()->inserirLog("Erro: Código: " .
        $e->getCode() . " Mensagem: " . $e->getMessage());
            }
        }

        public function listarContatos()
        {
            //Não sei se tá correto,
            //pesquisei sobre o fetchAll e vi que ele retorna todos os objetos
            //Só nao sei como retorna cada objeto apos popular

            try {
                $sql = "SELECT * FROM contato";
                $p_sql = Conexao::getInstance()->prepare($sql);
                $p_sql->execute();
                return $p_sql->fetchAll();

            } catch (Exception $e) {
                print "Ocorreu um erro ao tentar executar esta ação, foi gerado
    um LOG do mesmo, tente novamente mais tarde.";
                GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
    getCode() . " Mensagem: " . $e->getMessage());
            }

        }
        public function editarContato(Contato $contato) {
            try {
                $sql = "UPDATE contato set
                nome = :nome,
                sobrenome = :sobrenome,
                texto = :texto,
                email = :email WHERE codigo = :cod_contato";

                $p_sql = Conexao::getInstance()->prepare($sql);

                $p_sql->bindValue(":nome", $contato->getNome());
                $p_sql->bindValue(":sobrenome", $contato->getSobrenome());
                $p_sql->bindValue(":texto", $contato->getTexto());
                $p_sql->bindValue(":email", $contato->getEmail());

                $p_sql->bindValue(":cod_contato", $contato->getCodigo());
                return $p_sql->execute(); 
            } catch (Exception $e) {
                print "Ocorreu um erro ao tentar executar esta ação, foi gerado
                um LOG do mesmo, tente novamente mais tarde.";
                GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                getCode() . " Mensagem: " . $e->getMessage());
            }
        }

        public function deletarContato($codigo)
        {
           try {
                $sql = "DELETE FROM contato WHERE codigo = :cod";
                $p_sql = Conexao::getInstance()->prepare($sql);
                $p_sql->bindValue(":cod", $codigo);
                return $p_sql->execute();
            } catch (Exception $e) {
                print "Ocorreu um erro ao tentar executar esta ação, foi gerado
                um LOG do mesmo, tente novamente mais tarde.";
                GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                getCode() . " Mensagem: " . $e->getMessage());
            }
        }


        public function getContato($codigo)
        {
            try {
                $sql = "SELECT * FROM contato WHERE codigo = :cod";
                $p_sql = Conexao::getInstance()->prepare($sql);
                $p_sql->bindValue(":cod", $codigo);
                $p_sql->execute();
                return $this->populaContato($p_sql->fetch(PDO::FETCH_ASSOC));
            } catch (Exception $e) {
                print "Ocorreu um erro ao tentar executar esta ação, foi gerado
                um LOG do mesmo, tente novamente mais tarde.";
                GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                getCode() . " Mensagem: " . $e->getMessage());
            }

        }
        private function populaContato($row) {
            $pojo = new Contato;
            $pojo->setCodigo($row['codigo']);
            $pojo->setNome($row['nome']);
            $pojo->setSobrenome($row['sobrenome']);
            $pojo->setTexto($row['texto']);
            $pojo->setEmail($row['email']);
            return $pojo;
        }
    }
 ?>