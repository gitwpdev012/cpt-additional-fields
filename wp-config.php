<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '%zM_r]=m4,H71 9c>Ib<ds;$;Ur+hdFl`0ztgixS&d>1~pC Ng?Yx!xO+pL^<{MO' );
define( 'SECURE_AUTH_KEY',   '7B>/bK8tbg:s/suQLIT6[=V;{<p4}]xA1uDMb-724O4}gMfW)gW!O5^ShGR3.;2E' );
define( 'LOGGED_IN_KEY',     '6~V#c!r^Zk2k7X7>nyt9_0LU]#_a@Uz==#W*ucCY`Z4jEL]xmc,FIw8WK{],YHE9' );
define( 'NONCE_KEY',         ')_JdK,[`pnW=y5MehaO0Y{trXY.c ;Mk*WPc1I @N,@H|>:+S{ICD#0it<,jF34%' );
define( 'AUTH_SALT',         'JOxw+YrgV@v$0Y{[_pKin,6r}G00 M.Nklg,MVLpPSZ$aVk9OwW:!WA$L@(O?iuv' );
define( 'SECURE_AUTH_SALT',  'um=S(wnp[N-E[#pH@IXIO:-2A%6x83MY)7yB{,/GgzK.27(Gn{Ir:Dgc[2-H&u}W' );
define( 'LOGGED_IN_SALT',    'rRN`536qv6:;fqc3T%|Xe?$]@2Zd;rE8-wk[xT XqU2FSVX^<sYf_f6WR[u;fK~-' );
define( 'NONCE_SALT',        'W$) @(BCTU&wqoE|-4#Lss98VR!T|QtyVRu{_>sRy#X38r8.9AmT:b5o]lpATZQ~' );
define( 'WP_CACHE_KEY_SALT', ' }O^slai~9eq m)}EG;m?G5>66*MevKzq:Mq[@~K@M_.[fk_r!LXKgnqM>SaWE4:' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';



