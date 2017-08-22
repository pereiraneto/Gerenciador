<?php if ( ! defined('ABSPATH')) exit; ?>

<div class="wrap">

<?php
// Carrega todos os métodos do modelo
$modelo->validate_register_form( $parametros );	
$modelo->del_contact($parametros);
?>

<form method="post" action="">
	<table class="form-table">
		<tr>
			<td>Nome: </td>
			<td> <input type="text" name="nome" value="<?php 
				echo htmlentities( chk_array( $modelo->form_data, 'nome') );
				?>" /></td>
		</tr>
		<tr>
			<td>Sobrenome: </td>
			<td> <input type="text" name="sobrenome" value="<?php
				echo htmlentities( chk_array( $modelo->form_data, 'sobrenome') );
			?>" /></td>
		</tr>
		<tr>
			<td>Texto: </td>
			<td> <input type="text" name="texto" value="<?php
				echo htmlentities( chk_array( $modelo->form_data, 'texto') );
			?>" /></td>
		</tr>
		<tr>
			<td>Email: </td>
			<td> <input type="text" name="email" value="<?php
				echo htmlentities( chk_array( $modelo->form_data, 'email') );
			?>" /></td>
		</tr>
		<tr>
			<td colspan="2">
				<?php echo $modelo->form_msg;?>
				<input type="submit" value="Save" />
				<a href="<?php echo HOME_URI . '/ContatoRegister';?>">New user</a>
			</td>
		</tr>
	</table>
</form>

<?php 
// Lista os usuários
$lista = $modelo->get_contact_list(); 
?>
<table class="list-table">
	<thead>
		<tr>
			<th>Código</th>
			<th>Nome</th>
			<th>Sobrenome</th>
			<th>Texto</th>
			<th>Email</th>
			<th>Ações</th>
		</tr>
	</thead>
			
	<tbody>
			
		<?php foreach ($lista as $fetch_userdata): ?>

			<tr>
			
				<td> <?php echo $fetch_userdata['codigo'] ?> </td>
				<td> <?php echo $fetch_userdata['nome'] ?> </td>
				<td> <?php echo $fetch_userdata['sobrenome'] ?> </td>
				<td> <?php echo $fetch_userdata['texto'] ?> </td>
				<td> <?php echo $fetch_userdata['email'] ?> </td>
				
				<td> 
					<a href="<?php echo HOME_URI ?>/ContatoRegister/index/del/<?php echo $fetch_userdata['codigo'] ?>">Delete</a>
					<a href="<?php echo HOME_URI ?>/ContatoRegister/reply/<?php echo $fetch_userdata['codigo'] ?>">Responder</a>
				</td>

			</tr>
			
		<?php endforeach;?>
			
	</tbody>
</table>

</div> <!-- .wrap -->
