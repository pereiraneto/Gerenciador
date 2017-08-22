<?php if ( ! defined('ABSPATH')) exit; 
$modelo->validate_register_form($parametros);
$modelo->get_email_form(chk_array($parametros, 0));
?>

<div class="wrap">

<form method="post" action="">
    <table class="form-table">
        <tr>
            <td>Nome do remetente: </td>
            <td> <input type="TEXT" readonly name="nome" value="<?php echo htmlentities(chk_array($modelo->form_data, 'nome')). ' ' . htmlentities(chk_array($modelo->form_data, 'sobrenome'));?>"/></td>
        </tr>
        <tr>
            <td>E-mail: </td>
            <td><input type="TEXT" readonly name="email" value="<?php echo htmlentities(chk_array($modelo->form_data, 'email'));?>"/></td>
        </tr>
        <tr>
            <td>Mensagem: </td>
            <td><?php echo htmlentities(chk_array($modelo->form_data, 'texto'));?></td>
        </tr>
        <tr>
            <td>Assunto: </td>
            <td><input type="TEXT" name="assunto"/></td>
        </tr>
        <tr>
            <td>Resposta: </td>
            <td><textarea name="resposta"></textarea></td>
        </tr>

        <tr>
            <td colspan="2">
                <?php echo $modelo->form_msg;?>
                <input type="submit" value="Enviar" />
            </td>
        </tr>
    </table>
</form>

</div> <!-- .wrap -->
