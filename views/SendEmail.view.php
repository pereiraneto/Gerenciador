<?php if ( ! defined('ABSPATH')) exit; 
$modelo->validate_register_form(); 
?>

<div class="wrap">

<form method="post" action="">
    <table class="form-table">
        <tr>
            <td>Título do e-mail: </td>
            <td> <input type="text" name="titulo"/></td>
        </tr>
        <tr>
            <td>Corpo do e-mail: </td>
            <td><textarea name="bodyEmail"></textarea></td>
        </tr>

        <tr>
            <td colspan="2">
                <?php echo $modelo->form_msg;?>
                <input type="submit" value="Save" />
                <a href="<?php echo HOME_URI . '/BannerRegister';?>">New Banner</a>
            </td>
        </tr>
    </table>
</form>

</div> <!-- .wrap -->
