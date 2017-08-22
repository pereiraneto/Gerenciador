<?php
/**
 * Configuração geral
 */

// Caminho para a raiz
define( 'ABSPATH', dirname( __FILE__ ) );

// Caminho para a pasta de uploads
define( 'UP_ABSPATH', ABSPATH . '/views/_uploads' );

// URL da home
define( 'HOME_URI', 'http://localhost/Gerenciador' );

// Nome do host da base de dados
define( 'HOSTNAME', 'localhost' );

// Nome do DB
define( 'DB_NAME', 'gerenciador' );

// Usuário do DB
define( 'DB_USER', 'root' );

// Senha do DB
define( 'DB_PASSWORD', 'qwe123' );

// Charset da conexão PDO
define( 'DB_CHARSET', 'utf8' );

// Se você estiver desenvolvendo, modifique o valor para true
define( 'DEBUG', true );

//CONFIGURAÇÕES DO E-MAIL:
define('SMTP_HOST', 'onewaree.com');//Domínio do cliente
define('SMTP_USERNAME', 'teste@onewaree.com');//E-mail do servidor SMTP
define('SMTP_PASSWORD', 'qwe123');//Senha do servidor SMTP
define('EMAIL_FROM', 'teste@onewaree.com');//E-mail do remetente
define('EMAIL_NAME', 'OneWaree');//Nome do remetente

/**
 * Não edite daqui em diante
 */
// Carrega o loader, que vai carregar a aplicação inteira
require_once ABSPATH . '/loader.php';
?>