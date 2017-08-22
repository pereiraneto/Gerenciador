<?php 
/**
 * Classe para registros de usuários
 *
 * @package TutsupMVC
 * @since 0.1
 */

class UserRegister
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
		
		

		$instControleUsuario = ControleUsuario::getInstance();
		$usuario = $instControleUsuario->getUsuarioByEmail($this->form_data['email']);
		
		// Verifica se a consulta foi realizada com sucesso
		if (!$usuario) {
			$this->form_msg = '<p class="form_error">Erro ao cadastrar. Tente novamente..</p>';
			return;
		}
		
		
		// Configura o ID do usuário
		$user_id = $usuario->getCodigo();
		
		// Precisaremos de uma instância da classe Phpass
		// veja http://www.openwall.com/phpass/
		$password_hash = new PasswordHash(8, FALSE);
		
		// Cria o hash da senha
		$password = $password_hash->HashPassword($this->form_data['user_password']);
		
		// Verifica se as permissões tem algum valor inválido: 
		// 0 a 9, A a Z e , . - _
		if (preg_match( '/[^0-9A-Za-z\,\.\-\_\s ]/is', $this->form_data['user_permissions']) ) {
			$this->form_msg = '<p class="form_error">Use apenas letras, números e vírgula para preencher as permissões.</p>';
			return;
		}		
		
		// Faz um trim nas permissões
		$permissions = array_map('trim', explode(',', $this->form_data['user_permissions']));
		
		// Remove permissões duplicadas
		$permissions = array_unique( $permissions );
		
		// Remove valores em branco
		$permissions = array_filter( $permissions );
		
		// Serializa as permissões
		$permissions = serialize( $permissions );
		
		
		// Se o ID do usuário não estiver vazio, atualiza os dados
		if (!empty( $user_id ) ) {
			$novoUsuario = new Usuario();
			$novoUsuario->setCodigo($usuario->getCodigo());
			$novoUsuario->setNome($this->form_data['user_name']);
			$novoUsuario->setSenha($password);
			$novoUsuario->setEmail($this->form_data['email']);
			$novoUsuario->setFoto($this->form_data['user_foto']);
			$novoUsuario->setPermissoes($permissions);
			$novoUsuario->setSessionID(md5(time()));

			$instControleUsuario->editarPerfil($novoUsuario);
			$this->form_data = null;
			$this->form_msg = '<p class="form_success">Usuário atualizado com sucesso.</p>';
		// Se o ID do usuário estiver vazio, insere os dados
		} else {
			// Executa a consulta 
			$novoUsuario = new Usuario();
			$novoUsuario->setNome($this->form_data['user_name']);
			$novoUsuario->setEmail($this->form_data['email']);
			$novoUsuario->setSenha($password);
			$novoUsuario->setFoto($this->form_data['user_foto']);
			$novoUsuario->setPermissoes($permissions);
			$novoUsuario->setSessionID(md5(time()));
			
			// Verifica se a consulta está OK e configura a mensagem
			if (!$instControleUsuario->adicionarUsuario($novoUsuario)) {
				$this->form_msg = '<p class="form_error">Internal error. Data has not been sent.</p>';

				// Termina
				return;
			} else {
				$this->form_msg = '<p class="form_success">User successfully registered.</p>';
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
	public function get_register_form ( $user_id = false ) {
	
		// O ID de usuário que vamos pesquisar
		$s_user_id = false;
		
		// Verifica se você enviou algum ID para o método
		if ( ! empty( $user_id ) ) {
			$s_user_id = (int)$user_id;
		}
		
		// Verifica se existe um ID de usuário
		if ( empty( $s_user_id ) ) {
			return;
		}
		$instControleUsuario = ControleUsuario::getInstance();
		$usuario = $instControleUsuario->getUsuario($s_user_id);
		
		// Verifica a consulta
		if (!$usuario){
			$this->form_msg = '<p class="form_error">Usuário não existe.</p>';
			return;
		}
		
		// Verifica se os dados da consulta estão vazios
		if (empty($usuario->getEmail())){
			$this->form_msg = '<p class="form_error">User do not exists.</p>';
			return;
		}
		
		// Configura os dados do formulário
		$this->form_data['user_name'] = $usuario->getNome();
		$this->form_data['email'] = $usuario->getEmail();
		$this->form_data['user_foto'] = $usuario->getFoto();
		// Por questões de segurança, a senha só poderá ser atualizada
		$this->form_data['user_password'] = null;
		// Remove a serialização das permissões
		$this->form_data['user_permissions'] = unserialize($usuario->getPermissoes());
		// Separa as permissões por vírgula
		$this->form_data['user_permissions'] = implode(',', $this->form_data['user_permissions']);
	} // get_register_form
	
	/**
	 * Apaga usuários
	 * 
	 * @since 0.1
	 * @access public
	 */
	public function del_user($parametros = array()){

		// O ID do usuário
		$user_id = null;
		
		// Verifica se existe o parâmetro "del" na URL
		if ( chk_array( $parametros, 0 ) == 'del' ) {

			// Mostra uma mensagem de confirmação
			echo '<p class="alert">Tem certeza que deseja apagar este valor?</p>';
			echo '<p><a href="' . $_SERVER['REQUEST_URI'] . '/confirma">Sim</a> | 
			<a href="' . HOME_URI . '/UserRegister">Não</a> </p>';
			
			// Verifica se o valor do parâmetro é um número
			if ( 
				is_numeric( chk_array( $parametros, 1 ) )
				&& chk_array( $parametros, 2 ) == 'confirma' 
			) {
				// Configura o ID do usuário a ser apagado
				$user_id = chk_array( $parametros, 1 );
			}
		}
		
		// Verifica se o ID não está vazio
		if ( !empty( $user_id ) ) {
		
			// O ID precisa ser inteiro
			$user_id = (int)$user_id;
			
			// Deleta o usuário
			$instControleUsuario = ControleUsuario::getInstance();
			$instControleUsuario->deletarUsuario($user_id);
			
			// Redireciona para a página de registros
			echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . '/UserRegister/">';
			echo '<script type="text/javascript">window.location.href = "' . HOME_URI . '/UserRegister/";</script>';
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
		$instControleUsuario = ControleUsuario::getInstance();
		$listar = $instControleUsuario->listarUsuarios();
		
		// Verifica se a consulta está OK
		if ( ! $listar ) {
			return array();
		}
		// Preenche a tabela com os dados do usuário
		return $instControleUsuario->listarUsuarios();
	} // get_user_list
}