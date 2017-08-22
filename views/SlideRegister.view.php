<?php if ( ! defined('ABSPATH')) exit; ?>

<div class="wrap">

<?php
// Carrega todos os métodos do modelo
$modelo->validate_register_form($parametros);
$modelo->get_register_form( chk_array( $parametros, 1 ) );
$modelo->del_user( $parametros );
?>

<form method="post" action="">
	<table class="form-table">
		<tr>
			<td>Texto: </td>
			<td> <input type="text" name="texto" value="<?php 
				echo htmlentities( chk_array( $modelo->form_data, 'texto') );
				?>" /></td>
		</tr>
		<tr>
			<td>Imagem: </td>
			<td> <input type="text" name="imagem" value="<?php
				echo htmlentities( chk_array( $modelo->form_data, 'imagem') );
			?>" /></td>
		</tr>
		<tr>
			<td colspan="2">
				<?php echo $modelo->form_msg;?>
				<input type="submit" value="Save" />
				<a href="<?php echo HOME_URI . '/SlideRegister';?>">New user</a>
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
			<th>Código</th>
			<th>Texto</th>
			<th>Imagem</th>
			<th>Ações</th>
		</tr>
	</thead>
			
	<tbody>
			
		<?php foreach ($lista as $fetch_userdata): ?>

			<tr>
			
				<td> <?php echo $fetch_userdata['codigo'] ?> </td>
				<td> <?php echo $fetch_userdata['texto'] ?> </td>
				<td> <?php echo $fetch_userdata['imagem'] ?> </td>
				
				<td> 
					<a href="<?php echo HOME_URI ?>/SlideRegister/index/edit/<?php echo $fetch_userdata['codigo'] ?>">Edit</a>
					<a href="<?php echo HOME_URI ?>/SlideRegister/index/del/<?php echo $fetch_userdata['codigo'] ?>">Delete</a>
				</td>

			</tr>
			
		<?php endforeach;?>
			
	</tbody>
</table>

</div> <!-- .wrap -->
