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
define('DB_NAME', 'ctcvn.vn');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'zy-Q/,0!2K%-)J^DSjq*cXC.ml#XBGT@z1==y.=is{qDd?ttrJ%K`pUUwB W?1!)');
define('SECURE_AUTH_KEY',  'q)WxO,2u[kSI@q$PJN@Z5)&|&/v^T1^jOb;x3(=|*`b,+$B8wqAL-[ #e02W(T~,');
define('LOGGED_IN_KEY',    '3MeQ4UKhc6-:x-a?K-xQRL~KyfcB[H;b5h2fi0Y 51y/2wD|{PdfzR_zns@u2Rt~');
define('NONCE_KEY',        ')A9]QHPdmpiB@eS?&P:Vw%{1v[9>#v+b1Ky6jc<7cUfsgHW7U2.f]E=QTh)_7u=K');
define('AUTH_SALT',        '%U=0]a]QA+UDW 0j^tJ>|5I_g{9Bc1&Th:jmhG]9m0$-q%G|`y/#dI759,?jq72~');
define('SECURE_AUTH_SALT', '!&>=V_A]V}e^W8p[61|fCwCXmvdaU40Etj9&)FGsIok%Q UV1$b|pIE0Pw*&wYH>');
define('LOGGED_IN_SALT',   '1dD7dK%gQ%Vb$SgB{ab&S9h<P`_PAE&>a-k}8T#eOPixkq^B;B,wb&dia3`83+@c');
define('NONCE_SALT',       'kIy73ssNk@)nLj?8V,Ly%7l1Mp)_y,3lmyx^_H?:F:UW#)upHx><lYCWd485hE|H');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpdt_';

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
 * 
 */
//  define('WP_ADMIN_DIR', 'minh-toi-dang-nhap');
//define( 'ADMIN_COOKIE_PATH', SITECOOKIEPATH . WP_ADMIN_DIR);

define('WP_DEBUG', false);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
