<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'lottoced_com' );

/** MySQL database username */
define( 'DB_USER', 'beta_lottoced' );

/** MySQL database password */
define( 'DB_PASSWORD', 'WP_991107' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'vEw4pL1H8A)NdT+CRXjsJCz0m8NF786r78~+(233+:U!I2sXKgn-1*~G4z!;tY[d');
define('SECURE_AUTH_KEY', '[%k7z|gv4Aq79)E%:psklTj4F8~dg3!tJb3L4(B3Bh~12UG0)UWzH_j521e:%8*M');
define('LOGGED_IN_KEY', 'U059yQ-CU3:Vb-(b2kdJL93tCgKax72S2Tm-L*__wi@htLSZ2:KexpD%m_~D24&4');
define('NONCE_KEY', '15vI9o:sH0ax8C(_Yn9YN0VQ9eY)7t0YQt0]~#01CFN)~8wD70t4TWHC+Ufo~_a;');
define('AUTH_SALT', 'LBgTxKWm:j_d~0%#4S54)H1;K0Xw_t419&6Ct1A4:2O)!Tq11O7~)uK_1*5322~y');
define('SECURE_AUTH_SALT', '/3&]M5usn(0vRa1]Vio7QdbVf95UqNCrhfuP#S87VyzTvPwXE6*(8NP@|0vT6gPe');
define('LOGGED_IN_SALT', '#m@SY3263~I3)Brj#Ce6Kbiuj5+0SVU!NU#32%[*o]#@p~34--i!RXcgo9~uR[_t');
define('NONCE_SALT', 'Pc/USU!FQ_[DwWxD#2H63LZn1gan!o;++a0KoW1ZS7qV~C%v*#*]LT7H#N6|FPhX');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'lc_';


define('WP_ALLOW_MULTISITE', true);
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
