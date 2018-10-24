<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'nrdevsites_com_314');

/** MySQL database username */
define('DB_USER', 'nrdevsitescom314');

/** MySQL database password */
define('DB_PASSWORD', 'Ztdcpa2H');

/** MySQL hostname */
define('DB_HOST', 'mysql.nrdevsites.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '7pcy(Vu"eMRnGzRBlO6C|X5Hi|r/q7"@2Qz5ipAZlx#9"9C~i1kZa8O@8dTAc5ic');
define('SECURE_AUTH_KEY',  '&LW_B6)42EKq+DcpOr|M_I05z8cPD$#;sj0M9``"hAd7JJ*PkD_P6y;RDA*L/aAq');
define('LOGGED_IN_KEY',    'rM)CW+::vBH`zKf#!haTmlFgl/9`I$n$JhH"K7_C1WZLev+H#U#8Fy)P5ZTCeoDo');
define('NONCE_KEY',        ')Io;Z~eUA^hB$s|duU5p82mH`"#_?+*O78V&T1v+_+~`ci!vN:9UwNsZ|q;tJ3Pr');
define('AUTH_SALT',        '16UN6a_w04o"U365vYUx7`w4@(O)CmdiDz"e9#|m"JiAKfExWl)06S7mmE3H^ywu');
define('SECURE_AUTH_SALT', '0Zngpri|P(RJvDUt0)WE9(UJYVn6tqbWmbR26w/4EoO`@2ZD/4!L$n+l830MEkTs');
define('LOGGED_IN_SALT',   'YiRtjJ5"ApWKR9?B1wyD7J`hHY0BTicjf`$wS0`$UIXpn#a3#ZOn%mhj^d;gl8M&');
define('NONCE_SALT',       'xr%r;+p4bh)`+Lj8SZ9E~jWSPRb2KgUJl6FZhIFgeQ4f#|E9Q?~bhNi;Tx1H5LC_');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_apwqde_';

/**
 * Limits total Post Revisions saved per Post/Page.
 * Change or comment this line out if you would like to increase or remove the limit.
 */
define('WP_POST_REVISIONS',  10);

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

