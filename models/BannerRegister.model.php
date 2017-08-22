<?php
/**
 * Classe para registros de usuários
 *
 * @package TutsupMVC
 * @since 0.1
 */

class BannerRegister
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
    public function __construct(  ) {
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
    public function validate_register_form ($parametros = array()) {
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
                    $this->form_msg = '<p class="form_error">There are empty fields. Data has not been sent.</p>';

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



        $instControleBanner = ControleBanner::getInstance();

        if(!empty(chk_array($parametros, 0))){
            if((chk_array($parametros, 0)) != "edit"){
                $this->form_msg = '<p class="form_error">Erro ao selecionar operação.</p>';
                $this->form_data = null;
                return;
            }
            $novoBanner = new Banner();
            $novoBanner->setCodigo(chk_array($parametros, 1));
            $novoBanner->setImagem($this->form_data['imagem']);
            $novoBanner->setCodigoUsuario($_SESSION['userdata']['codigo']);

            if (!$instControleBanner->editarBanner($novoBanner)) {
                $this->form_msg = '<p class="form_error">Erro ao editar o banner.</p>';

                // Termina
                return;
            } else {
                $this->form_msg = '<p class="form_success">Banner editado com sucesso.</p>';
                $this->form_data = null;

                // Termina
                return;
            }
        }else{
            $novoBanner = new Banner();
            $novoBanner->setImagem($this->form_data['imagem']);
            $novoBanner->setCodigoUsuario($_SESSION['userdata']['codigo']);

            // Verifica se a consulta está OK e configura a mensagem
            if (!$instControleBanner->inserirBanner($novoBanner)) {
                $this->form_msg = '<p class="form_error">Internal error. Data has not been sent.</p>';

                // Termina
                return;
            } else {
                $this->form_msg = '<p class="form_success">Banner registrado com sucesso.</p>';
                $this->form_data = null;

                // Termina
                return;
            }
        }
    } // validate_register_form

    /**
     * Obtém os dados do formulário
     *
     * Obtém os dados para banners registrados
     *
     * @since 0.1
     * @access public
     */
    public function get_register_form ( $codigo = false ) {

        // O codigo da imagem que vamos pesquisar
        $s_codigo = false;

        // Verifica se você enviou algum codigo para o método
        if ( ! empty( $codigo ) ) {
            $s_codigo = (int)$codigo;
        }

        // Verifica se existe um codigo de banner
        if ( empty( $s_codigo ) ) {
            return;
        }
        $instControleBanner = ControleBanner::getInstance();
        $banner = $instControleBanner->getBanner($codigo);

        // Verifica a consulta
        if (!$codigo){
            $this->form_msg = '<p class="form_error">Usuário não existe.</p>';
            return;
        }

        // Verifica se os dados da consulta estão vazios
        if (empty($banner->getImagem())){
            $this->form_msg = '<p class="form_error">User do not exists.</p>';
            return;
        }


        // Configura os dados do formulário
        $this->form_data['imagem'] = $banner->getImagem();
    } // get_register_form

    /**
     * Apaga usuários
     *
     * @since 0.1
     * @access public
     */
    public function del_banner($parametros = array()){

        // O codigo do banner
        $codigo = null;

        // Verifica se existe o parâmetro "del" na URL
        if ( chk_array( $parametros, 0 ) == 'del' ) {

            // Mostra uma mensagem de confirmação
            echo '<p class="alert">Tem certeza que deseja apagar este valor?</p>';
            echo '<p><a href="' . $_SERVER['REQUEST_URI'] . '/confirma">Sim</a> |
            <a href="' . HOME_URI . '/BannerRegister">Não</a> </p>';

            // Verifica se o valor do parâmetro é um número
            if (
                is_numeric( chk_array( $parametros, 1 ) )
                && chk_array( $parametros, 2 ) == 'confirma'
            ) {
                // Configura o codigo do banner a ser apagado
                $codigo = chk_array( $parametros, 1 );
            }
        }

        // Verifica se o codigo não está vazio
        if ( !empty( $codigo ) ) {

            // O codigo precisa ser inteiro
            $codigo = (int)$codigo;

            //Deletar Banner
            $instControleBanner = ControleBanner::getInstance();
            $instControleBanner->deletarBanner($codigo);

            // Redireciona para a página de registros
            echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . '/user-register/">';
            echo '<script type="text/javascript">window.location.href = "' . HOME_URI . '/user-register/";</script>';
            return;
        }
    } // del_banner

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