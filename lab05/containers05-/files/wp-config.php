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
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'wordpress' );

/** Database password */
define( 'DB_PASSWORD', 'wordpress' );

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
define( 'AUTH_KEY',         '*^Geftt2/{deyFbW#L.j5zq%1VK/72<?{UgYG5JKH(vz&=lC:Z-~p$@{|W>^15cl' );
define( 'SECURE_AUTH_KEY',  '3qx 1+1CtumHm?!:<E%J~?HvwihI7kBM{{%:v-~Tl3bcdW!p$V0YPg}d:/YWQ,|c' );
define( 'LOGGED_IN_KEY',    'y|nT%jNbf#PY]N]_Qp?=< {)_d %DH3T@J93[orD/hSX{E5)b>nXWKzi4&y)c1EY' );
define( 'NONCE_KEY',        '3T|t*Ji8&O.I6zdHsL*}q%G6!aKF^(<xGs_;X`B,{x]X<dik3bp7WK|M,Zt#56YK' );
define( 'AUTH_SALT',        '3(bo=cKp W%pJUHa;-TLqMc,xeS[RR7O,l,?AYna2(IM&gL:z|<&r`T;F%d!voJ1' );
define( 'SECURE_AUTH_SALT', 'Qz+23Vy/{g2V.Ti+.^Lab|ajH{SSX&.#77wsWjTAt|C;~&tQP@%KF]s~$Um1q2b|' );
define( 'LOGGED_IN_SALT',   '[%PH5/n4X<@a r?=-=shJ7ji9%X3L6|oMdU4:t7>!lyC<qvdgq~wjgvB8FZkuz|L' );
define( 'NONCE_SALT',       'XZ+)p>fckC541wWjT@J,lC>w-9ItdAkp<rBSTXpV2F8Resf*]@2,4)?/i#yt:kW/' );

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
