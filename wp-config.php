<?php
/**
 * Il file base di configurazione di WordPress.
 *
 * Questo file viene utilizzato, durante l’installazione, dallo script
 * di creazione di wp-config.php. Non è necessario utilizzarlo solo via web
 * puoi copiare questo file in «wp-config.php» e riempire i valori corretti.
 *
 * Questo file definisce le seguenti configurazioni:
 *
 * * Impostazioni MySQL
 * * Chiavi Segrete
 * * Prefisso Tabella
 * * ABSPATH
 *
 * * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Impostazioni MySQL - È possibile ottenere queste informazioni dal proprio fornitore di hosting ** //
/** Il nome del database di WordPress */
define( 'DB_NAME', 'lottoced_com' );

/** Nome utente del database MySQL */
define( 'DB_USER', 'lottoced' );

/** Password del database MySQL */
define( 'DB_PASSWORD', 'WP_991107' );

/** Hostname MySQL  */
define( 'DB_HOST', 'localhost' );

/** Charset del Database da utilizzare nella creazione delle tabelle. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Il tipo di Collazione del Database. Da non modificare se non si ha idea di cosa sia. */
define('DB_COLLATE', '');

/**#@+
 * Chiavi Univoche di Autenticazione e di Salatura.
 *
 * Modificarle con frasi univoche differenti!
 * È possibile generare tali chiavi utilizzando {@link https://api.wordpress.org/secret-key/1.1/salt/ servizio di chiavi-segrete di WordPress.org}
 * È possibile cambiare queste chiavi in qualsiasi momento, per invalidare tuttii cookie esistenti. Ciò forzerà tutti gli utenti ad effettuare nuovamente il login.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         's6tE],2>NtF9qALkPYdcIyquC}L_C;uL)`[}P8pG;-luV3.@Kt!BB|C]p,_ueUj<' );
define( 'SECURE_AUTH_KEY',  '?U<$|x[R2(,daj^l?D?eZdUnS==}x.0z8=L 2WZ?)>76}Rx_9ECA;`V~7]I|s6~$' );
define( 'LOGGED_IN_KEY',    'U,bH>PbU 4)KOb+E0@MY?SOX]Zw~zU%jgan`|&eGC/TvIQT&2=?8F*eSOb:5FWZv' );
define( 'NONCE_KEY',        '_%t|lI)8>oWun79 ~m=j>g%HC#7|PR8^2Jy+0R.Ps^Uc}@6kL%isCy>0TA+UIN!l' );
define( 'AUTH_SALT',        '0QK(~Q$qEHNy6R 4$Lc!7#]E$Q.(#n#D56Y|K;^p uF!9DAs6Dhx3fXhKF_D!279' );
define( 'SECURE_AUTH_SALT', '2;Wd:wdC_A6S7;#{UlE_OEG&x?>6%hJbhm50%,T:,H2#Xldi!{X,.z]:#,a:DJWm' );
define( 'LOGGED_IN_SALT',   '6H21[Y/Ue?K7R@F;*x^-C=z=YTA6B?[_e-)VRy$0,;rxAyQq2Djm`<T`OC!fD9Bi' );
define( 'NONCE_SALT',       '^*_2BORn4sdT/]JDY^(y69m!05jl]+JZ zf??]&e~]=h@:K&2A_8`3,z;ss1DhLU' );

/**#@-*/

/**
 * Prefisso Tabella del Database WordPress.
 *
 * È possibile avere installazioni multiple su di un unico database
 * fornendo a ciascuna installazione un prefisso univoco.
 * Solo numeri, lettere e sottolineatura!
 */
$table_prefix = 'LC_';

/**
 * Per gli sviluppatori: modalità di debug di WordPress.
 *
 * Modificare questa voce a TRUE per abilitare la visualizzazione degli avvisi durante lo sviluppo
 * È fortemente raccomandato agli svilupaptori di temi e plugin di utilizare
 * WP_DEBUG all’interno dei loro ambienti di sviluppo.
 *
 * Per informazioni sulle altre costanti che possono essere utilizzate per il debug,
 * leggi la documentazione
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);

/* Finito, interrompere le modifiche! Buon blogging. */

/** Path assoluto alla directory di WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Imposta le variabili di WordPress ed include i file. */
require_once(ABSPATH . 'wp-settings.php');
