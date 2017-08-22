<?php if ( ! defined('ABSPATH')) exit; ?>

<?php if ( $this->login_required && ! $this->logged_in ) return; ?>

<nav class="menu clearfix">
	<ul>
		<li><a href="<?php echo HOME_URI;?>">Home</a></li>
		<li><a href="<?php echo HOME_URI;?>/login/">Login</a></li>
		<li><a href="<?php echo HOME_URI;?>/UserRegister/">User Register</a></li>
		<li><a href="<?php echo HOME_URI;?>/BannerRegister/">Banner</a></li>
		<li><a href="<?php echo HOME_URI;?>/SlideRegister/">Slide</a></li>
		<li><a href="<?php echo HOME_URI;?>/ContatoRegister/">Contato</a></li>
		<li><a href="<?php echo HOME_URI;?>/SendEmail/">Send email</a></li>
	</ul>
</nav>