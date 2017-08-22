<?php 
/**
 * Classe para registros de usuários
 *
 * @package TutsupMVC
 * @since 0.1
 */

class SlideRegister
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
	 * usuário.
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



        $instControleSlide = ControleSlide::getInstance();

        if(!empty(chk_array($parametros, 0))){
            if((chk_array($parametros, 0)) != "edit"){
                $this->form_msg = '<p class="form_error">Erro ao selecionar operação.</p>';
                $this->form_data = null;
                return;
            }
            $novoSlide = new Slide();
            $novoSlide->setCodigo(chk_array($parametros, 1));
            $novoSlide->setTexto($this->form_data['texto']);
            $novoSlide->setImagem($this->form_data['imagem']);
            $novoSlide->setCodigoUsuario($_SESSION['userdata']['codigo']);

            if (!$instControleSlide->editarSlide($novoSlide)) {
                $this->form_msg = '<p class="form_error">Erro ao editar o slide.</p>';

                // Termina
                return;
            } else {
                $this->form_msg = '<p class="form_success">Slide editado com sucesso.</p>';
                $this->form_data = null;

                // Termina
                return;
            }
        }else{
            $novoSlide = new Slide();
            $novoSlide->setTexto($this->form_data['texto']);
            $novoSlide->setImagem($this->form_data['imagem']);
            $novoSlide->setCodigoUsuario($_SESSION['userdata']['codigo']);

            // Verifica se a consulta está OK e configura a mensagem
            if (!$instControleSlide->cadastrarSlide($novoSlide)) {
                $this->form_msg = '<p class="form_error">Internal error. Data has not been sent.</p>';

                // Termina
                return;
            } else {
                $this->form_msg = '<p class="form_success">Slide registrado com sucesso.</p>';
                $this->form_data = null;

                // Termina
                return;
            }
        }
    } // validate_register_form
	
	/**
	 * Obtém os dados do formulário
	 * 
	 * Obtém os dados para usuários registrados
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
        $instControleSlide = ControleSlide::getInstance();
        $slide = $instControleSlide->getSlide($codigo);

        // Verifica a consulta
        if (!$codigo){
            $this->form_msg = '<p class="form_error">Slide não existe.</p>';
            return;
        }

        // Verifica se os dados da consulta estão vazios
        if (empty($slide->getImagem())){
            $this->form_msg = '<p class="form_error">Slide do not exists.</p>';
            return;
        }


        // Configura os dados do formulário
        $this->form_data['texto'] = $slide->getTexto();
        $this->form_data['imagem'] = $slide->getImagem();
    } // get_register_form

    
	public function del_user($parametros = array()){

		// O ID do usuário
		$codigo = null;
		
		// Verifica se existe o parâmetro "del" na URL
		if ( chk_array( $parametros, 0 ) == 'del' ) {

			// Mostra uma mensagem de confirmação
			echo '<p class="alert">Tem certeza que deseja apagar este valor?</p>';
			echo '<p><a href="' . $_SERVER['REQUEST_URI'] . '/confirma">Sim</a> | 
			<a href="' . HOME_URI . '/SlideRegister">Não</a> </p>';
			
			// Verifica se o valor do parâmetro é um número
			if ( 
				is_numeric( chk_array( $parametros, 1 ) )
				&& chk_array( $parametros, 2 ) == 'confirma' 
			) {
				// Configura o ID do usuário a ser apagado
				$codigo = chk_array( $parametros, 1 );
			}
		}
		
		// Verifica se o ID não está vazio
		if ( !empty( $codigo ) ) {
		
			// O ID precisa ser inteiro
			$codigo = (int)$codigo;
			
			// Deleta o usuário
			$instControleSlide = ControleSlide::getInstance();
			$instControleSlide->removerSlide($codigo);
			
			// Redireciona para a página de registros
			echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . '/SlideRegister/">';
			echo '<script type="text/javascript">window.location.href = "' . HOME_URI . '/SlideRegister/";</script>';
			return;
		}
	} // del_user
	
	/**
	 * Obtém a lista de usuários
	 * 
	 * @since 0.1
	 * @access public
	 */
	public function get_user_list(){
		$instControleSlide = ControleSlide::getInstance();
		$listar = $instControleSlide->listarSlide();
		
		// Verifica se a consulta está OK
		if ( ! $listar ) {
			return array();
		}
		// Preenche a tabela com os dados do usuário
		return $instControleSlide->listarSlide();
	} // get_user_list
}