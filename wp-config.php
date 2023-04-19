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
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('FS_METHOD', 'direct');

define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         '<gsrw@#qigjK6kwVc$Y:7VM!b;$swV4}?bSJtxF[!Ne>T|E!)&qFpLOMCF){[PXY' );
define( 'SECURE_AUTH_KEY',  'bAO=[,x6gwcUu7;+3aaM1muYay52E6!,T<LOx(,Y,VxqY@=9t?/JYE{INk_SA]g0' );
define( 'LOGGED_IN_KEY',    'ddm=1Jt*SpM TY*?/RstOTkK*8X7 9 oHIDQV6/zF!260$0f}~HGRErZ,]p0.ax3' );
define( 'NONCE_KEY',        '4}^u]A[P$i!0wc>Qah}]k)dkUKm~?6W9ZGtY&]|Ojle1vVcTI11?C5^v2e>q? ?q' );
define( 'AUTH_SALT',        'SC=0|K!2XT9e;&Uq;AR1A-ni%7BRQK,LN22$?A U>O-:FAXYocz<ku?wf<xOwj^g' );
define( 'SECURE_AUTH_SALT', 'M,}cZ+`E#C{0Q+z5$YV i:hMQN&t7?b3^Yl.Q8}dgT-w-r l!lGx_Slv->,EGi<f' );
define( 'LOGGED_IN_SALT',   'Ju)&?lF/hnw9v%xi/z|qBD`Y2I&N05N:[yfK`c:s-@sG9*OAyJ/`GJ4HIQC=^br&' );
define( 'NONCE_SALT',       'e!wo12VWc66n>w6*}Q6AigxD87Swc!KqjkF1,nl0 f>YC`?<pjc&s8[LSw9X}2$t' );



/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );
define( 'SCRIPT_DEBUG', true );
/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
