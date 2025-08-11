<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'hodecode' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '-j@$h!vE!m~)W&UQ+bM<zc,^SP}{S*Zikmi?._J4[p}e,rbX@RH@XTJ44[8,0Ix|' );
define( 'SECURE_AUTH_KEY',  'Gi#2Pk||=h5I@%9!ckd/-<L53R3p*)=GxJ|W2Q@Vis}2Q$8dVqIBs^w**N5MTN0>' );
define( 'LOGGED_IN_KEY',    'Z!Gi1-PdFdblk%|QMi5=`v4nKzMd32ffMu?S6B/Z<3:PI?ngXwBPPB8,xqxww+z{' );
define( 'NONCE_KEY',        'T}fR|Rg*[s<p`r6<%$Uh5$<f6eDzERJ:Pf7x]UlY6M;HNMGL^5(Ng2tXx4|OxJTG' );
define( 'AUTH_SALT',        '!sq&>ebf,W0EetXR7=S. ~L!fHMu3hi5!UcYa`;m=Dn+{VYAMOS%q3SMXa5rW?-u' );
define( 'SECURE_AUTH_SALT', 'D&L@Kq-nr%I&tguv`xUea0}ir3DVE_+X}2l~TXfU6a#))ey^$Hb>oao?R(&uqwI/' );
define( 'LOGGED_IN_SALT',   '{V~KV73iDA7t*mOEXaAI5{L5n~n1_ds3Ii|)ktW,t^mfpd)4@O|~/+~^W5k#J[n1' );
define( 'NONCE_SALT',       'U5w-<z XoWB}/BQ+g=L9S8I&&G3*+6Id OWX=}I_l7kG`sX:AbJDpY@{?P?>Lu=~' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
