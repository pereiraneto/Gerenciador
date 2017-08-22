<?php
/**
 * Classe para registros de usuários
 *
 * @package TutsupMVC
 * @since 0.1
 */

class SendEmail
{
    /**
     * $form_data
     *
     * Os dados do formulário de envio.
     *
     * @access public
     */
    public $form_data;

    /**
     * $form_msg
     *
     * As mensagens de feedback para o usuário.
     *
     * @access public
     */
    public $form_msg;


    /**
     * $db
     *
     * O objeto da nossa conexão PDO
     *
     * @access public
     */
    public $instance;

    /**
     * Construtor
     *
     * Carrega  o DB.
     *
     * @since 0.1
     * @access public
     */
    public function __construct() {
        //$this->instance = $instance;
    }

    /**
     * Valida o formulário de envio
     *
     * Este método pode inserir ou atualizar dados dependendo do campo de
     * banner.
     *
     * @since 0.1
     * @access public
     */
    public function validate_register_form () {
        // Configura os dados do formulário
        $this->form_data = array();

        // Verifica se algo foi postado
        if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty ( $_POST ) ) {

            // Faz o loop dos dados do post
            foreach ( $_POST as $key => $value ) {

                // Configura os dados do post para a propriedade $form_data
                $this->form_data[$key] = $value;

                // Nós não permitiremos nenhum campos em branco
                if ( empty( $value ) ) {

                    // Configura a mensagem
                    $this->form_msg = '<p class="form_error">Preencha todos os campos para poder enviar.</p>';

                    // Termina
                    return;

                }

            }

        } else {
            // Termina se nada foi enviado
            return;
        }

        // Verifica se a propriedade $form_data foi preenchida
        if( empty( $this->form_data ) ) {
            return;
        }



        $instControleEmail = ControleEmail::getInstance();

        foreach($instControleEmail->listaEmails() as $email){
            $nome = $email['nome'];
            if(empty($nome)){
                $expEmail = explode('@', $email['email']);
                $nome = $expEmail[0];
            }
            if(!$instControleEmail->enviarEmail($nome, $email['email'], $this->form_data['titulo'], $this->form_data['bodyEmail'])){
                $this->form_msg = '<p class="form_error">Erro ao conectar-se ao servidor.</p>';
                // Termina
                return;
            }
        }
        $this->form_msg = '<p class="form_success">Emails enviados com sucesso.</p>';
        $this->form_data = null;
        return;
    } // validate_register_form

    /**
     * Obtém a lista de banners
     *
     * @since 0.1
     * @access public
     */
    public function get_banner_list(){
        $instControleBanner = ControleBanner::getInstance();
        $listar = $instControleBanner->listarBanner();

        // Verifica se a consulta está OK
        if ( ! $listar ) {
            return array();
        }
        // Preenche a tabela com os dados do banner
        return $instControleBanner->listarBanner();
    } // get_banner_list
}