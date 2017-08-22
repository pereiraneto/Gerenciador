<?php if ( ! defined('ABSPATH')) exit; ?>

<div class="wrap">

<?php
// Carrega todos os métodos do modelo
$modelo->validate_register_form();
$modelo->get_register_form(chk_array($parametros, 1));
$modelo->del_user( $parametros );
?>

<form method="post" action="">
	<table class="form-table">
		<tr>
			<td>Nome: </td>
			<td> <input type="text" name="user_name" value="<?php 
				echo htmlentities( chk_array( $modelo->form_data, 'user_name') );
				?>" /></td>
		</tr>
		<tr>
			<td>E-mail: </td>
			<td> <input type="text" name="email" value="<?php
				echo htmlentities( chk_array( $modelo->form_data, 'email') );
			?>" /></td>
		</tr>
		<tr>
			<td>Password: </td>
			<td> <input type="password" name="user_password" value="<?php
			echo htmlentities( chk_array( $modelo->form_data, 'user_password') );
			?>" /></td>
		</tr>
		<tr>
			<td>Foto: </td>
			<td> <input type="text" name="user_foto" value="<?php
			echo htmlentities( chk_array( $modelo->form_data, 'user_foto') );
			?>" /></td>
		</tr>
		<tr>
			<td>Permissions <br><small>(Separate permissions using commas)</small>: </td>
			<td> <input type="text" name="user_permissions" value="<?php
			echo htmlentities( chk_array( $modelo->form_data, 'user_permissions') );
			?>" /></td>
		</tr>
		<tr>
			<td colspan="2">
				<?php echo $modelo->form_msg;?>
				<input type="submit" value="Save" />
				<a href="<?php echo HOME_URI . '/UserRegister';?>">New user</a>
			</td>
		</tr>
	</table>
</form>

<?php 
// Lista os usuários
$lista = $modelo->get_user_list(); 
?>


<table class="list-table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Usuário</th>
			<th>Name</th>
			<th>Permissões</th>
			<th>Edição</th>
		</tr>
	</thead>
			
	<tbody>
			
		<?php foreach ($lista as $fetch_userdata): ?>

			<tr>
			
				<td> <?php echo $fetch_userdata['codigo'] ?> </td>
				<td> <?php echo $fetch_userdata['email'] ?> </td>
				<td> <?php echo $fetch_userdata['nome'] ?> </td>
				<td> <?php echo implode( ',', unserialize( $fetch_userdata['user_permissions'] ) ) ?> </td>
				
				<td> 
					<a href="<?php echo HOME_URI ?>/UserRegister/index/edit/<?php echo $fetch_userdata['codigo'] ?>">Edit</a>
					<a href="<?php echo HOME_URI ?>/UserRegister/index/del/<?php echo $fetch_userdata['codigo'] ?>">Delete</a>
				</td>

			</tr>
			
		<?php endforeach;?>
			
	</tbody>
</table>

</div> <!-- .wrap -->
